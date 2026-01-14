# apmoerpv18 — Bug Report (New + Still-Unfixed Only)

**Scan target:** `apmoerpv18.zip`  
**Comparison baseline:** `apmoerpv17.zip`  
**Scope:** Full codebase scan (ignored `database/`, migrations, seeders).  

## 0) Result Summary
- **New bugs in v18:** **2**
- **Still-unfixed from v17 baseline:** **0** (all v17-reported issues appear fixed in v18)

---

## 1) New Bugs Found in v18

### NEW-HIGH-01 — Warehouse uniqueness scoped to the wrong branch source

- **File:** `app/Http/Requests/WarehouseStoreRequest.php`
- **Lines:** 19, 27–33
- **Problem:** Uniqueness rules for `name` and `code` are scoped using the **authenticated user's** `branch_id`:
  - `$branchId = $this->user()?->branch_id;`
  - `Rule::unique(...)->where('branch_id', $branchId)`

  لكن إنشاء المستودع فعليًا يربط `branch_id` من `request()->attributes->get('branch_id')` داخل `Branch/WarehouseController@store` (يعني مصدر الـ branch الحقيقي ممكن يختلف عن `auth()->user()->branch_id`).

- **Impact:**
  - ممكن يسمح بتكرار `name/code` داخل نفس الفرع (لو user.branch_id = null أو مختلف عن branch_id بالـ attributes).
  - أو يمنع إنشاء Warehouse في فرع معيّن بسبب تعارض في فرع آخر (لو المستخدم له branch مختلفة).

- **Suggested fix:**
  - استخدم نفس مصدر الفرع المستخدم في الـ Controller/Middleware، مثل:
    - `$branchId = (int) $this->attributes->get('branch_id');` (أو `request()->attributes->get('branch_id')`)
  - أو مرّر `branch_id` ضمن validated data (إذا هذا هو التصميم) ثم استخدمه في Rule.
  - أضف guard: لو $branchId غير موجود → fail validation بدل ما تعمل scope بـ null.

**Code context (v18):**
```php
19: $branchId = $this->user()?->branch_id;

27: Rule::unique('warehouses', 'name')->where('branch_id', $branchId),
33: Rule::unique('warehouses', 'code')->where('branch_id', $branchId),
```

---

### NEW-MEDIUM-02 — Inconsistent quantity validation (create allows fractional, update blocks it)

- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Lines:** 189 vs 273
- **Problem:** في `store()` تم تغيير `quantity` إلى `numeric` (يدعم الكسور)، لكن في `update()` مازال:
  - `'quantity' => 'sometimes|integer|min:0',`

- **Impact:**
  - لو منتجات وزن/طول/حجم (مثلاً 0.5 kg) تقدر **تُنشأ** بكمية عشرية عبر API،
    لكن لا يمكن **تعديلها** لاحقًا بنفس النوع (يتم رفض الطلب/أو يتم truncation قبل validation حسب client).

- **Suggested fix:**
  - توحيد القاعدة في `update()` إلى `numeric|min:0` (أو نفس الدقة المطلوبة).
  - (اختياري) أضف `decimal` precision rules على حسب الـ UOM/setting.

**Code context (v18):**
```php
189: 'quantity' => 'required|numeric|min:0',    // store()

273: 'quantity' => 'sometimes|integer|min:0',   // update()
```

---

## 2) Still-Unfixed From v17 Baseline
None detected.
