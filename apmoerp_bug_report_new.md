# تقرير Bugs (الجولة الثانية) — apmoerp.zip

> **ملاحظة مهمة:** هذا التقرير يحتوي **فقط** على:
> 1) Bugs جديدة تم اكتشافها في هذا الفحص، و  
> 2) Bugs ما زالت موجودة (لم يتم إصلاحها بعد) من التقرير السابق.  
> ولن أكرر البنود التي تأكدت أنها **تم إصلاحها**.

- تاريخ الفحص: 2026-01-13 12:14 UTC
- المشروع: ERP متعدد الفروع (Multi-Branch)
- نطاق الفحص: أكواد المشروع (PHP/Livewire/Services/Controllers). *(تم تجاهل seeders قدر الإمكان، لكن تم الإشارة لأي استدعاءات تؤدي لأخطاء Runtime بسبب أعمدة/حقول غير متوافقة)*

---

## 1) Bugs حرجة جدًا (Critical)

### CR-01 — **تسريب بيانات/كسر عزل الفروع في الـ Console + الـ Queue Workers**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Models/Scopes/BranchScope.php`  
- السطور: 34-36  
- المشكلة: الـ Global Scope الخاص بالفروع يتم **تعطيله بالكامل** عند `app()->runningInConsole()`، وبالتالي أي Job/Queue worker أو أي تشغيل من الـ CLI سيعمل بدون عزل الفروع.
- التأثير:
  - تقارير/Jobs/Imports/Commands قد تقرأ/تعدّل بيانات **كل الفروع** بدل فرع واحد.
  - خطورة عالية جدًا في ERP متعدد الفروع.

---

### CR-02 — **تطبيق BranchScope على موديل Branch نفسه (فلترة على `branches.branch_id`)**
- الحالة: **جديدة** (لكن سببها تصميم/Scope قديم)
- الملفات:
  - `app/Models/BaseModel.php` (سطر 37: استخدام `HasBranch`)
  - `app/Models/Branch.php` (لا يحتوي `branch_id` في `$fillable`)
  - `app/Models/Scopes/BranchScope.php` (دالة `hasBranchIdColumn()` تعتمد على وجود `branch()` وليس على وجود عمود فعلي)
- المشكلة:
  - لأن `BaseModel` يستخدم `HasBranch`، فـ `Branch` يرث `branch()` وبالتالي `BranchScope` يعتبره “Branch-aware”.
  - هذا يؤدي إلى بناء Queries تحتوي على: `where branches.branch_id in (...)`  
  - وهذا **غير منطقي** لموديل الفروع نفسه، وغالبًا سيؤدي إلى SQL Error أو نتائج خاطئة.
- أماكن يتوقع أن تتعطل فعليًا:
  - مثال واضح: `app/Http/Controllers/Api/V1/POSController.php` يستخدم `Branch::query()` (أسطر 53-71).

---

### CR-03 — **تقرير “Top Products” في ReportService سيكسر SQL (عمود `sale_items.qty`)**
- الحالة: **جديدة**
- الملف: `app/Services/ReportService.php`  
- السطور: 67-75  
- المشكلة: الاستعلام يستخدم `SUM(si.qty*si.unit_price)` بينما الموديل/الأكواد الأخرى تستخدم `sale_items.quantity` وليس `qty`.
- التأثير:
  - Endpoint/Report `topProducts()` سيفشل بـ SQL error.
  - هذا سيكسر `ReportsController` لأنه يعتمد على `ReportServiceInterface::topProducts()`.

---

### CR-04 — **ملخص تقارير المبيعات/المشتريات في ReportService يعطي أرقام مالية = 0 أو خاطئة**
- الحالة: **جديدة**
- الملف: `app/Services/ReportService.php`  
- السطور:
  - Sales summary: 213-220  
  - Purchases summary: 309-315
- المشكلة:
  - `ReportService` يجلب البيانات عبر `DB::table(...)->get()` وبالتالي العناصر تكون `stdClass` (بدون Accessors).
  - ثم يحاول حساب:
    - `sum('grand_total')`, `sum('amount_paid')`, `sum('amount_due')`
  - هذه حقول **ليست موجودة** في نتيجة `sales.*` / `purchases.*` (والـ accessors الموجودة في Models لا تعمل هنا).
- التأثير:
  - تقارير مالية خاطئة بالكامل (Totals = 0 أو غير صحيحة).
  - أخطر نوع Bugs (Finance Bugs) لأنها تخدع الإدارة/المحاسبة.

---

### CR-05 — **KPIDashboardService: أعمدة غير موجودة (`products.qty` و `reorder_level`)**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Services/Analytics/KPIDashboardService.php`  
- السطور: 96-127  
- المشكلة:
  - `outOfStockProducts` يعتمد على `where('qty', '<=', 0)`
  - `lowStockProducts` يعتمد على `whereColumn('qty','<=','reorder_level')`
- التأثير:
  - SQL errors في شاشة الـ KPI Dashboard.
  - أو نتائج خاطئة لو الأعمدة غير موجودة.

---

### CR-06 — **InventoryReportsExportController يستخدم أعمدة غير متوافقة (`stock_qty`, `reorder_level`, `default_branch_id`)**
- الحالة: **جديدة**
- الملف: `app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php`  
- السطور: 38-41, 67-73  
- المشكلة:
  - فلترة بعمود `default_branch_id` بدل `branch_id`
  - اعتماد على `stock_qty` و `reorder_level` بينما باقي النظام يستخدم `stock_quantity` و `reorder_point/min_stock/...`
- التأثير:
  - تصدير مخزون Admin Reports قد يفشل Runtime أو يعطي بيانات غير صحيحة.

---

### CR-07 — **CashFlowForecastService يعتمد على أعمدة غير موجودة (`payment_due_date`, `due_total`)**
- الحالة: **جديدة**
- الملف: `app/Services/Reports/CashFlowForecastService.php`  
- السطور: 17-55  
- المشكلة:
  - `Sale::... whereNotNull('payment_due_date')` و `where('due_total','>',0)`  
  - هذه Accessors في `Sale` (وحتى لو موجودة كـ Accessor فهي لا تعمل في Query Builder).
- التأثير:
  - خدمة Cashflow Forecast ستفشل بـ SQL error أو سترجع بيانات فارغة/خاطئة.

---

### CR-08 — **AutomatedAlertService يستخدم `payment_due_date` داخل Query**
- الحالة: **جديدة**
- الملف: `app/Services/AutomatedAlertService.php`  
- السطور: 84-87  
- المشكلة: `whereNotNull('payment_due_date')` داخل Query على `Sale`.
- التأثير: Alerts الخاصة بالمستحقات ستفشل أو لا تعمل.

---

### CR-09 — **SmartNotificationsService يستخدم `due_total` داخل Query**
- الحالة: **جديدة**
- الملف: `app/Services/SmartNotificationsService.php`  
- السطور: 149-156  
- المشكلة: `->where('due_total', '>', 0)` على `Sale` (عمود غير موجود/Accessor فقط).
- التأثير:
  - إشعارات “فواتير متأخرة” لن تعمل أو ستكسر.

---

### CR-10 — **CustomerPortalController: البحث على عمود `sales.code` + إحصائيات Pending**
- الحالة: **جديدة**
- الملف: `app/Http/Controllers/Portal/CustomerPortalController.php`  
- السطور: 108-109  
- المشكلة:
  - `->where('code', 'like', ...)` (غالبًا لا يوجد عمود `code` في sales — الموجود `reference_number`، و`code` مجرد accessor في الـ Model)
- التأثير:
  - صفحة بوابة العميل Search/Filters قد تفشل بـ SQL error.

---

### CR-11 — **CommandPalette: Query يستخدم عمود `reference_no` (غير موجود)**
- الحالة: **جديدة**
- الملف: `app/Livewire/CommandPalette.php`  
- السطور: 201-203  
- المشكلة: `Sale::...->orWhere('reference_no', 'like', ...)`  
  - `reference_no` موجود كـ **Accessor** فقط في `Sale`، وليس كعمود (على الأغلب).
- التأثير:
  - Command Palette search على المبيعات سيفشل.

---

### CR-12 — **ReportsController: stockAging يفلتر على `stock_movements.branch_id`**
- الحالة: **جديدة**
- الملف: `app/Http/Controllers/Branch/ReportsController.php`  
- السطور: 48-52  
- المشكلة: `->where('m.branch_id', $branchId)` مع أن أغلب أجزاء النظام تتعامل مع stock_movements بدون branch_id وتفلتر عبر المنتجات/المخازن.
- التأثير:
  - تقرير Stock Aging قد يفشل أو يعطي نتائج = 0.

---

### CR-13 — **AccountingService: قيود يومية غير متوازنة مع السداد الجزئي + لا يوجد Validate قبل “posted”**
- الحالة: **غير مُصلَح** (من التقرير السابق — ما زال قائم)
- الملف: `app/Services/AccountingService.php`  
- السطور:
  - إنشاء القيد بحالة `posted`: 34-38
  - معالجة payments بدون إثبات المتبقي كـ Receivable: 64-109
  - وجود validateBalance لكن غير مستخدم هنا: 253-287
- المشكلة (Finance):
  1) لو فيه Payments جزئية: يتم عمل Debit فقط بمجموع المدفوعات، لكن يتم Credit بالإيراد (subtotal) + ضريبة… بدون إثبات المتبقي كـ Accounts Receivable → القيد غير متوازن.
  2) يتم إنشاء القيد مباشرة بحالة `posted` بدون التأكد من الاتزان.
- التأثير:
  - فساد محاسبي (Journal Entries غير متوازنة).
  - أخطر Bug مالي لأنه ينتج بيانات دفاتر خاطئة.

---

## 2) Bugs عالية (High)

### H-01 — **HasBranch لا يضمن تعيين `branch_id` عند الإنشاء (قد يُنشئ سجلات بدون فرع)**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Traits/HasBranch.php`  
- السطور: 30-36  
- المشكلة: التعيين التلقائي يعتمد على `method_exists($model, 'currentBranchId')`، بينما أغلب الموديلات (خصوصًا الوراثة من BaseModel) لا تضيف `currentBranchId()` بشكل مباشر.
- التأثير:
  - سجلات بـ `branch_id = NULL` أو فرع خاطئ.
  - مع وجود Global Scope، هذه السجلات قد “تختفي” من الواجهة أو تظهر لغير فرعها.

---

### H-02 — **POSService: Idempotency check غير مربوط بالفرع**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Services/POSService.php`  
- السطور: 42-48  
- المشكلة: `Sale::where('client_uuid', $clientUuid)->first()` بدون `branch_id`/session/user.
- التأثير:
  - POS في فرع A قد يمنع/يُعيد نفس sale من فرع B لو تصادف نفس UUID.
  - في ERP متعدد الفروع هذا خطر (Data Integrity + Cross-Branch collisions).

---

### H-03 — **PurchaseService: `total_amount` لا يشمل الضرائب/الخصومات/الشحن**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Services/PurchaseService.php`  
- السطور: 104-106  
- المشكلة: `total_amount = subtotal` فقط.
- التأثير:
  - أرقام مشتريات غير دقيقة (Finance bug).
  - سيؤثر على تقارير الربحية/المخزون/الحسابات.

---

### H-04 — **StockService: حساب المخزون بدون فلترة فرع (وممكن بدون warehouse)**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Services/StockService.php`  
- السطور: 35-74  
- المشكلة:
  - عند `warehouseId = null` يتم جمع stock_movements لكل المخازن.
  - لا يوجد فلترة فرع مباشرة داخل الـ service.
- التأثير:
  - في حال وجود أي تداخل/خطأ في الربط (منتج/مخزن) أو منتجات مشتركة، قد تظهر كميات خاطئة بين الفروع.
  - خطر أعلى لأن الخدمة تُستخدم في POS.

---

### H-05 — **stock_quantity كمصدر مخزون غير متزامن مع stock_movements**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملفات:
  - `app/Listeners/UpdateStockOnSale.php` (أسطر 29-73)
  - `app/Listeners/UpdateStockOnPurchase.php` (أسطر 29-59)
  - `app/Repositories/StockMovementRepository.php` (لا يقوم بتحديث Product.stock_quantity)
- المشكلة:
  - يتم تسجيل حركات المخزون فقط، لكن `products.stock_quantity` لا يتم تحديثه هنا.
- التأثير:
  - تقارير/Alerts تعتمد على `stock_quantity` قد تكون خاطئة.
  - “Low stock” و “Out of stock” قد تصبح غير موثوقة.

---

### H-06 — **PosReportsExportController يفلتر بـ `posted()` فقط (قد يستبعد Sales من الـ POS)**
- الحالة: **غير مُصلَح** (جزء منه من التقرير السابق)
- الملف: `app/Http/Controllers/Admin/Reports/PosReportsExportController.php`  
- السطور: 40-41  
- المشكلة: `Sale::query()->posted()` = status = posted فقط.
- التأثير:
  - مبيعات POS التي حالتها `completed` لن تظهر في التقرير.
  - تقارير POS ستكون ناقصة.

---

### H-07 — **CustomerSegmentationService يعتمد على `sales.posted_at` + دوال MySQL**
- الحالة: **جديدة**
- الملف: `app/Services/Reports/CustomerSegmentationService.php`  
- السطور: 41-70  
- المشكلة:
  - استخدام `sales.posted_at` (غير متوافق مع أماكن أخرى تستخدم `sale_date/created_at`).
  - استخدام `DATEDIFF`, `NOW`, و `ROUND` بهذه الطريقة يفترض MySQL.
- التأثير:
  - SQL errors أو نتائج غير صحيحة على قواعد بيانات غير MySQL.
  - حتى على MySQL قد يفشل إن لم يوجد posted_at.

---

### H-08 — **ScheduledReportService: أعمدة غير متوافقة (`sales.code`, `products.is_active`)**
- الحالة: **جديدة**
- الملف: `app/Services/ScheduledReportService.php`  
- السطور:
  - Orders report: 169-176 (`sales.code`)
  - Products report: 217-223 (`products.is_active`)
- التأثير:
  - تقارير Scheduled قد تفشل أو ترجع بيانات ناقصة/خاطئة.

---

### H-09 — **RecentItemsService: يعتمد على `code` في sales/purchases عبر DB::table**
- الحالة: **جديدة**
- الملف: `app/Services/UX/RecentItemsService.php`  
- السطور: 164-165  
- المشكلة: `DB::table('sales')->value('code')` و `DB::table('purchases')->value('code')`
- التأثير:
  - لو الأعمدة غير موجودة → SQL error.
  - لو الأعمدة موجودة لكن النظام يستخدم `reference_number` → عرض “آخر العناصر” سيكون خاطئ/فارغ.

---

## 3) Bugs متوسطة (Medium)

### M-01 — **AuditsChanges: تعطيل Logging في الـ Console لأول 5 دقائق**
- الحالة: **غير مُصلَح** (من التقرير السابق)
- الملف: `app/Traits/AuditsChanges.php`  
- السطور: 32-36  
- التأثير:
  - Jobs/Queue/Commands في أول 5 دقائق بعد تشغيل Worker لن تُسجّل أي Audit Logs.
  - فقدان traceability (مشكلة امتثال/مراجعة).

---

### M-02 — **DashboardWidgets: حساب “Sales Month” بدون فلترة السنة + عدّ Low Stock غير صحيح**
- الحالة: **جديدة**
- الملف: `app/Livewire/Components/DashboardWidgets.php`  
- السطور:
  - whereMonth بدون whereYear: 88-94
  - Low stock count باستخدام groupBy + count(): 101-111
- التأثير:
  - أرقام KPI الشهرية قد تجمع نفس الشهر من سنوات مختلفة.
  - low_stock_count قد يرجع رقم خاطئ (لأن `count()` مع `groupBy` في Laravel غالبًا يرجع أول صف وليس عدد المجموعات).

---

### M-03 — **POS API Response: `reference_no` للمدفوعات يرجع null دائمًا**
- الحالة: **جديدة**
- الملفات:
  - `app/Http/Controllers/Api/V1/POSController.php` (سطر 109)
  - `app/Models/SalePayment.php` (لا يوجد accessor لـ `reference_no`)
- التأثير:
  - الـ POS Client لن يحصل على مرجع المدفوعات حتى لو موجود كـ `reference_number`.

---

### M-04 — **PurchaseResource: `reference_no` غير موجود في Purchase Model**
- الحالة: **جديدة**
- الملفات:
  - `app/Http/Resources/PurchaseResource.php` (سطر 16)
  - `app/Models/Purchase.php` (لا يوجد `getReferenceNoAttribute`)
- التأثير:
  - API output للمشتريات قد يكون ناقص/مضلل.

---

### M-05 — **عدم اتساق Payment Method: `transfer` vs `bank_transfer`**
- الحالة: **جديدة**
- الملفات:
  - `app/Http/Controllers/Api/V1/POSController.php` (سطر 42 يسمح `transfer`)
  - `app/Models/SalePayment.php` (paymentMethods لا تحتوي `transfer`)
  - `app/Services/POSService.php` (يخزن كما يأتي من العميل)
- التأثير:
  - قيم Payment method غير موحدة داخل النظام.
  - UI/Reports التي تعتمد على `SalePayment::paymentMethods()` قد لا تعرض “transfer” بشكل صحيح.

---

### M-06 — **Cache صلاحيات الفروع “Forever” بدون Invalidation**
- الحالة: **جديدة**
- الملف: `app/Services/BranchContextManager.php`  
- السطور: 56-90  
- المشكلة: `rememberForever('user_accessible_branches_<built-in function id>')` بدون أي مسار واضح لمسح/تحديث عند تغيير عضوية المستخدم في الفروع.
- التأثير:
  - المستخدم قد يحتفظ بصلاحيات قديمة (Security/Authorization bug) حتى يتم مسح الكاش يدويًا.

---

## 4) Bugs منخفضة (Low) لكنها مهمة للاستقرار

### L-01 — **Race Condition في توليد أرقام/أكواد باستخدام count()+1**
- الحالة: **جديدة**
- أمثلة (ليست حصرًا):
  - `app/Models/GoodsReceivedNote.php` سطر 48
  - `app/Models/PurchaseRequisition.php` سطر 36
  - `app/Models/SupplierQuotation.php` سطر 40
  - `app/Services/SaleService.php` سطر 89
- المشكلة: في حالات التزامن (Concurrent creates) يمكن توليد نفس المرجع لأكثر من سجل.
- التأثير:
  - ازدواجية في المستندات (ERP impact).
  - قد يؤدي لفشل في الحفظ إذا يوجد unique constraint (أو لخبطة في التقارير إن لم يوجد).

---

## 5) ملخص سريع لأخطر ما يجب إصلاحه أولًا
1) **BranchScope** (تعطيله في الـ console + تطبيقه على Branch model)  
2) **ReportService** (topProducts + sales/purchases summaries)  
3) **KPIDashboardService** + **InventoryReportsExportController** (أعمدة غير متوافقة)  
4) **CashFlowForecastService / AutomatedAlertService / SmartNotificationsService** (استعلامات على Accessors كأنها أعمدة)  
5) **AccountingService** (اتزان القيود اليومية مع السداد الجزئي + عدم validate قبل posted)

---
