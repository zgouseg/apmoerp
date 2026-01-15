✅ تقرير Bugs الجديدة + التي لم تُصلّح بعد (V21)

Project: APMO ERP (v21)
Scope: Code only (تجاهلت DB/Seeder زي ما طلبت)
Focus: New bugs + still-unfixed bugs
Date: 2026-01-15

1) 🔥 CRITICAL — Livewire Sales Edit مازال “مدمّر” (Deletes Items & Payments)
📌 المسار

app/Livewire/Sales/Form.php

✅ المشكلة

عند تعديل فاتورة بيع موجودة ($this->saleId موجود)، الكود مازال يقوم بـ:

حذف كل sale_items

حذف كل sale_payments
ثم يعيد إنشاءهم من جديد.

هذا يؤدي إلى:

تدمير تاريخ المدفوعات (Audit + Financial trail)

كسر تتبع المخزون (لو فيه حركات مرتبطة)

كسر أي تكامل مع Accounting / Banking / Reconciliation

خطر ازدواج/ضياع بيانات في حالة فشل العملية بعد الحذف

🔎 الدليل (سلوك واضح)

داخل save() يوجد سلوك من نوع:

$sale->items()->delete();

$sale->payments()->delete();

✅ الحل المقترح

منع التعديل بعد حالة معينة (مثلاً posted/paid/closed)

أو استخدام Diff update على البنود بدل delete

أو تطبيق soft delete + سجل تعديل + reversal entries

2) 🔥 CRITICAL — Livewire Purchases Edit نفس المشكلة (Deletes Items)
📌 المسار

app/Livewire/Purchases/Form.php

✅ المشكلة

نفس النمط: عند تعديل Purchase موجود يتم حذف البنود بالكامل ثم إعادة إنشائها.

✅ المخاطر

فساد بيانات تكلفة المخزون

كسر GRN/Inventory movement links

خطر فقدان metadata مرتبطة بالبند

✅ الحل

نفس حل Sales: منع تعديل بعد مراحل معينة + تعديل تفاضلي + journaling.

3) 🔥 HIGH (Likely SQL Bug) — Sales Returns Search يستخدم عمود غير مضمون (code)
📌 المسار

app/Livewire/Sales/Returns/Index.php

✅ المشكلة

الـ query يعمل:

->where('code', 'like', ...)


بينما Sale نفسه لديه:

code كـ accessor مبني على reference_number (في أماكن أخرى)

وفي أغلب أجزاء النظام يتم البحث بـ reference_number

🔥 النتيجة

إذا عمود code غير موجود فعليًا في جدول الـ returns/sales returns -> سيؤدي إلى SQL error عند البحث.

✅ الحل

استبدال code بـ reference_number أو الحقل الصحيح فعليًا

أو استخدام whereRaw على accessor فقط لو مدعوم (غير مفضل)

4) 🔥 HIGH — ScheduledReportService Inventory Quantity غير Scoped بالـ Branch
📌 المسار

app/Services/ScheduledReportService.php
fetchProductsReportData()

✅ المشكلة

حساب quantity يتم عبر subquery على stock_movements:

SELECT SUM(quantity) FROM stock_movements WHERE stock_movements.product_id = products.id


بدون فلتر branch / warehouse / tenancy.

🔥 النتيجة

التقرير قد يعرض كميات خاطئة في نظام متعدد الفروع

وقد يدمج حركات مخزون من فروع مختلفة

✅ الحل

إضافة scope عبر warehouse_id المرتبط بالفرع

أو join warehouses/branches

أو تمرير branch_id في filters + تطبيقه داخل subquery

5) 🔥 CRITICAL (New) — WriteAuditTrail Listener “Queued” يفقد user/ip/branch بالكامل
📌 المسار

app/Listeners/WriteAuditTrail.php

✅ المشكلة

الـ listener يعمل implements ShouldQueue ثم داخل handle() يعتمد على:

request()

auth()->user()

في queue worker (production):

auth() غالبًا = null

request() غير موجود/فارغ
وبالتالي audit logs تنشأ بـ:

user_id = null

ip = null

user_agent = null

وبدون branch context

🔥 النتيجة

Audit Trail يصبح عديم القيمة في الإنتاج (Critical compliance bug).

✅ الحل المقترح

واحد من الاتنين:

إزالة ShouldQueue وجعل التسجيل synchronous
أو

تضمين context في event نفسه (user_id, branch_id, ip, UA) وتمريره للـ listener

6) 🔥 HIGH (New) — AuditLog يتم إنشاؤه بدون branch_id رغم أن الموديل يدعمه
📌 المسارات

app/Listeners/WriteAuditTrail.php

app/Observers/ProductObserver.php

✅ المشكلة

AuditLog model يحتوي branch_id في fillable، لكن الإنشاء لا يمررها.

🔥 النتيجة

لا يمكن فلترة أو تتبع الأحداث حسب الفرع (ERP multi-branch inconsistency).

✅ الحل

تمرير branch_id عبر:

subject branch_id إن وجد

أو request attribute (req.branch_id)

أو event context

7) 🔥 HIGH (New) — Product Active Flag غير موحد (status vs is_active) يسبب نتائج غلط
📌 مسارات مؤكدة

app/Models/Product.php → scopeActive() يستخدم:

where('status', 'active')


بينما أماكن أخرى تستخدم:

where('is_active', true)

🔥 أمثلة مباشرة
A) CacheService

app/Services/CacheService.php

getProductsForBranch() يستخدم:

Product::where('branch_id', $branchId)->where('is_active', true)

B) ProductRepository

app/Repositories/ProductRepository.php

filters تستخدم:

$query->where('is_active', (bool)$filters['is_active'])

C) ImportService

app/Services/ImportService.php

يعتبر is_active optional column للمنتج

✅ النتيجة

ممكن cache يرجع منتجات “فارغة” أو غلط

أو features تعتمد على status بينما أخرى تعتمد على is_active
=> ERP inconsistency + logic bugs

✅ الحل

توحيد مصدر الحقيقة:

إما الاعتماد على status

أو اعتماد is_active
لكن ليس الاثنين
ثم تعديل:

CacheService

ProductRepository

ImportService

8) 🟠 MEDIUM (New) — StoreOrderToSaleService يتجاهل فشل تحديث Status (silent failure)
📌 المسار

app/Services/Store/StoreOrderToSaleService.php

✅ المشكلة

بعد إنشاء Sale ناجح:

try { $order->update(['status'=>'processed']); } catch { /* ignore */ }

🔥 النتيجة

order قد يظل pending رغم إنشاء sale

يسبب ارتباك في dashboards / integrators

قد يؤدي لإعادة processing في أنظمة أخرى تعتمد على status

✅ الحل

log error على الأقل

أو لف العملية كلها في transaction

أو تعيين flag بديل / retry strategy

9) 🟠 MEDIUM (New) — API middleware لا يقوم بـ ClearBranchContext (خطر في Octane/Workers)
📌 المسار

bootstrap/app.php + middleware usage

✅ المشكلة

ClearBranchContext موجود في web middleware فقط، وليس API.

🔥 النتيجة

في بيئات long-running (Octane / Swoole / RoadRunner):

BranchContextManager قد يحتفظ بـ branch context من request سابق

يسبب data-leak أو خلط بيانات بين requests

✅ الحل

إضافة ClearBranchContext إلى api-core (أو api group) كـ terminable middleware.

10) 🟠 MEDIUM — ERP Integration Gap مازال موجود (Sales/Purchases لا تولّد Accounting Entries)
📌 أماكن مرتبطة

app/Services/AccountingService.php (يوجد methods لتوليد Journal Entry)

لكن لا يوجد Listener/Hook واضح بعد إنشاء Sale/Purchase من الـ Livewire forms لتوليد entries

🔥 النتيجة

ERP غير مترابط ماليًا:

Sales/Purchases لا تظهر في ledger تلقائيًا

Cashflow/AR/AP قد تكون غير دقيقة

✅ الحل

Event listener جديد على SaleCompleted / PurchaseReceived:

generateSaleJournalEntry()

generatePurchaseJournalEntry()

أو explicit call داخل forms حسب صلاحيات/إعدادات الحسابات

✅ ملخص سريع حسب الأولوية
Severity	Count	أهم العناصر
🔥 Critical	4	destructive edits (sales/purchases), queued audit lost context, audit logs missing branch
🔥 High	4	returns search column, scheduled reports branch mismatch, product active flag inconsistency, ERP accounting gap
🟠 Medium	2	store order status silent failure, API branch context leakage in long-running servers