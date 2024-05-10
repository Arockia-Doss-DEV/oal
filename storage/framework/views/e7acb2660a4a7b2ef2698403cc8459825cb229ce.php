<?php $__env->startSection('title', 'Edit Newsletter'); ?>

<?php $__env->startSection('styles'); ?>
    <style type="text/css">
        .ck-editor__editable {
          min-height: 350px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    

    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Newsletter</div>
                         <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Update</a>
                        </div>
                    </div>
                    <div class="page-header-action">
                        <a href="<?php echo e(route('newsletters.index')); ?>" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <form action="<?php echo e(route('newsletters.update',$news->id)); ?>" method="POST" enctype='multipart/form-data' data-parsley-validate="">

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                     <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input type="text" name="title" value="<?php echo e($news->title); ?>" class="form-control" placeholder="Name" required="required">

                                                <?php if($errors->has('title')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Detail:</strong>

                                                <textarea class="form-control ckeditor" style="height:150px" name="detail" placeholder="Detail" id="summary-ckeditor"><?php echo e($news->detail); ?></textarea>

                                                

                                                

                                                <?php if($errors->has('detail')): ?>
                                                    <div class="text-danger"><?php echo e($errors->first('detail')); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Slug:</strong>
                                                <input type="text" name="slug" value="<?php echo e($news->slug); ?>" class="form-control" placeholder="Name">

                                                <?php if($errors->has('slug')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('slug')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <strong>Image:</strong>
                                            <input type="file" name="imagefile" class="file-input" data-parsley-max-file-size="5024" accept=".jpeg,.png,.jpg">

                                            <?php if($errors->has('imagefile')): ?>
                                                <br>
                                                <span class="text-danger"><?php echo e($errors->first('imagefile')); ?></span>
                                            <?php endif; ?>
                                        </div>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <br>
                                            <div class="form-group">
                                                <strong>Active:</strong>
                                                <input name="active" type="checkbox" value="1" <?php echo e($news->active == 1 ? ' checked' : ''); ?>>
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

<?php $__env->startSection('scripts'); ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    
    
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

    

    <script type="text/javascript">
        $(document).ready(function () {

            ClassicEditor
            .create(document.querySelector( '#summary-ckeditor'),{
                ckfinder: {
                    uploadUrl: '<?php echo e(route('ckeditor.image-upload').'?_token='.csrf_token()); ?>',
                }
            })
            .catch( error => {
                console.error( error );
            });
        });
    </script> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/newsletters/edit.blade.php ENDPATH**/ ?>