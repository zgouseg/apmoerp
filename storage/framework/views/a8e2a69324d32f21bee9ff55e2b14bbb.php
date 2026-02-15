<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"><?php echo e(__('Module Management')); ?></h1>
            <p class="text-sm text-slate-500"><?php echo e(__('Manage system modules and their settings')); ?></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?php echo e(route('admin.modules.product-fields')); ?>" class="erp-btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <?php echo e(__('Product Fields')); ?>

            </a>
            <a href="<?php echo e(route('admin.modules.create')); ?>" class="erp-btn erp-btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <?php echo e(__('Add Module')); ?>

            </a>
        </div>
    </div>

    <div class="erp-card p-4">
        <div class="mb-6">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="<?php echo e(__('Search modules...')); ?>" class="erp-input max-w-md">
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded-lg"><?php echo e(session('success')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('error')): ?>
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg"><?php echo e(session('error')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="border border-slate-200 rounded-xl p-4 hover:shadow-md transition-shadow <?php echo e(!$module->is_active ? 'opacity-60' : ''); ?>">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl"><?php echo e($module->icon ?? '📦'); ?></span>
                            <div>
                                <h3 class="font-semibold text-slate-800"><?php echo e($module->localized_name); ?></h3>
                                <p class="text-xs text-slate-500"><?php echo e($module->module_key); ?></p>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->is_core): ?>
                            <span class="px-2 py-0.5 text-xs bg-amber-100 text-amber-700 rounded-full"><?php echo e(__('Core')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <p class="text-sm text-slate-600 mb-3 line-clamp-2"><?php echo e($module->localized_description ?? __('No description')); ?></p>
                    
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-0.5 text-xs rounded-full <?php echo e($module->getModuleTypeColor()); ?>">
                            <?php echo e($module->getModuleTypeLabel()); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->supports_items): ?>
                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded-full">
                                <?php echo e(__('Creates Items')); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div class="flex items-center justify-between pt-3 border-t">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500"><?php echo e($module->branches_count); ?> <?php echo e(__('branches')); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="toggleActive(<?php echo e($module->id); ?>)" class="p-1.5 rounded-lg <?php echo e($module->is_active ? 'text-emerald-600 hover:bg-emerald-50' : 'text-slate-400 hover:bg-slate-100'); ?>" title="<?php echo e($module->is_active ? __('Deactivate') : __('Activate')); ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->is_active): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <?php else: ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </svg>
                            </button>
                            <a href="<?php echo e(route('admin.modules.edit', $module)); ?>" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full text-center py-8 text-slate-500"><?php echo e(__('No modules found')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="mt-4">
            <?php echo e($modules->links()); ?>

        </div>
    </div>
</div>
<?php /**PATH /home/runner/work/apmoerp/apmoerp/resources/views/livewire/admin/modules/index.blade.php ENDPATH**/ ?>