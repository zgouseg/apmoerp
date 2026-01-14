# APMO ERP v13 — Bug Report (New + Still-Unfixed)

Scan target: **apmoerpv13.zip** (code-level review). **Database/migrations/seeders ignored** per request.

This report contains **ONLY**:
- **New bugs found in v13**, and
- **Bugs previously reported (v12) that are still present in v13**

---

## Summary

- **New in v13:** 2
- **Still unfixed from v12:** 1


---

## NEW-V13-CRITICAL-01 — CRITICAL

**Title:** Admin dashboard queries `grand_total` as a DB column (but it’s an accessor)

**Location:** `resources/views/livewire/admin/dashboard.blade.php:16–17, 42–46`


**What’s wrong**

`Sale` uses `total_amount` as the stored column, while `grand_total` is exposed via `getGrandTotalAttribute()` (accessor alias).
In the dashboard, there are DB aggregates like:
- `Sale::sum('grand_total')`
- `selectRaw('... SUM(grand_total) ...')`
This will hit the DB with a non-existent column in a migrated schema (`grand_total`), causing SQL errors.


**Impact**

- Admin dashboard page can crash (SQLSTATE “Unknown column”).
- KPIs and charts show wrong/empty data if the DB happens to contain both columns inconsistently.


**Fix direction**

- Replace DB aggregates on `grand_total` with the real column: `total_amount`.
  - `->sum('total_amount')`
  - `SUM(total_amount)` in `selectRaw`.

---

## NEW-V13-CRITICAL-02 — CRITICAL

**Title:** Livewire components used as self-closing tags (`/>`) in Blade views (Livewire 4 requires explicit closing tags)

**Locations (examples):**

- `resources/views/livewire/admin/settings/unified-settings.blade.php:221`

- `resources/views/livewire/admin/settings/unified-settings.blade.php:233`

- `resources/views/livewire/expenses/form.blade.php:56`

- `resources/views/livewire/hrm/employees/form.blade.php:118`

- `resources/views/livewire/income/form.blade.php:56`

- `resources/views/livewire/inventory/products/form.blade.php:256`

- `resources/views/livewire/profile/edit.blade.php:46`

- `resources/views/livewire/rental/contracts/form.blade.php:155`

- `resources/views/livewire/rental/units/form.blade.php:95`


**What’s wrong**

In Livewire 4, component tags must be explicitly closed. Self-closing tags like:

```blade
<livewire:components.media-picker ... />
```

can trigger template/compiler errors or components not rendering as expected.


**Impact**

- صفحات النماذج/الإعدادات قد تفشل في التحميل أو يفشل الـ component في الـ hydration.
- مشاكل runtime صعبة التتبع لأنها تظهر كـ view compile / Livewire mount errors.


**Fix direction**

Replace each self-closing tag with an explicit closing tag:

```blade
<livewire:components.media-picker ...></livewire:components.media-picker>
```

(ونفس الفكرة لأي `<livewire:... />` آخر.)

---

## STILL-V12-HIGH-01 — HIGH

**Title:** Product `addStock()` / `subtractStock()` still writes `products.stock_quantity` directly (can drift from stock_movements truth)

**Location:** `app/Models/Product.php:445–511` (methods `addStock()` and `subtractStock()`)


**What’s wrong**

Even after moving inventory calculations toward `stock_movements` (via `StockService` / repository), the model still contains legacy methods that directly mutate `stock_quantity`.
Even if they are marked deprecated, leaving them callable risks future regressions (a dev may call them and bypass movement creation).


**Impact**

- `stock_quantity` can diverge from `stock_movements`, breaking “single source of truth”.
- Low-stock alerts / KPI widgets that rely on `stock_quantity` may become wrong.


**Fix direction**

- Hard-disable these methods (throw exception) or remove them once confirmed unused.
- Or internally route them to `StockMovementRepository::create()` so every adjustment is recorded as a movement.
