<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid page-body-wrapper">

    <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title"><?php echo e($title); ?></h4>
                                </div>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-create')): ?>
                                <div class="col-md-2">
                                    <a class="btn btn-success text-white" href="<?php echo e(route('users.create')); ?>"><i class="fa fa-plus-circle"></i> Create New User</a>
                                </div>
                            <?php endif; ?>
                            
                            </div>
                            
                            <?php if(\session('back') == 'index'): ?>
                                
                            <form method="get" class="needs-validation mt-2" action="<?php echo e(route('users.index')); ?>">

                            <?php elseif(\session('back') == 'investerDeactive'): ?>

                            <form method="get" class="needs-validation mt-2" action="<?php echo e(url('/deactive-invester')); ?>">

                            <?php else: ?>

                            <form method="get" class="needs-validation mt-2">

                            <?php endif; ?>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>Search By Name, Email, Mobile No </label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" placeholder="Search" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-info"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                            </form>
                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Role</th>
                                            <th>2FA Status</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($users->count() > 0): ?>
                                            
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>

                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td>+<?php echo e($user->mobile_prefix); ?> <?php echo e($user->mobile_no); ?></td>

                                            <?php 
                                                $role = $user->roles->pluck('name')->implode(',');
                                                $userRole = $role == "Invester" ? "Investor" : $role;
                                            ?>

                                            <td><span class="badge badge-soft-primary mt-2 mr-2"><?php echo e($userRole); ?></span></td>
                                            <td>
                                                <?php if($user["2fa_status"] == 1): ?>
                                                    <span class="badge badge-soft-success mt-2 mr-2">Enable</span> 
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger mt-2 mr-2">Disable</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user["active"] == 1): ?>
                                                    <span class="badge badge-soft-success mt-2 mr-2">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger mt-2 mr-2">De-active</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-soft-primary shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-view')): ?>
                                                        <li class="dropdown-item"><a class="" href="<?php echo e(route('users.show',$user->id)); ?>">Show</a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-edit')): ?>
                                                        <li class="dropdown-item"> <a class="" href="<?php echo e(route('users.edit',$user->id)); ?>">Edit</a>
                                                        </li>
                                                        <li class="dropdown-item"><a class="" href="<?php echo e(url('/userChangePassword',$user->id)); ?>">Change Password</a>
                                                        </li>

                                                        <?php if($user["2fa_status"] == 1): ?>

                                                        <li class="dropdown-item"> <a class=" disable2FADataButton" href="#" attr-userID="<?php echo e($user->id); ?>">Disable 2FA</a>
                                                        </li>

                                                        <?php else: ?>

                                                        <li class="dropdown-item"><a class="" href="<?php echo e(url('/enable2FaUser',$user->id)); ?>">Enable 2FA</a>
                                                        </li>

                                                        <?php endif; ?>
                                                        
                                                        <?php if($user["active"] == 1): ?>

                                                        <li class="dropdown-item"> <a class="deactiveUserButton" href="#" attr-userID="<?php echo e($user->id); ?>">De-active User</a>
                                                        </li>

                                                        <?php else: ?>

                                                        <li class="dropdown-item"> <a class="activeUserButton" href="#" attr-userID="<?php echo e($user->id); ?>">Active User</a>
                                                        </li>

                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </td>

                                            

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php else: ?>

                                      <tr><td colspan=7 align="center">No Records Available..</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            <?php echo $users->links('pagination::bootstrap-4'); ?> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
        $(document).on("click",".disable2FADataButton",function() {
            
            const user_id = $(this).attr('attr-userID');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Please confirm the disable Two Step Verification",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    
                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    let formData = new FormData();
                    formData.set('disable', 'disable');
                    formData.set('id', user_id);
                    axios.post(SITE_URL+'disable2FaUser',formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-Token': csrfToken}}
                    ).then(function (response) {
                        Swal.fire('Great Job !','Two-Factor Authentication (2FA) Is Disbled.','success');
                        setTimeout(location.reload.bind(location), 1500);
                    });
                }
            });
        });
        
        $(document).on("click",".deactiveUserButton",function() {
            
            const user_id = $(this).attr('attr-userID');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Please confirm this user is de-active",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    
                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    let formData = new FormData();
                    formData.set('deactive', 'deactive');
                    formData.set('id', user_id);
                    axios.post(SITE_URL+'deactiveuser',formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-Token': csrfToken}}
                    ).then(function (response) {
                        Swal.fire('Great Job !','This user is de-active.','success');
                        setTimeout(location.reload.bind(location), 1500);
                    });
                }
            });
        });
        
        $(document).on("click",".activeUserButton",function() {
            
            const user_id = $(this).attr('attr-userID');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Please confirm the this user is active",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    
                    var csrfToken = "<?php echo e(csrf_token()); ?>";
                    let formData = new FormData();
                    formData.set('active', 'active');
                    formData.set('id', user_id);
                    axios.post(SITE_URL+'activeuser',formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-Token': csrfToken}}
                    ).then(function (response) {
                        Swal.fire('Great Job !','This user is active.','success');
                        setTimeout(location.reload.bind(location), 1500);
                    });
                }
            });
        });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>