<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
    @php
        $periodLabel = match ($selectedPeriod ?? 'week') {
            'today' => __('Today'),
            'month' => __('Last 30 Days'),
            default => __('Last 7 Days'),
        };
    @endphp
    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">
        {{ __('Sales Trend') }}
        <span class="text-sm font-normal text-slate-500 dark:text-slate-400">({{ $periodLabel }})</span>
    </h3>
    <div class="h-64" wire:ignore>
        <canvas id="salesChart"></canvas>
    </div>
</div>
