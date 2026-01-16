# APMO ERP (v26) — Bug Report (New + Still-Unfixed Only)

**Scope**: Static code review (قراءة كود فقط). **DB / migrations / seeders** تم تجاهلهم حسب طلبك.

## Detected versions (from `composer.lock`)
- Laravel Framework: **v12.44.0**
- Livewire: **v4.0.0-beta.5**

---

## ملخص سريع
- **Bank Reconciliation** ما زال به خطأ منطقي: قيمة `difference` لا تعتمد على صافي الـ **matched transactions**، والـ UI نفسه يحسب مجموع matched بطريقة غير صحيحة (لا يراعي الإيداع/السحب).
- **Transfers (Warehouse)**: زر/عملية `approve` غير **idempotent** (لو اتضغطت مرتين/تكررت request) هتتسجل **stock movements مرتين** ويتضاعف المخزون.
- **Sales Returns**: حركة المخزون للمرتجعات تستخدم `unit_cost = unit_price` (تسعير تكلفة المخزون غلط) + ما زال مفيش جدول/كيان واضح لحفظ تفاصيل أصناف المرتجع (اعتماد على StockMovements كبديل غير مكتمل).
- **Void Sale**: عكس حركة المخزون يتم بـ `StockMovement::create()` مباشرة (تجاوز Repository) مما قد يسبب عدم اتساق في `stock_before/stock_after` وقواعد القفل/التحديث.
- **Store Sync**: قراءة `$lineItem['product_id']` بدون guard قد تكسر sync في حالات Shopify line_items غير القياسية.

---

## 1) Bugs ما زالت موجودة (Unfixed / Still present)

### V26-CRIT-01 — Reconciliation `difference` لا يعتمد على matchedTotal + UI تحذير مضلل
**Severity**: CRITICAL (Finance/Logic)

**Where**
- `app/Livewire/Banking/Reconciliation.php` (calculateSummary)
- `resources/views/livewire/banking/reconciliation.blade.php`

**Evidence (code)**
- Backend يحسب `matchedTotal` لكنه **لا يستخدمه**، ثم يحسب `difference` من systemBalance بدل صافي matched:
  - `app/Livewire/Banking/Reconciliation.php` L243–L260
- UI يقول صراحة إن الفرق بين statement balance و matched transactions:
  - `resources/views/livewire/banking/reconciliation.blade.php` L227–L231

**Why it’s a bug**
- المستخدم يتوقع أن اختيار/إلغاء اختيار معاملات سيغير `difference` (لأن reconciliation هي مطابقة معاملات الفترة). لكن الواقع: `difference` مرتبط بـ `current_balance`.

**Impact**
- Reconciliation تصبح غير موثوقة؛ ممكن المستخدم “يوازن” matched لكن الفرق لا يتغير.

**Suggested fix**
- تحديد تعريف موحد:
  - إما: `difference = statementBalance - (openingBalance + matchedNet)`
  - أو: لو الهدف مقارنة statement ending balance مع system ending balance، إذن يجب إزالة “matched transactions” من المعادلة والواجهة/التحذير.
- على الأقل: استخدم `matchedTotal` في حساب واضح، أو غيّر نصوص الواجهة.

---

### V26-HIGH-02 — UI: Matched Transactions Total يحسب مجموع غير موقّع (withdrawals تظهر كإيجابي)
**Severity**: HIGH (Finance/UI Logic)

**Where**
- `resources/views/livewire/banking/reconciliation.blade.php`

**Evidence**
- `collect($matchedTransactions)->sum('amount')` لا يراعي نوع المعاملة (deposit vs withdrawal):
  - `resources/views/livewire/banking/reconciliation.blade.php` L211–L213

**Impact**
- المستخدم يشوف “Matched Total” غلط، وبالتالي قرارات reconcile خاطئة.

**Suggested fix**
- استخدم نفس منطق الـ backend (signed amounts) في العرض، أو مرّر `matchedTotal` من component.

---

### V26-HIGH-03 — Sales Return: استخدام `unit_cost = unit_price` في stock movement (تكلفة المخزون غلط)
**Severity**: HIGH (Finance/Inventory Valuation)

**Where**
- `app/Services/SaleService.php`

**Evidence**
- إنشاء stock movement للمرتجع مع:
  - `unit_cost' => $itemData['unit_price']`
  - `app/Services/SaleService.php` L169–L180

**Why it’s a bug**
- `unit_price` هو سعر بيع، وليس تكلفة المخزون. في ERP تكلفة المرتجع عادةً ترجع المخزون بتكلفة (FIFO/AVG/Last cost) أو بتكلفة مرتبطة بالـ batch.

**Impact**
- COGS / inventory valuation / profitability reports تصبح غير دقيقة.

**Suggested fix**
- جلب تكلفة مناسبة (آخر تكلفة شراء/متوسط/دفعة/Batch cost) بدلاً من سعر البيع.

---

### V26-HIGH-04 — Sales Return ما زال بلا Item-level persistence واضح (اعتماد على StockMovements كبديل غير مكتمل)
**Severity**: HIGH (Auditability/ERP Integrity)

**Where**
- `app/Services/SaleService.php`

**Evidence**
- الكود نفسه يصرّح إن الحل “تقريبي” وأن المطلوب الحقيقي return_items table:
  - `app/Services/SaleService.php` L242–L260

**Impact**
- صعب جداً تعمل تتبع رسمي لمرتجع (أي صنف/كمية/سبب) من ReturnNote فقط.
- أي تعديل/حذف في StockMovements يؤثر على “حساب المرتجع السابق” ويكسر منع الـ over-return.

**Suggested fix**
- إضافة كيان/جدول `return_note_items` (أو equivalent) وربطه بـ ReturnNote + SaleItem، واستخدامه للحساب بدلاً من StockMovements.

---

## 2) Bugs جديدة (New in v26 / Not addressed)

### V26-CRIT-02 — Transfer Approve غير idempotent: تكرار approve يضاعف stock movements والمخزون
**Severity**: CRITICAL (Inventory Integrity)

**Where**
- `app/Livewire/Warehouse/Transfers/Index.php`

**Evidence**
- لا يوجد أي تحقق من `status` قبل إنشاء حركات المخزون.
- إنشاء حركتين لكل item ثم تحديث status:
  - `app/Livewire/Warehouse/Transfers/Index.php` L52–L118

**Exploit / Repro**
- اضغط Approve مرتين (أو أعد إرسال request) → سيتم إنشاء نفس الحركات مرة أخرى.

**Impact**
- مخزون warehouse المصدر ينقص مرتين، والوجهة تزيد مرتين.
- تقارير المخزون/التكلفة تتخرب.

**Suggested fix**
- قبل transaction: تأكد أن `status` يسمح (`pending` أو `in_transit`) وامنع approve لو `completed/cancelled`.
- أو اجعل العملية idempotent بالتحقق من وجود StockMovements مرجعية قبل الإنشاء:
  - مثال: `where reference_type='transfer' and reference_id=$transfer->id and movement_type in (...)`.

---

### V26-HIGH-05 — StockMovement `source()` polymorphic قد لا يعمل بسبب reference_type قيم نصية بدون morphMap
**Severity**: HIGH (Runtime/Domain Modeling)

**Where**
- `app/Models/StockMovement.php`
- أمثلة إنشاء `reference_type` كنص: `sale_item`, `transfer`, `return_note`, ...

**Evidence**
- `source()` تستخدم `morphTo()` على `reference_type/reference_id`:
  - `app/Models/StockMovement.php` L81–L84
- بينما في Transfers يتم تخزين `reference_type => 'transfer'`:
  - `app/Livewire/Warehouse/Transfers/Index.php` L88–L105

**Why it’s a bug**
- Laravel morphTo يتوقع `reference_type` يكون **Class name** أو alias موجود في `Relation::morphMap()`.
- لا يوجد `morphMap` واضح بالمشروع (لم يتم العثور على `morphMap` في `app/`).

**Impact**
- أي استدعاء `$movement->source` ممكن يرجع null أو يعمل mapping غلط، وبالتالي تقارير/روابط المصدر تتكسر.

**Suggested fix**
- حلان واضحان:
  1) توحيد `reference_type` ليكون Class FQCN دائماً (مثل `App\Models\SaleItem::class`).
  2) أو تعريف `Relation::morphMap([...])` لكل aliases المستخدمة (`sale_item`, `transfer`, ...).

---

### V26-HIGH-06 — voidSale ينشئ StockMovement reversal بـ `StockMovement::create()` (تجاوز Repository)
**Severity**: HIGH (Inventory Consistency / Concurrency)

**Where**
- `app/Services/SaleService.php`

**Evidence**
- إنشاء حركة reversal مباشرة:
  - `app/Services/SaleService.php` L299–L308

**Why it’s a bug**
- المشروع عنده `StockMovementRepositoryInterface` من أجل:
  - حساب وتخزين `stock_before/stock_after`
  - locking ومنع race conditions
  - تحديث رصيد المنتج/المخزون المجمّع
- تجاوز الـ repository هنا يجعل reversal مختلفة عن باقي الحركات (خصوصاً لو reports تعتمد على stock_before/after).

**Suggested fix**
- استخدم `StockMovementRepositoryInterface->create()` بدلاً من `StockMovement::create()`.
- وطبّق نفس منطق الـ listener (unique checks / consistent reference_type).

---

### V26-MED-07 — StoreSyncService: استخدام `$lineItem['product_id']` بدون guard
**Severity**: MEDIUM (Robustness/Integration)

**Where**
- `app/Services/Store/StoreSyncService.php`

**Evidence**
- الاستعلام يستخدم index مباشرة:
  - `->where('external_id', (string) $lineItem['product_id'])`
  - `app/Services/Store/StoreSyncService.php` L415–L418

**Impact**
- في Shopify، بعض line_items قد تكون بدون `product_id` (custom items / gifts / adjustments). هذا يؤدي إلى PHP notice وقد يقطع الـ job حسب إعدادات error handling.

**Suggested fix**
- استخدم:
  - `$externalProductId = $lineItem['product_id'] ?? null; if (! $externalProductId) continue;`

---

### V26-MED-08 — Sales/Purchases edit mode ما زال يعتمد على delete+recreate للـ items
**Severity**: MEDIUM (ERP Integrity/Audit)

**Where**
- `app/Livewire/Sales/Form.php` (edit mode)
- `app/Livewire/Purchases/Form.php` (edit mode)

**Evidence**
- Sales:
  - `$sale->items()->delete();` — `app/Livewire/Sales/Form.php` L424–L429
- Purchases:
  - `$purchase->items()->delete();` — `app/Livewire/Purchases/Form.php` L343–L348

**Why it’s risky في ERP**
- حتى لو منعت تعديل حالات معينة، حذف items يغير IDs ويكسر أي ربط لاحق (deliveries, returns, stock movements references, audit logs, attachments... إلخ) لو تم إنشاء مراجع قبل الإغلاق.

**Suggested fix**
- تحديث/مزامنة items بدلاً من الحذف، أو على الأقل soft-delete + حفظ mapping، أو منع أي ربط خارجي قبل الإغلاق.

---

### V26-MED-09 — Transfer Approve يضبط shipped_at وreceived_at بنفس اللحظة ويتخطى lifecycle
**Severity**: MEDIUM (Process/Reporting)

**Where**
- `app/Livewire/Warehouse/Transfers/Index.php`

**Evidence**
- يتم ضبط:
  - `status = completed`, `shipped_at = now()`, `received_at = now()`
  - `app/Livewire/Warehouse/Transfers/Index.php` L111–L117

**Impact**
- لا يوجد مفهوم “in transit” فعلي أو زمن شحن/استلام، ولا يدعم partial receiving.
- تقارير lead time وعمليات المراجعة تصبح غير دقيقة.

**Suggested fix**
- فصل approve إلى خطوات: ship → in_transit ثم receive → completed.
- أو على الأقل حفظ timestamps واقعية حسب إجراء المستخدم.

---

## ملاحظات ختامية
- التقرير أعلاه يتضمن فقط **Bugs جديدة** أو **ما زال موجوداً** في v26. (لم أعد ذكر البنود التي تبدو أنها اتصلحت مقارنةً بالإصدارات السابقة، مثل إنشاء stock movements الأساسي في transfer approvals).

MD