<?php $__env->startSection('title', 'Permissions'); ?>

<?php $__env->startSection('content'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                        <div class="page-header-main">
                            <div class="page-title">Permission</div>
                            <div class="header-breadcrumb">
                                <a href="#"><i data-feather="airplay"></i> Index</a>
                            </div>
                        </div>
                        <div class="page-header-action">
                            <a href="<?php echo e(route('permissions.create')); ?>" class="btn btn-primary btn-sm">Create</a>
                        </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table center-aligned-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Permission Name</th>
                                                <th>Guard Name</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                
                                                <td><?php echo e($permission->name); ?></td>
                                                <td><?php echo e($permission->guard_name); ?></td>
                                                <td><?php echo e($permission->created_at); ?></td>

                                                
                                                <td class="action">
                                                    <form class="formPermission" action="<?php echo e(route('permissions.destroy',$permission->id)); ?>" method="POST">
                                                        
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-edit')): ?>
                                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('permissions.edit',$permission->id)); ?>">Edit</a>
                                                        <?php endif; ?>

                                                    
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-delete')): ?>
                                                            <button type="button" class="btn btn-danger btn-sm delete-confirm">Delete</button>
                                                        <?php endif; ?>
                                                    </form>

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo $permissions->links(); ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            var _this = this;
            swal({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    $(_this).closest("form").submit();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/permissions/index.blade.php ENDPATH**/ ?>