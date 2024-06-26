<?php $__env->startSection('title', 'Create Role'); ?>

<?php $__env->startSection('content'); ?>
    

    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Role</div>
                         <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Create New Role</a>
                        </div>
                    </div>
                    <div class="page-header-action">
                        <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <?php if($message = Session::get('success')): ?>
                                    <div class="alert alert-success">
                                        <p><?php echo e($message); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php echo Form::open(array('route' => 'roles.store','method'=>'POST')); ?>

                                     <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <?php echo Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')); ?>

                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Permission:</strong>
                                                <br/>
                                                <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label><?php echo e(Form::checkbox('permission[]', $value->id, false, array('class' => 'name'))); ?>

                                                    <?php echo e($value->name); ?></label>
                                                <br/>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                       
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                <?php echo Form::close(); ?>


                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/roles/create.blade.php ENDPATH**/ ?>