

<?php $__env->startSection('title', 'Create Admin'); ?>

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
                        <a href="<?php echo e(url('/system/admins')); ?>" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <?php if($errors->any()): ?>
                                     <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="alert alert-danger">
                                            <p><?php echo e($error); ?></p>
                                        </div>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>

                                <?php if($message = Session::get('success')): ?>
                                    <div class="alert alert-success">
                                        <p><?php echo e($message); ?></p>
                                    </div>
                                <?php endif; ?>

                                <form action="<?php echo e(route('admin.store')); ?>" method="POST" enctype='multipart/form-data' data-parsley-validate="">
                                	<?php echo csrf_field(); ?>
                                    <div class="row col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Salutation</label>
                                                <?php 
                                                
                                                $salutationOption = ['Mr.'=> 'Mr','Mrs.'=> 'Mrs','Ms.'=> 'Ms','Dr.'=> 'Dr','Prof.'=> 'Prof','Assoc. Prof.'=> 'Assoc. Prof','Dato.'=> 'Dato',"Dato Sri."=>"Dato Sri","Datin."=>"Datin","Datuk."=>"Datuk", "Datuk Sri."=>"Datuk Sri","Haji."=>"Haji","Hajjah."=>"Hajjah","Puteri."=>"Puteri","Puan Sri."=>"Puan Sri","Raja."=>"Raja","Tan Sri."=>"Tan Sri","Tengku."=>"Tengku","Tun."=>"Tun","Tun Poh."=>"Tun Poh", 'Tunku.'=>'Tunku']; ?>
                                                <?php echo Form::select('salutation', $salutationOption, old('salutation') ? old('salutation') : "", ['class' => 'form-control', 'id' => 'salutation', 'data-parsley-group'=>"block1"]); ?>

                                            </div>
                                        </div>

                            		    <div class="col-md-4">
                            		        <div class="form-group">
                            		            <strong>Username *</strong>
                            		            <input type="text" name="username" class="form-control" placeholder="Username" required="required" value="<?php echo e(old('username')); ?>">
                            		        </div>
                            		    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Email *</strong>
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required" value="<?php echo e(old('email')); ?>">
                                            </div>
                                        </div>

                            		</div>

                                    <div class="row col-md-12">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="ip">Country Code *</label>

                                                <select class="form-control" name="mobile_prefix" id="mobile_prefix" data-parsley-group = "block1" data-parsley-type="digits" data-live-search="false" required>
                                                    <?php $__currentLoopData = $phone_prefix; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($data['code']); ?>"><?php echo e($data['country']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="ip">Phone Number *</label>
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Phone Number" data-parsley-type="digits" value="<?php echo e(old('mobile_no')); ?>" required data-parsley-group="block1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Password *</strong>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Confirm Password </strong>
                                                <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required="required">
                                            </div>
                                        </div>

                                    </div>

                                    

                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>User Role *</strong>
                                                <select name="role_id" class="form-control" required>
                                                    <option value="">Select Role</option>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <?php if($errors->has('role_id')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('role_id')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>User Status *</strong>
                                                <select name="active" class="form-control" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>

                                                <?php if($errors->has('active')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('active')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                        		    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                        		          <button type="submit" class="btn btn-primary">Submit</button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/users/admin-create.blade.php ENDPATH**/ ?>