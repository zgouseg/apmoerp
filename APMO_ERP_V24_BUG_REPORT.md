# تقرير Bugs — APMO ERP (v24)

**الملف المفحوص:** `apmoerpv24.zip`  
**نوع المشروع:** Laravel ERP متعدد الفروع (Multi-Branch)  

---

## 1) إصدارات Laravel / Livewire (من `composer.lock`)
- **Laravel:** `v12.44.0`
- **Livewire:** `v4.0.0-beta.5`

> ملاحظة: Livewire 4 هنا **Beta**؛ يعني أي ترقية/تغيير بسيط ممكن يكسر مكونات (Components) أو سلوك (Lifecycle). لكن التقرير أدناه يعتمد على كود المشروع الحالي (Static Review).

---

## 2) نطاق الفحص
- **تم فحصه:** الكود داخل `app/`, `routes/`, `bootstrap/`, `config/`.
- **لم يتم فحصه (حسب طلبك):** `database/` (migrations/seeders) — تم تجاهلها.
- **طريقة الفحص:** مراجعة ثابتة للكود + تتبع الترابط المنطقي بين الموديولات (مالية/مخزون/فروع) + البحث عن أخطاء أسماء الأعمدة/الحالات/الـ flows.

---

## 3) ملخص سريع
> كل البنود أدناه هي **Bugs موجودة فعليًا داخل v24** (قد تكون موجودة من إصدارات سابقة أيضًا).

- **Critical:** 5
- **High:** 6
- **Medium:** 3
- **Low:** 1

---

# 4) قائمة الـ Bugs بالتفصيل

## V24-CRIT-01 — تحويلات المخازن (Transfers) تكتمل بدون أي حركة مخزون (Stock Movements)
- **الخطورة:** Critical (مخزون/ERP Integrity)
- **الملفات:**
  - `app/Livewire/Warehouse/Transfers/Index.php` (الموافقة) **L50-L64**
  - `app/Models/Transfer.php` (لا يوجد أي منطق خصم/إضافة مخزون) — راجع أن `ship()/receive()` فقط تغير status/timestamps.
- **الدليل:**
  - عند الموافقة: يتم فقط `update(['status' => 'completed'])` بدون أي استدعاء لخدمة مخزون/إنشاء `StockMovement`. (`Index.php: L61`)
- **المشكلة:**
  - في ERP، تحويل مخزون بين مخزنين لازم ينتج عنه **خروج** من المخزن المصدر + **دخول** للمخزن الوجهة (أو على الأقل حالة `in_transit` ثم استلام).
  - الكود الحالي يجعل التحويل “منتهي” على الورق فقط، بدون تأثير فعلي على المخزون → **عدم ترابط** بين الموديول والواقع.
- **الأثر:**
  - تقارير المخزون ستكون خاطئة.
  - ممكن حدوث بيع/صرف من مخزون “لم يتحرك” فعليًا.
  - تدقيق مالي/مخزني غير موثوق.
- **اقتراح إصلاح:**
  - إما:
    1) إزالة/إخفاء موديول Transfer القديم بالكامل والاعتماد على `StockTransferService` (إن كان هو الموديول الصحيح)، أو
    2) عند `ship()` و/أو `receive()` إنشاء `StockMovement` out/in لكل Item وربطه بالـ transfer (reference_type/reference_id) وتحديث حالة التحويل بشكل صحيح.

---

## V24-CRIT-02 — صفحة Transfers تعمل Query على عمود غير موجود (`note`) → خطأ SQL
- **الخطورة:** Critical (Runtime Error)
- **الملف:** `app/Livewire/Warehouse/Transfers/Index.php`
- **المكان:** `render()` → **L102-L112**
- **الدليل:**
  - `where('note', 'like', ...)` في **L106**.
  - لكن الموديل يستخدم `notes` كعمود فعلي، و`note` مجرد accessor للتوافق الخلفي.
- **المشكلة:**
  - الاستعلام على عمود غير موجود سيؤدي إلى Exception/SQL error عند استخدام البحث.
- **الأثر:**
  - صفحة التحويلات قد تنهار بمجرد كتابة أي قيمة في البحث.
- **اقتراح إصلاح:**
  - استبدال `note` بـ `notes`:
    - `->where('notes', 'like', "%{$this->search}%")`

---

## V24-CRIT-03 — صفحة Adjustments تعمل Query على عمود غير موجود (`note`) → خطأ SQL
- **الخطورة:** Critical (Runtime Error)
- **الملف:** `app/Livewire/Warehouse/Adjustments/Index.php`
- **المكان:** `render()` → **L79-L86**
- **الدليل:**
  - `->orWhere('note', 'like', ...)` في **L84**.
  - موديول Adjustment يبدو أنه يخزن فقط `reason` (وموجود comment أن note mapped).
- **الأثر:**
  - صفحة التسويات/التعديلات قد تنهار عند البحث.
- **اقتراح إصلاح:**
  - إزالة شرط `note` تمامًا أو تحويله للبحث داخل `reason` فقط.

---

## V24-CRIT-04 — PurchaseReturnService: مفاتيح غير مُتحقق منها + Nullable تُستخدم مباشرة → Undefined index / Crash
- **الخطورة:** Critical (Runtime + Returns Workflow Broken)
- **الملف:** `app/Services/PurchaseReturnService.php`
- **المكان:** `createReturn()` → **L40-L94**
- **الدليل (أمثلة):**
  - لا يوجد validation لـ `items.*.purchase_item_id`، لكن يتم استخدامها مباشرة: `'$itemData['purchase_item_id']'` في **L83**.
  - `items.*.unit_cost` و `items.*.condition` معرفين كـ `nullable` لكن يتم استخدامهم مباشرة بدون `?? null`:
    - `unit_cost` في **L86**
    - `condition` في **L87**
  - في Laravel، الحقول nullable إذا لم تُرسل من الـ request عادةً **لن تكون موجودة** في `$validated` → فينتج Undefined index.
- **الأثر:**
  - إنشاء Purchase Return قد يفشل فورًا في وقت التشغيل.
  - حتى لو نجح، البيانات قد تكون ناقصة وغير صحيحة.
- **اقتراح إصلاح:**
  1) إضافة validation صريح:
     - `items.*.purchase_item_id => required|integer|exists:purchase_items,id`
  2) استخدام null coalescing لكل الحقول nullable:
     - `'unit_cost' => $itemData['unit_cost'] ?? 0`
     - `'condition' => $itemData['condition'] ?? null`

---

## V24-CRIT-05 — Purchase Returns (Livewire) تغيّر حالة الشراء إلى `returned` بدون أي خصم مخزون/قيود مالية
- **الخطورة:** Critical (Inventory/Finance Integrity)
- **الملف:** `app/Livewire/Purchases/Returns/Index.php`
- **المكان:** `processReturn()` → **L148-L177**
- **الدليل:**
  - يتم إنشاء `ReturnNote` ثم مباشرة:
    - `$purchase->status = 'returned'; $purchase->save();` (**L175-L176**)
  - لا يوجد أي:
    - إنشاء Debit Note (للمورد)
    - حركة مخزون خروج من المخزن
    - إعادة ربط العناصر المرجعة كـ line items للـ ReturnNote
- **الأثر:**
  - المشتريات تصبح `returned` على الورق، بينما المخزون والذمم لا تتغير.
  - عدم ترابط ERP واضح.
- **اقتراح إصلاح:**
  - ربط هذا الـ flow بـ `PurchaseReturnService` (بعد إصلاحه) أو تنفيذ نفس منطق: إنشاء return items + خصم مخزون + إنشاء DebitNote/قيد.
  - على الأقل: لا تغيّر حالة الشراء إلى `returned` إلا بعد اعتماد/إتمام return فعلي.

---

## V24-HIGH-01 — Transfer Items لا تسجل `unit_cost` ⇒ قيمة التحويل `total_value` تصبح 0 أو خاطئة
- **الخطورة:** High (Costing/Reports)
- **الملفات:**
  - `app/Livewire/Warehouse/Transfers/Form.php` **L132-L138**
  - `app/Models/Transfer.php` **L214-L218**
- **الدليل:**
  - `TransferItem::create([... 'quantity' => $item['qty'] ...])` بدون `unit_cost`.
  - بينما الحساب يعتمد على: `SUM(quantity * unit_cost)`.
- **الأثر:**
  - تقارير التكلفة/القيمة للتحويلات غير صحيحة.
- **اقتراح إصلاح:**
  - عند إنشاء TransferItem، خزّن `unit_cost` من تكلفة المنتج (متوسط/آخر شراء/standard cost حسب سياستك).
  - أو غيّر حساب total_value ليعتمد على مصدر آخر إن لم تكن تريد `unit_cost` هنا.

---

## V24-HIGH-02 — Transfer Form لا تتحقق أن warehouses ضمن نفس branch (Server-side) → فساد بيانات Multi-Branch
- **الخطورة:** High (Data Integrity)
- **الملف:** `app/Livewire/Warehouse/Transfers/Form.php`
- **المكان:** validation في `save()` **L90-L98**
- **المشكلة:**
  - يوجد فقط `exists:warehouses,id` بدون أي شرط أن `from_warehouse_id` و `to_warehouse_id` تابعين لنفس `branch_id` الخاصة بالمستخدم.
  - الـ UI يعرض warehouses حسب branch، لكن attacker/طلب معدل يمكنه إرسال IDs من فروع أخرى.
- **الأثر:**
  - Transfer قد يُسجل بـ `branch_id` فرع المستخدم لكن warehouses من فرع مختلف → بيانات غير مترابطة.
- **اقتراح إصلاح:**
  - بعد validation، اعمل تحقق إضافي:
    - جلب المخزنين من DB والتحقق أن `warehouse->branch_id === $user->branch_id`.

---

## V24-HIGH-03 — Banking Reconciliation: حساب الفرق (difference) يتجاهل system balance
- **الخطورة:** High (Finance Logic)
- **الملف:** `app/Livewire/Banking/Reconciliation.php`
- **المكان:** `calculateSummary()` **L239-L257**
- **الدليل:**
  - يتم حساب `systemBalance` في **L253-L255**
  - لكن `difference` تحسب: `statementBalance - matchedTotal` (**L256**) وتترك systemBalance بلا استخدام.
- **لماذا مشكلة؟**
  - عادةً الفرق يكون بين **رصيد النظام** و **رصيد كشف الحساب** بعد مطابقة الحركات، أو صيغة مكافئة.
  - الشكل الحالي غالبًا سيعطي فرقًا خاطئًا.
- **اقتراح إصلاح (عام):**
  - راجع المعادلة المطلوبة لنظامك، مثال شائع:
    - `difference = statementBalance - systemBalance` (بعد تعليم معاملات reconciled)
    - أو `difference = (openingBalance + matchedNet) - statementBalance`.

---

## V24-HIGH-04 — Sales: يتم إعادة ضبط `sale_date` لليوم الحالي عند التعديل
- **الخطورة:** High (Finance/Audit)
- **الملف:** `app/Livewire/Sales/Form.php`
- **المكان:** بناء `$saleData` **L370-L389**
- **الدليل:**
  - `sale_date => now()->toDateString()` في **L382** حتى في وضع التعديل.
- **الأثر:**
  - تغيير تاريخ البيع الأصلي عند أي تعديل → تقارير الفترة/الإقفال/الضرائب تصبح خاطئة.
- **اقتراح إصلاح:**
  - في editMode استخدم التاريخ الموجود أو المدخل من المستخدم:
    - `sale_date => $this->sale_date ?? $this->sale->sale_date`.

---

## V24-HIGH-05 — Purchases: يتم إعادة ضبط `purchase_date` لليوم الحالي عند التعديل
- **الخطورة:** High (Finance/Audit)
- **الملف:** `app/Livewire/Purchases/Form.php`
- **المكان:** بناء `$purchaseData` **L300-L318**
- **الدليل:**
  - `purchase_date => now()->toDateString()` في **L309** حتى في وضع التعديل.
- **الأثر:**
  - نفس مشكلة Sales: تقارير وحسابات الفترة ستتشوه.

---

## V24-HIGH-06 — POS Close Day يعتمد على `created_at` بدل تاريخ البيع الفعلي (`sale_date`)
- **الخطورة:** High (Finance / Day Closing)
- **الملف:** `app/Services/POSService.php`
- **المكان:** `closeDay()` **L442-L464**
- **الدليل:**
  - تصفية المبيعات بـ: `whereDate('created_at', $date)` (**L443-L445**) وكذلك عند حساب receipts (**L459-L464**).
- **الأثر:**
  - لو عندك مبيعات بتاريخ بيع مختلف عن created_at (Backdate/Import)، الإقفال اليومي سيحسب يوم خطأ.
- **اقتراح إصلاح:**
  - استخدام `sale_date` أو “business_date” بدل created_at.

---

## V24-HIGH-07 — PurchaseReturnService: تحديث SupplierPerformanceMetric يستخدم أسماء حقول غير مطابقة للموديل + لا يحدد branch_id
- **الخطورة:** High (Reports/Branch Integrity)
- **الملفات:**
  - `app/Services/PurchaseReturnService.php` **L277-L316**
  - `app/Models/SupplierPerformanceMetric.php` (fillable/casts)
- **المشاكل:**
  1) `firstOrCreate` يمرر defaults مثل:
     - `total_items_ordered`, `total_items_returned`, `defect_rate` (**L285-L290**) 
     بينما الموديل fillable يحتوي على:
     - `total_ordered_qty`, `total_received_qty`, `total_rejected_qty`, `quality_acceptance_rate`...
     → هذه الحقول قد تُتجاهل أو تسبب أخطاء حسب الـ schema.
  2) لا يتم وضع `branch_id` عند إنشاء metric.
     - وبما أن SupplierPerformanceMetric يستخدم `HasBranch`، وجود `branch_id = null` قد يجعل السجل غير مرئي بسبب BranchScope.
- **اقتراح إصلاح:**
  - توحيد أسماء الحقول لتطابق الموديل/الجدول.
  - تحديد `branch_id` (من purchase/return أو من branch context).

---

## V24-MED-01 — HRM Employees: رسالة النجاح دائمًا “updated” حتى عند الإنشاء
- **الخطورة:** Medium (UX/Logic)
- **الملف:** `app/Livewire/Hrm/Employees/Form.php`
- **المكان:** بعد الحفظ **L182-L189**
- **الدليل:**
  - يتم تعيين `$this->employeeId = $employee->id;` ثم يتم اختبار `$this->employeeId ? updated : created`.
  - النتيجة: دائمًا Updated.
- **اقتراح إصلاح:**
  - احفظ flag قبل التعيين:
    - `$isNew = ! $this->employeeId; ... $this->employeeId = $employee->id; ... flash($isNew ? created : updated)`

---

## V24-MED-02 — Adjustment Form: حقل note يتم دمجه داخل reason → تلوث البيانات
- **الخطورة:** Medium (Data Quality)
- **الملف:** `app/Livewire/Warehouse/Adjustments/Form.php`
- **المشكلة:**
  - يوجد `note` بالواجهة لكن الموديل فعليًا يخزن `reason` فقط.
  - الكود يدمج النصين داخل `reason`.
- **الأثر:**
  - البحث/التقارير على reason تصبح أقل دقة.
  - المستخدم يفقد معنى reason الأصلي.
- **اقتراح إصلاح:**
  - إما إزالة note من UI، أو إضافة عمود `notes` فعلي (في migration) ثم تخزينه منفصل.

---

## V24-MED-03 — ProductObserver: حذف صور/جاليري المنتج قد لا يعمل لأن الحقول ليست Casted إلى arrays
- **الخطورة:** Medium (Storage Leak)
- **الملف:** `app/Observers/ProductObserver.php`
- **المكان:** `deleteMediaFiles()` **L85-L111**
- **المشكلة:**
  - الكود يحذف gallery فقط إذا كانت `is_array($product->images)` أو `is_array($product->gallery)`.
  - `app/Models/Product.php` لا يحتوي casts لهذه الحقول → لو مخزنة JSON string فلن تُحذف.
- **اقتراح إصلاح:**
  - إضافة casts في Product:
    - `protected $casts = ['images' => 'array', 'gallery' => 'array'];` (إذا الأعمدة موجودة JSON)
  - أو تعديل observer ليتعامل مع JSON string.

---

## V24-LOW-01 — Transfers: approve/cancel لا يسجل معلومات اعتماد/تدقيق (audit meta)
- **الخطورة:** Low
- **الملف:** `app/Livewire/Warehouse/Transfers/Index.php`
- **المكان:** `approve()` / `cancel()` **L50-L79**
- **المشكلة:**
  - يتم تغيير status فقط بدون `updated_by` أو `shipped_by/received_by` أو timestamps مرتبطة.
- **اقتراح إصلاح:**
  - استخدام methods بالموديل (`ship()/receive()`) أو تحديث حقول audit عند تغيير الحالة.

---

# 5) ملاحظات ختامية مهمة
- البنود أعلاه هي **Bugs حالية داخل v24**. لم أُدرج أي بند تم إصلاحه بالفعل.
- بعض هذه الأخطاء “Business/Critical” (مخزون/مرتجعات/إقفال يومي) وتحتاج قرار تصميم: هل هذه الموديولات فعليًا مستخدمة أم قديمة؟
  - لو **قديمة**: الأفضل إخفاؤها/إزالتها لتجنب فساد البيانات.
  - لو **مستخدمة**: يلزم ربطها بموديولات المخزون/القيود/الذمم بشكل صريح.

---

## Appendix — أماكن السطور (Line references) التي تم الاعتماد عليها
- Transfers search on wrong column:
  - `app/Livewire/Warehouse/Transfers/Index.php:L102-L112`
- Transfers approve without stock:
  - `app/Livewire/Warehouse/Transfers/Index.php:L50-L64`
- Adjustments search on wrong column:
  - `app/Livewire/Warehouse/Adjustments/Index.php:L79-L86`
- Transfer items missing unit_cost:
  - `app/Livewire/Warehouse/Transfers/Form.php:L132-L138`
  - `app/Models/Transfer.php:L214-L218`
- PurchaseReturnService undefined index:
  - `app/Services/PurchaseReturnService.php:L40-L94`
  - inventory adjust stub: `app/Services/PurchaseReturnService.php:L254-L268`
- Purchase returns sets purchase status returned:
  - `app/Livewire/Purchases/Returns/Index.php:L148-L177`
- Banking reconciliation difference formula:
  - `app/Livewire/Banking/Reconciliation.php:L239-L257`
- Sales/Purchases overwrite dates:
  - `app/Livewire/Sales/Form.php:L370-L389`
  - `app/Livewire/Purchases/Form.php:L300-L318`
- POS closeDay uses created_at:
  - `app/Services/POSService.php:L442-L464`
- HRM flash message logic:
  - `app/Livewire/Hrm/Employees/Form.php:L182-L189`
- ProductObserver gallery deletion conditions:
  - `app/Observers/ProductObserver.php:L85-L111`
