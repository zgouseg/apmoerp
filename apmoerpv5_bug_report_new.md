# APMO ERP v5 — Bug Report (New + Still Unfixed)
**Scan date:** 2026-01-13
**Scope:** `app/` + `routes/` + config-level logic when relevant. **Database/migrations/seeders were ignored** as requested.
**Notes:** This report contains **only** (1) **new bugs** found in `apmoerpv5.zip` that were not listed in the v4 report, and (2) **bugs from v4 that still exist** in v5.
---
## Quick Risk Summary
- **Highest risk areas:** Accounting (journal posting + mass assignment), Sales Returns (refund math + inventory), Inventory/Warehouse integrity, Branch isolation (multi-branch).
- **If you must prioritize:** Fix **NEW‑CRITICAL‑01 (Accounting journal linkage)** and **NEW‑CRITICAL‑02 (Order customer matching)** first.

---
## A) New Bugs in v5 (not in the v4 report)
### NEW-CRITICAL-01 — CRITICAL — Accounting journal linkage will throw MassAssignmentException (Sale/Purchase missing `journal_entry_id` in $fillable) + JournalEntry fields mismatch
**Locations:**
- `app/Services/AccountingService.php:162-163, 277-278 (updates Sale/Purchase with `journal_entry_id`)`
- `app/Models/Sale.php:31-64 (fillable has no `journal_entry_id`)`
- `app/Models/Purchase.php:30-56 (fillable has no `journal_entry_id`)`
- `app/Models/JournalEntry.php:21-43 (fillable missing fields used by AccountingService like `source_module`, `source_type`, `source_id`, `fiscal_year`, `fiscal_period`, `is_auto_generated`, etc.)`
- `app/Services/AccountingService.php:410-412 (updates `reversed_by_entry_id` which also isn’t in JournalEntry fillable; JournalEntry fillable uses `reversed_entry_id`)`

**What’s wrong**
In `AccountingService::generateSaleJournalEntry()` and `generatePurchaseJournalEntry()` you create a `JournalEntry` and then call:
- `$sale->update(['journal_entry_id' => $entry->id]);`
- `$purchase->update(['journal_entry_id' => $entry->id]);`

لكن `Sale` و `Purchase` لا يحتويان على `journal_entry_id` داخل `$fillable`, وبالتالي `update()` غالبًا سيرمي `MassAssignmentException` ويُفشل العملية.

بالإضافة لذلك، `AccountingService` يرسل حقول كثيرة عند `JournalEntry::create([...])` و `JournalEntry::update([...])` غير موجودة في `$fillable` داخل `JournalEntry`.
النتيجة: بعض بيانات التتبع (source_*, fiscal_*, is_auto_generated, approved_at) **لن تُحفظ أصلًا** حتى لو لم يحدث Exception.

وأخيرًا في `reverseJournalEntry()` يتم تحديث `reversed_by_entry_id`، بينما الموديل يعرّف `reversed_entry_id` (اسم مختلف)؛ هذا يعني أن وسم القيود كـ reversed قد لا يعمل.

**Impact**
- **Accounting module may crash** عند محاولة توليد قيود اليومية للمبيعات/المشتريات.
- حتى لو لم ينهار، **ربط القيد بالـ Sale/Purchase قد لا يتم**، وبيانات التتبع لن تُسجل.
- عمليات الـ reverse قد لا تُعلّم القيد الأصلي كـ reversed مما يسمح بعكس مكرر أو تقارير غير صحيحة.

**Recommended fix**
1) أضف `journal_entry_id` إلى `$fillable` في `Sale` و `Purchase` **أو** بدّل إلى assignment مباشر:
   - `$sale->journal_entry_id = $entry->id; $sale->save();`
2) راجع `$fillable` في `JournalEntry` وأضف الحقول المستخدمة فعليًا (`source_module`, `source_type`, ...)، أو أزلها من create/update إذا غير مطلوبة.
3) وحّد اسم حقل reverse:
   - إمّا تستخدم `reversed_entry_id` في الخدمة، أو تضيف `reversed_by_entry_id` للموديل/المهاجرات إذا هذا هو التصميم.
4) (اختياري لكن مهم) لا تجعل الـ JournalEntry `status='posted'` مباشرة إلا إذا طبّقت posting logic (تحديث أرصدة الحسابات + validate balance).

---
### NEW-CRITICAL-02 — CRITICAL — Orders API: Customer matching can attach an order to a random existing customer when email+phone are missing
**Locations:**
- `app/Http/Controllers/Api/V1/OrdersController.php:102-123`

**What’s wrong**
في `OrdersController::store()` عندما لا يكون `customer_id` موجودًا ويتم إرسال `customer`:
- يتم عمل Query على جدول العملاء.
- يتم إضافة شرط email **فقط إذا** email غير فارغ.
- يتم إضافة شرط phone **فقط إذا** email فارغ و phone غير فارغ.

إذا أرسل العميل `customer.name` فقط (مسموح بالـ validation) بدون email وبدون phone:
الـ query سيصبح عمليًا: `Customer::where(branch_id = X)->first()`.
هذا سيختار **أول عميل في الفرع** ويعيد استخدامه، وبالتالي المبيعات ستُسجل على عميل خاطئ.

**Impact**
- **فساد بيانات مالي/محاسبي**: فواتير ودفعات وتاريخ مبيعات يُنسب لعميل غير صحيح.
- يصعب جدًا اكتشافه لأن العملية لا تفشل (silent data corruption).

**Recommended fix**
اختيارات آمنة:
1) اجعل `customer.email` أو `customer.phone` **required_with:customer** (واحد على الأقل).
2) أو بدل من البحث بـ first() — إذا لا يوجد email/phone، أنشئ Customer جديد دائمًا.
3) (تحسين) إذا تم تمرير `customer_id` من الـ API، تحقق أنه ضمن نفس `branch_id` (حتى لا تربط Order بعميل فرع آخر).

---
### NEW-CRITICAL-03 — CRITICAL — API POS checkout allows selecting any branch_id (no visible authorization check for branch access)
**Locations:**
- `app/Http/Controllers/Api/V1/POSController.php:22-83 (accepts/merges branch_id after only checking `is_active`)`

**What’s wrong**
Endpoint `POSController::checkout()` يقبل `branch_id` من الـ request أو من الـ route.
التحقق الحالي يضمن فقط أن الفرع موجود و `is_active = true`.
لا يوجد هنا (في الكود الظاهر) تحقق أن المستخدم الحالي **مصرّح له** بالعمل على هذا الفرع.

حتى لو Policy `pos.use` موجودة، فهي لا تُمرر branch_id ولا يوجد ربط واضح بين الصلاحية والفرع المختار.

**Impact**
- مستخدم لديه صلاحية POS قد يتمكن من **إنشاء مبيعات في فرع آخر** (Cross-branch data write).
- يسبب تلاعب في المخزون/الإيرادات وتقارير الفروع.

**Recommended fix**
1) اربط authorization بالفرع: `authorize('pos.use', $branch)` أو Policy/Guard يتحقق من `branch_id` ضمن فروع المستخدم.
2) بديل: لا تقبل branch_id من العميل، واستخرجه فقط من session/user context.
3) سجّل في audit log محاولة استخدام فرع غير مصرح.

---
### NEW-HIGH-04 — HIGH — Inventory API getStock: warehouse filter breaks LEFT JOIN → products with zero movements disappear
**Locations:**
- `app/Http/Controllers/Api/V1/InventoryController.php:41-48`

**What’s wrong**
`getStock()` يبدأ بـ `leftJoin(stock_movements ...)` ثم عند وجود `warehouse_id` يضيف:
`where('stock_movements.warehouse_id', X)`.

هذا يحوّل الـ LEFT JOIN عمليًا إلى INNER JOIN.
النتيجة: المنتجات التي لا تمتلك أي حركة في هذا المخزن **لن تظهر إطلاقًا** (بدلاً من أن تظهر بكمية 0).

**Impact**
- API stock endpoint يعطي بيانات غير كاملة/مضللة عند التصفية بالمخزن.
- ممكن يظهر “لا يوجد منتج” بينما هو موجود لكن مخزونه 0 أو لم يتحرك.

**Recommended fix**
حرّك شرط `warehouse_id` إلى شرط داخل الـ join (join constraint) بدل where، مثال:
- `leftJoin('stock_movements as sm', function($join) use ($warehouseId) { $join->on('products.id','=','sm.product_id')->where('sm.warehouse_id',$warehouseId); })`
وبعدها SUM على `sm.quantity`.

---
### NEW-HIGH-05 — HIGH — ProductObserver deletes media files on soft delete (restoring a product will lose images)
**Locations:**
- `app/Observers/ProductObserver.php:58-95`

**What’s wrong**
داخل `ProductObserver::deleted()` يتم حذف ملفات الصور من storage.
ولكن `Product` يستخدم `SoftDeletes` (في الموديل)، وبالتالي حدث `deleted` يحدث أيضًا عند soft delete.
معنى ذلك: إذا عملت soft delete ثم restore للمنتج، **ستكون الصور قد حُذفت بالفعل**.

**Impact**
- فقدان ملفات (data loss) بدون قصد.
- Restore لن يعيد ملفات الصور وبالتالي واجهة المنتج ستنكسر أو تُظهر صور مفقودة.

**Recommended fix**
1) انقل حذف الملفات إلى event `forceDeleted()` فقط، أو تحقق `if ($product->isForceDeleting())`.
2) أو استخدم Media Library تدير الملفات مع soft delete بشكل صحيح.

---
### NEW-MEDIUM-06 — MEDIUM — Orders/Customers API: `per_page` is not validated or capped → performance/DoS risk
**Locations:**
- `app/Http/Controllers/Api/V1/OrdersController.php:24-45 (paginate uses request per_page directly)`
- `app/Http/Controllers/Api/V1/CustomersController.php:17-38 (paginate uses request per_page directly)`

**What’s wrong**
الـ endpoints تعمل `paginate($request->get('per_page', 50))` بدون validation للحد الأقصى.
أي عميل يملك store token يمكنه طلب `per_page=100000` مما يضغط DB والذاكرة.

**Impact**
- بطء شديد/استهلاك موارد.
- إمكانية تعطيل الخدمة (DoS) من عميل واحد.

**Recommended fix**
أضف validation مثل:
- `'per_page' => 'sometimes|integer|min:1|max:100'`
واستخدم القيمة الـ validated فقط.

---
### NEW-MEDIUM-07 — MEDIUM — InventoryController clamps calculated stock to non-negative, hiding negative stock and increasing drift
**Locations:**
- `app/Http/Controllers/Api/V1/InventoryController.php:132-135`

**What’s wrong**
`updateStock()` بعد تسجيل الحركة يعيد حساب المخزون ثم يعمل:
`stock_quantity = max(0, calculated)`.

إذا النظام يسمح بالمخزون السالب (`inventory.allow_negative_stock=true`) أو إذا حصل عجز حقيقي، هذا الكود سيخفيه ويحوّل القيمة إلى 0.

**Impact**
- تقارير/تنبيهات مخزون غير دقيقة.
- يزيد عدم التطابق بين `products.stock_quantity` و `stock_movements`.

**Recommended fix**
لا تعمل clamp إلى 0 بشكل صامت.
- إمّا خزّن القيمة الحقيقية (حتى لو سالبة)
- أو امنع الحركات التي تسبب سالب أصلًا (حسب إعدادات النظام) وارجع Validation Error.

---
### NEW-HIGH-08 — HIGH — StockTransfer is branch-aware via HasBranch but no `branch_id` is ever assigned (likely branchless/unscoped transfers) + transfer number race condition
**Locations:**
- `app/Models/StockTransfer.php:14-53 (uses HasBranch, but fillable has no `branch_id`)`
- `app/Services/StockTransferService.php:60-78 (creates StockTransfer without setting `branch_id`)`
- `app/Models/StockTransfer.php:106-123 (generateTransferNumber has no locking/unique constraint handling)`

**What’s wrong**
`StockTransfer` يستخدم `HasBranch` لكن `$fillable` لا يحتوي `branch_id`.
وفي `StockTransferService::createTransfer()` لا يتم تعيين `branch_id` أصلاً.

لو جدول `stock_transfers` فعلاً يحتوي `branch_id` (وهذا متوقع في نظام متعدد الفروع)، فالسجلات الجديدة قد تُنشأ بـ `branch_id = NULL` أو بدون عزل فرعي.
ولو الجدول لا يحتوي `branch_id`، وجود `HasBranch::branch()` relation على هذا الموديل قد يؤدي إلى أخطاء SQL إذا استُخدم.

أيضًا `generateTransferNumber()` يعتمد على آخر رقم بدون locking، مما يسمح بتكرار الرقم عند الـ concurrency.

**Impact**
- تحويلات مخزون قد تصبح **غير مرتبطة بأي فرع** أو مرئية لفروع متعددة.
- أرقام transfer_number ممكن تتكرر في حالات متزامنة.

**Recommended fix**
1) قرر التصميم بوضوح:
- إذا StockTransfer يجب أن يُنسب لفرع: أضف `branch_id` للجدول و `$fillable`، وعيّنه عند الإنشاء (مثلاً = from_branch_id).
- إذا لا يجب أن يُنسب: أزل `HasBranch` من StockTransfer.
2) لحل رقم التحويل: استخدم lock/sequence/unique index + retry عند التصادم.

---
### NEW-HIGH-09 — HIGH — BranchScope is disabled whenever there is no authenticated user → queued jobs/CLI code may run cross-branch unintentionally
**Locations:**
- `app/Models/Scopes/BranchScope.php:88-94 (returns if no user)`
- `app/Traits/HasBranch.php:31-51 (auto-assign branch_id depends on BranchContextManager/request/auth)`

**What’s wrong**
`BranchScope` لا يطبق أي فلترة إذا لم يوجد user مصادق عليه (`if (! $user) return;`).
هذا يعني:
- أي Job/Command يعمل بدون auth (شائع في queue/cron) سيقرأ بيانات **كل الفروع**.
- وأي Model يتم إنشاؤه في هذه السياقات قد لا يحصل على `branch_id` تلقائيًا.

هذا ليس خطأ نحوي، لكنه خطأ معماري خطير في نظام ERP متعدد الفروع.

**Impact**
- تقارير/مهام تلقائية قد تعمل على كل الفروع دون قصد.
- إنشاء بيانات branch-owned بسجلات branch_id null أو مختلطة.
- صعب تتبّعه لأنه يعتمد على السياق (queue/cron).

**Recommended fix**
1) اعتمد Branch Context مستقل عن auth للـ Jobs/Commands:
- مرّر `branch_id` بوضوح داخل الـ job والـ services،
- أو استخدم `BranchContextManager::setCurrentUser()` / أو setter للـ branch context قبل الاستعلامات.
2) في الأوامر التي يجب أن تعمل per-branch: loop على الفروع (مثل بعض commands عندكم) بدلاً من Query عام.

---
### NEW-MEDIUM-10 — MEDIUM — ReturnNote reference_number generation uses `count()+1` (race condition → duplicates)
**Locations:**
- `app/Services/SaleService.php:83-90 (generates reference_number using ReturnNote::count()+1)`

**What’s wrong**
`SaleService::handleReturn()` يولّد رقم `ReturnNote.reference_number` بهذه الطريقة:
`'RN-'.str_pad((string)(ReturnNote::count() + 1), 5, '0', STR_PAD_LEFT)`.

في حال وجود عمليتين Returns في نفس الوقت، كلاهما قد يقرأ نفس `count()` وبالتالي ينتج نفس الرقم.
إذا يوجد unique index على reference_number سيحدث crash، وإذا لا يوجد فستحصل على أرقام مكررة.

**Impact**
- تكرار أرقام الإرجاع (تأثير قانوني/مالي إذا تُستخدم كمرجع رسمي).
- أو فشل العملية بالكامل تحت الضغط (concurrency).

**Recommended fix**
استخدم sequence/UUID أو جدول counter per-branch، أو unique index مع retry.
مثال: lockForUpdate على سجل counter، أو استخدم `Str::ulid()` كمرجع غير قابل للتصادم.

---

## B) Bugs from v4 report that are still present in v5
### STILL-CRITICAL-01 — CRITICAL — External order lookup inconsistency: API uses `reference_number` while store sync uses `external_reference`
**Locations:**
- `app/Http/Controllers/Api/V1/OrdersController.php:267-281 (`byExternalId` uses `reference_number`)`
- `app/Services/Store/StoreSyncService.php:306-320 (Shopify sync checks `external_reference`)`

**What’s wrong**
API endpoint `/orders/external/{id}` يبحث عن الطلب عبر `reference_number`.
لكن خدمة مزامنة المتاجر (`StoreSyncService`) تعتبر الـ external id في الحقل `external_reference`.
وبالتالي نفس الـ external order قد لا يتم العثور عليه/تحديثه حسب المسار الذي أنشأه.

**Impact**
- Idempotency غير متسق: قد يتكرر تسجيل الطلب أو يفشل تحديثه.
- صعوبة في ربط أوامر المتجر بالـ ERP داخليًا.

**Recommended fix**
اختر حقل واحد كمصدر حقيقة للـ external id:
- إما توحيد الكل على `external_reference`
- أو توحيد الكل على `reference_number`
ثم عدّل كل الـ lookups والـ unique constraints accordingly.

---
### STILL-CRITICAL-02 — CRITICAL — Inventory still has 2 sources of truth: `products.stock_quantity` vs `stock_movements`
**Locations:**
- `app/Services/Dashboard/DashboardDataService.php:198-204 (low stock uses `products.stock_quantity`)`
- `app/Repositories/StockMovementRepository.php:112-156 (creates movements but doesn't update `products.stock_quantity`)`
- `app/Listeners/UpdateStockOnSale.php (writes movements only)`
- `app/Listeners/UpdateStockOnPurchase.php (writes movements only)`

**What’s wrong**
بعض أجزاء النظام (Dashboard/تنبيهات) تعتمد على `products.stock_quantity`.
بينما عمليات البيع/الشراء تسجل `stock_movements` فقط بدون تحديث `products.stock_quantity` بشكل مضمون.
هذا يسبب drift (اختلاف) في التقارير والتنبيهات.

**Impact**
- تنبيهات low stock قد تكون خاطئة.
- تقارير المخزون قد تختلف حسب الشاشة/الـ API المستخدم.

**Recommended fix**
حل واحد لازم يُعتمد:
1) إمّا اعتبر `stock_movements` هو المصدر الوحيد، ولا تستخدم `products.stock_quantity` في أي logic.
2) أو حافظ على `products.stock_quantity` محدث دائمًا (Observer/Service بعد كل movement) واستخدم movements كسجل تاريخي فقط.

---
### STILL-CRITICAL-03 — CRITICAL — Sales return flow still breaks accounting/payment consistency and can be overwritten later
**Locations:**
- `app/Services/SaleService.php:60-115 (handleReturn adjusts `paid_amount` directly and does not create a refund payment/transaction)`
- `app/Models/Sale.php:215-241 (updatePaymentStatus recalculates `paid_amount` from payments)`
- `app/Observers/FinancialTransactionObserver.php:62-80 (calls updatePaymentStatus frequently)`

**What’s wrong**
في `SaleService::handleReturn()` يتم تعديل `Sale.paid_amount` مباشرة:
- `$sale->paid_amount = max(0, $sale->paid_amount - $totalReturnAmount);`
لكن لا يتم إنشاء سجل دفع/Refund مقابل هذا الخصم (لا negative payment ولا refund transaction).

وبسبب أن `Sale::updatePaymentStatus()` يحسب `paid_amount` من مجموع payments، أي تعديل يدوي للـ paid_amount
قد يُستبدل لاحقًا بمجرد حدوث تحديث لأي payment/financial_transaction (observer).

أيضًا لا يوجد توثيق محاسبي واضح (journal reverse/credit note) مرتبط بالـ return هنا.

**Impact**
- احتمال ظهور paid_amount غير منطقي أو يتغير "لوحده" بعد return.
- AR/Customer balance قد يصبح غير صحيح.
- صعوبة audit: لا يوجد أثر دفع/Refund واضح يفسّر نقص paid_amount.

**Recommended fix**
بدل تعديل paid_amount مباشرة:
1) أنشئ Refund Transaction/Payment سجل واضح (مثلاً Payment سالب أو نوع refund منفصل) بحيث يصبح paid_amount مشتقًا دائمًا.
2) أو عدّل updatePaymentStatus ليأخذ في الاعتبار returns/refunds.
3) اربط return بقيد محاسبي (Credit Note / reversal) إذا Accounting module مفعل.

---
### STILL-CRITICAL-04 — CRITICAL — Accounting sale journal entry can be unbalanced (shipping not accounted) and is marked posted without running posting logic
**Locations:**
- `app/Services/AccountingService.php:89-167 (generateSaleJournalEntry sets status `posted` and creates lines without shipping line)`
- `app/Services/AccountingService.php:476-520 (validateBalancedEntry exists but not used by generators)`

**What’s wrong**
في `generateSaleJournalEntry()`:
- يتم إنشاء JournalEntry بحالة `posted` مباشرة.
- يتم عمل Debit/Credit لِـ: Cash/AR, Sales Revenue (subtotal), Tax Payable, Sales Discounts.
- لكن **لا يوجد أي قيد للشحن** (`shipping_amount`) رغم أنه جزء من `total_amount` في أغلب التدفقات.

هذا غالبًا يجعل القيد غير متوازن (difference = shipping).
كما أن وضع `status=posted` مباشرة يتخطّى أي عملية posting متوقعة (تحديث أرصدة الحسابات/validation).

**Impact**
- قيود غير متوازنة قد تدخل الدفاتر (إن تم استخدامها).
- أرصدة الحسابات قد لا تتحدث كما هو متوقع.
- تقارير مالية غير دقيقة.

**Recommended fix**
1) أضف handling للشحن:
- إما حسابه كـ Shipping Income (credit) أو Shipping Expense حسب تصميمك.
2) لا تجعل status=posted إلا بعد `validateBalancedEntry()` و/أو `postJournalEntry()`.
3) غطِّ discount/tax/shipping في كل generators (Sale/Purchase/Returns).

---
### STILL-CRITICAL-05 — CRITICAL — POS checkout still allows `warehouse_id = null` → stock movements can be created without warehouse
**Locations:**
- `app/Http/Requests/PosCheckoutRequest.php:19-31 (`warehouse_id` is `sometimes` → can be missing)`
- `app/Services/POSService.php:49-57, 66-86 (warehouse_id defaults to null and is saved on Sale)`
- `app/Listeners/UpdateStockOnSale.php:27-33 (uses `$sale->warehouse_id` directly)`

**What’s wrong**
POS checkout يمكن أن يتم بدون warehouse_id.
في هذه الحالة:
- `Sale.warehouse_id` يصبح null.
- `UpdateStockOnSale` يسجل stock movement باستخدام warehouse_id=null.

هذا يكسر فكرة المخزون per-warehouse ويجعل حركات المخزون غير قابلة للتجميع/الفلترة بشكل صحيح.

**Impact**
- مخزون غير صحيح per warehouse.
- تقارير المخزون قد تتجاهل هذه الحركات (لأنها لا تملك warehouse).
- احتمالية كسر لواجهات تعتمد على warehouse.

**Recommended fix**
اجعل `warehouse_id` required في POS (على الأقل للمنتجات غير الخدمة).
أو صمّم Default Warehouse واضح لكل فرع واملأه تلقائيًا.

---
### STILL-HIGH-06 — HIGH — Purchases can also create stock movements with `warehouse_id = null`
**Locations:**
- `app/Http/Requests/PurchaseStoreRequest.php:24-25 (`warehouse_id` is nullable)`
- `app/Listeners/UpdateStockOnPurchase.php:24-31 (uses `$purchase->warehouse_id` directly)`

**What’s wrong**
إنشاء Purchase يسمح بـ warehouse_id nullable.
وعند استقبال المشتريات، listener يسجل حركة مخزون بنفس warehouse_id (قد تكون null).

**Impact**
- نفس مشكلة POS ولكن على جانب التوريد.
- زيادة drift في المخزون وصعوبة التتبع.

**Recommended fix**
اجعل warehouse_id required عند الاستلام/الـ receiving (حتى لو كان optional عند إنشاء مسودة).
أو نفّذ default warehouse fallback.

---
### STILL-HIGH-07 — HIGH — Stock movement duplicate guard is too coarse: prevents multiple movements per (sale/purchase, product) — breaks partial operations & multiple lines
**Locations:**
- `app/Listeners/UpdateStockOnSale.php:34-58 (skips if movement exists for same sale+product+qty)`
- `app/Listeners/UpdateStockOnPurchase.php:35-57 (same pattern)`

**What’s wrong**
الـ listeners تمنع إنشاء حركة مخزون جديدة إذا وجد Movement لنفس (reference_type, reference_id, product_id, quantity).
هذا يُسبب مشاكل في حالات:
- نفس المنتج مكرر في أكثر من سطر.
- partial receiving أو partial return أو عدة returns على نفس sale.
- تعديل الكميات بعد إنشاء الحركة.

**Impact**
- المخزون يصبح ناقص/زائد بسبب تخطي الحركات الجديدة.
- حالات returns متعددة لنفس sale قد لا تزيد المخزون بعد أول مرة.

**Recommended fix**
بدلاً من guard بهذه الطريقة:
- استخدم key أقوى (مثلاً reference_line_id أو movement_uuid) لضمان idempotency.
- أو اعتمد Unique constraint على UUID وليس على (sale+product+qty).
- أو اجمع/merging الحركات بطريقة واضحة بدل skip.

---
### STILL-HIGH-08 — HIGH — FinancialTransactionObserver still has correctness issues (updated event uses isDirty + missing restored handler)
**Locations:**
- `app/Observers/FinancialTransactionObserver.php:62-80`

**What’s wrong**
داخل `updated()` تستخدم `isDirty('status')`/`isDirty('amount')` بعد التحديث.
في event `updated` الأفضل استخدام `wasChanged()` لتحديد ما تغيّر فعليًا.

كذلك لا يوجد handler لـ `restored()` — عند restore لِـ financial transaction soft-deleted، لن يتم تحديث payment status.
وأيضًا `updatePaymentStatus()` يتم استدعاؤها في كل تحديث تقريبًا حتى لو لا علاقة له بالـ payments.

**Impact**
- حالات edge (status changes / restore) قد لا تعيد حساب paid_amount/payment_status صحيح.
- ضغط غير ضروري على DB بسبب تحديثات متكررة.

**Recommended fix**
1) استبدل `isDirty()` بـ `wasChanged()` في updated.
2) أضف `restored()` handler يعيد حساب payment status.
3) استدعِ updatePaymentStatus فقط عند تغيّر حقول مؤثرة (amount/status/related ids).

---
### STILL-MEDIUM-09 — MEDIUM — `Sale::getTotalPaidAttribute()` still sums all payments regardless of status (pending/failed counted as paid)
**Locations:**
- `app/Models/Sale.php:200-213`

**What’s wrong**
`getTotalPaidAttribute()` يجمع `payments()->sum('amount')` بدون فلترة status.
إذا عندك payments بحالات pending/failed/reversed، ستظل تُحسب ضمن المدفوع.

**Impact**
- paid_amount و payment_status قد يظهرا “مدفوع” بينما فعليًا لم يتم التحصيل.
- تقارير التحصيل cashflow غير دقيقة.

**Recommended fix**
فلتر payments التي تُحسب ضمن paid:
- فقط `status = completed/posted` حسب تصميمك.
واستبعد `failed/cancelled/pending/reversed`.

---
### STILL-MEDIUM-10 — MEDIUM — Voiding a sale does not reverse stock or accounting entries
**Locations:**
- `app/Services/SaleService.php:120-139`

**What’s wrong**
`voidSale()` يغيّر status إلى `void` ويضيف ملاحظة فقط.
لا يوجد أي عكس لحركات المخزون ولا عكس لقيود محاسبية أو refunds.

**Impact**
- المخزون سيبقى مخصوم رغم أن البيع void.
- التقارير المالية ستظل تحتسب البيع.

**Recommended fix**
عند void:
1) أنشئ stock movements عكسية لكل item.
2) اعكس أو ألغِ journal entries/payments المرتبطة.
3) امنع void إذا تم شحن/تسليم جزئيًا إلا عبر workflow واضح.

---

## Notes
- لم يتم تحليل المهاجرات/الـ seeders حسب طلبك، لذلك بعض النقاط (وجود/عدم وجود أعمدة معينة) تم الاستدلال عليها من الكود فقط.
- إذا أردت، أستطيع عمل pass ثاني يركز على **API security** (authz + rate limits + branch scoping) أو **Accounting correctness** (mapping accounts + balanced entries) بشكل أعمق.
