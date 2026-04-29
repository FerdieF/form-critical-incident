

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginald07245451647f5715f9bac44fc38d4f4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald07245451647f5715f9bac44fc38d4f4 = $attributes; } ?>
<?php $component = App\View\Components\Common\PageBreadcrumb::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.page-breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Common\PageBreadcrumb::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Monitoring Progres Asesmen']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald07245451647f5715f9bac44fc38d4f4)): ?>
<?php $attributes = $__attributesOriginald07245451647f5715f9bac44fc38d4f4; ?>
<?php unset($__attributesOriginald07245451647f5715f9bac44fc38d4f4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald07245451647f5715f9bac44fc38d4f4)): ?>
<?php $component = $__componentOriginald07245451647f5715f9bac44fc38d4f4; ?>
<?php unset($__componentOriginald07245451647f5715f9bac44fc38d4f4); ?>
<?php endif; ?>

    
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
        
        <div class="py-6 px-4 md:px-6 xl:px-7.5 border-b border-stroke dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h4 class="text-xl font-bold text-black dark:text-white">Daftar Status Pengisian Karyawan</h4>
            
            
            <a href="<?php echo e(route('admin.print_semua_pdf')); ?>" target="_blank" class="inline-flex items-center justify-center rounded bg-blue-600 py-2 px-5 text-center font-medium text-white hover:bg-blue-700 transition shadow-sm">
                <svg class="mr-2 fill-current" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 8H5V3H19V8ZM17 5H7V6H17V5ZM21 10C21.5523 10 22 10.4477 22 11V18H18V21H6V18H2V11C2 10.4477 2.44772 10 3 10H21ZM16 16H8V19H16V16ZM18 12H16V14H18V12Z"></path>
                </svg>
                Cetak Semua (PDF)
            </a>
        </div>

        <div class="max-w-full overflow-x-auto p-4">
            <table class="w-full table-auto border-collapse">
                <thead>
                    
                    <tr class="bg-gray-100 text-left dark:bg-gray-700">
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Nama Karyawan</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white text-center">Data Pribadi</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white text-center">Pekerjaan</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white text-center">Kesiapan</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-[#eee] dark:border-gray-700">
                        
                        
                        <td class="py-5 px-4 align-middle">
                            <h5 class="font-medium !text-black dark:!text-white text-base">
                                <?php echo e(optional($user->karyawan)->nama_lengkap ?? $user->name); ?>

                            </h5>
                            <p class="text-sm !text-black dark:!text-gray-300">NIK SAP: <?php echo e($user->nik_sap); ?></p>
                        </td>

                        
                        <?php if($user->karyawan): ?>
                            
                            
                            
                            
                            <td class="py-5 px-4 text-center align-middle">
                                <div class="flex flex-wrap justify-center items-center gap-2 text-sm">
                                    <span class="<?php echo e($user->karyawan->id ? 'text-green-500' : 'text-red-500'); ?> font-medium">● ID</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->keluargas->count() > 0 ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Keluarga</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->pendidikans->count() > 0 ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Pendidikan</span>
                                </div>
                            </td>

                            
                            <td class="py-5 px-4 text-center align-middle">
                                <div class="flex flex-wrap justify-center items-center gap-2 text-sm">
                                    <span class="<?php echo e($user->karyawan->pengalamanKerjas->count() > 0 ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Pengalaman</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->detailPekerjaan ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Detail</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->kondisiKerja ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Kondisi</span>
                                </div>
                            </td>

                            
                            <td class="py-5 px-4 text-center align-middle">
                                <div class="flex flex-wrap justify-center items-center gap-2 text-sm">
                                    <span class="<?php echo e($user->karyawan->minatHarapan ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Minat</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->kekuatanKelemahan ? 'text-green-500' : 'text-red-500'); ?> font-medium">● S.W Point</span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="<?php echo e($user->karyawan->criticalIncidents->count() > 0 ? 'text-green-500' : 'text-red-500'); ?> font-medium">● Critical</span>
                                </div>
                            </td>

                            
                            <td class="py-5 px-4 text-center align-middle">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="<?php echo e(route('admin.karyawan.show', $user->karyawan->id)); ?>" class="inline-flex rounded border border-primary py-1.5 px-4 text-sm font-medium text-primary hover:bg-primary hover:text-white transition-all dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white">
                                        Lihat Detail
                                    </a>
                                    <a href="<?php echo e(route('admin.print_individu_pdf', $user->karyawan->id)); ?>" target="_blank" class="inline-flex rounded border border-emerald-500 py-1.5 px-4 text-sm font-medium text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all dark:border-emerald-400 dark:text-emerald-400 dark:hover:bg-emerald-500 dark:hover:text-white">
                                        Cetak
                                    </a>
                                </div>
                            </td>

                        <?php else: ?>
                            
                            
                            <td colspan="3" class="py-5 px-4 text-center align-middle">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-danger/10 px-4 py-1.5 text-xs font-medium text-danger dark:!text-red-400 border border-danger/20">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="16" r="1" fill="currentColor"/>
                                    </svg>
                                    Belum Memulai Pengisian
                                </span>
                            </td>

                            
                            <td class="py-5 px-4 text-center align-middle">
                                <button disabled class="inline-flex rounded border border-gray-300 bg-gray-100 py-1.5 px-4 text-sm font-medium text-gray-400 cursor-not-allowed dark:border-gray-600 dark:bg-gray-700 dark:text-gray-500">
                                    Menunggu...
                                </button>
                            </td>

                        <?php endif; ?>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-gray-700 dark:bg-gray-800 text-sm">
        
        
        <div class="flex items-center gap-4">
            <span class="font-bold text-black dark:text-white">Status Pengisian:</span>
            <div class="flex items-center gap-1.5">
                <span class="text-green-500 text-lg leading-none">●</span>
                <span class="text-black dark:text-gray-300">Sudah Diisi</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="text-red-500 text-lg leading-none">●</span>
                <span class="text-black dark:text-gray-300">Belum Diisi</span>
            </div>
        </div>

        
        <div class="text-xs text-gray-500 dark:text-gray-400">
            <span class="font-medium text-black dark:text-gray-300">ID:</span> Identitas Diri | 
            <span class="font-medium text-black dark:text-gray-300">S.W Point:</span> Kekuatan & Kelemahan
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Apply Kerja\tailadmin-laravel-main\resources\views/pages/dashboard/admin.blade.php ENDPATH**/ ?>