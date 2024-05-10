<?php $__env->startSection('title', 'Create Permission'); ?>

<?php $__env->startSection('content'); ?>
    

    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Permission</div>
                         <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Create</a>
                        </div>
                    </div>
                    <div class="page-header-action">
                        <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-secondary">Back</a>
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

                                <form action="<?php echo e(route('permissions.store')); ?>" method="POST" enctype='multipart/form-data' data-parsley-validate="">

                                	<?php echo csrf_field(); ?>
                                     <div class="row">
                            		    <div class="col-xs-12 col-sm-12 col-md-6">
                            		        <div class="form-group">
                            		            <strong>Permission Name:</strong>
                            		            <input type="text" name="name" class="form-control" placeholder="Permission Name" required="required" value="<?php echo e(old('name')); ?>">
                            		        </div>
                            		    </div>
                            		    
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>Guard Name:</strong>
                                                <select name="guard_name" class="selectpicker">
                                                    <option value="web">Website</option>
                                                    <option value="api">API</option>
                                                </select>

                                                <?php if($errors->has('guard_name')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('guard_name')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                       
                            		    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                            		            <button type="submit" class="btn btn-primary">Submit</button>
                            		    </div>
                            		</div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/permissions/create.blade.php ENDPATH**/ ?>