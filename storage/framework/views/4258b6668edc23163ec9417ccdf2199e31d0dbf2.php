<?php $__env->startSection('title', 'Roles'); ?>

<?php $__env->startSection('content'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Role Management</div>
                        <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Index</a>
                        </div>
                    </div>

                    

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-create')): ?>
                    <div class="page-header-action">
                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('roles.create')); ?>"> Create New Role</a>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table center-aligned-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Guard Name</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(++$i); ?></td>
                                                <td><?php echo e($role->name); ?></td>
                                                <td><?php echo e($role->guard_name); ?></td>
                                                <td><?php echo e($role->created_at); ?></td>

                                                
                                                <td class="action">

                                                    <a class="btn btn-info btn-sm" href="<?php echo e(route('roles.show',$role->id)); ?>">Show</a>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-edit')): ?>
                                                        <a class="btn btn-primary btn-sm" href="<?php echo e(route('roles.edit',$role->id)); ?>">Edit</a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-delete')): ?>
                                                        <?php echo Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']); ?>

                                                            <?php echo Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']); ?>

                                                        <?php echo Form::close(); ?>

                                                    <?php endif; ?>

                                                    

                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo $roles->render(); ?>


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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/roles/index.blade.php ENDPATH**/ ?>