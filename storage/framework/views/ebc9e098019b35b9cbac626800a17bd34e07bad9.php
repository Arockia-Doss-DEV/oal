<?php $__env->startSection('title', 'Prices'); ?>

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
                                    <h4 class="card_title">Latest Price (Class A)</h4>
                                </div>

                                <div class="col-lg-2 text-md-right">
                                    <a class="btn btn-sm btn-success text-white" href="<?php echo e(route('prices.create', ['classType' => 1])); ?>"> Add New Price</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Quarterly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if(!empty($class_a_price)): ?>
                                                
                                                <td class="border-0"><i class="fa fa-calendar-alt"></i> <?php echo e($class_a_price->dealing_date); ?> </td>
                                                <td class="border-0"><i class="fa fa-dollar-sign"></i> <?php echo e($class_a_price->latest_price); ?></td>
                                                <td class="border-0"></i> <?php echo e($class_a_price->quarterly_return); ?> <i class="fa fa-percentage"></td>
                                                
                                                <td class="border-0"> <?php echo e($class_a_price->ytd_return); ?> <i class="fa fa-percentage"></i></td>
                                            <?php else: ?>

                                                <td>No Records Found!</td>

                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <h4 class="card_title">Price Table (Class A)</h4>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Quarterly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($class_a_priceHistorys->count() > 0): ?>
                                            
                                        <?php $__currentLoopData = $class_a_priceHistorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>

                                            <td class="border-0"><i class="fa fa-calendar-alt"></i> <?php echo e($price->dealing_date); ?> </td>
                                            <td class="border-0"><i class="fa fa-dollar-sign"></i> <?php echo e($price->latest_price); ?></td>
                                            <td class="border-0"></i> <?php echo e($price->quarterly_return); ?> <i class="fa fa-percentage"></td>
                                                
                                            <td class="border-0"> <?php echo e($price->ytd_return); ?> <i class="fa fa-percentage"></i></td>

                                            <td class="border-0">
                                                <form action="<?php echo e(route('prices.destroy',$price->id)); ?>" method="POST">
                                                    <a class="btn btn-sm btn-soft-primary" href="<?php echo e(route('EditPrice', ['PriceId' => $price->id, 'classType' => 1])); ?>">Edit</a>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php else: ?>

                                      <tr><td colspan=6 align="center">No Records Available..</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            <?php echo $class_a_priceHistorys->links('pagination::bootstrap-4'); ?> 
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Latest Price (Class B)</h4>
                                </div>

                                <div class="col-lg-2 text-md-right">
                                    <a class="btn btn-sm btn-success text-white" href="<?php echo e(route('prices.create', ['classType' => 2])); ?>"> Add New Price</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Monthly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if(!empty($class_b_price)): ?>
                                                <td class="border-0"><i class="fa fa-calendar-alt"></i> <?php echo e($class_b_price->dealing_date); ?> </td>
                                                <td class="border-0"><i class="fa fa-dollar-sign"></i> <?php echo e($class_b_price->latest_price); ?></td>
                                                <td class="border-0"></i> <?php echo e($class_b_price->quarterly_return); ?> <i class="fa fa-percentage"></td>
                                                
                                                <td class="border-0"> <?php echo e($class_b_price->ytd_return); ?> <i class="fa fa-percentage"></i></td>
                                            <?php else: ?>

                                                <td>No Records Found!</td>

                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <h4 class="card_title">Price Table (Class B)</h4>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Monthly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if($class_b_priceHistorys->count() > 0): ?>
                                            
                                        <?php $__currentLoopData = $class_b_priceHistorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="border-0"><i class="fa fa-calendar-alt"></i> <?php echo e($price->dealing_date); ?> </td>
                                            <td class="border-0"><i class="fa fa-dollar-sign"></i> <?php echo e($price->latest_price); ?></td>
                                            <td class="border-0"></i> <?php echo e($price->quarterly_return); ?> <i class="fa fa-percentage"></td>
                                                
                                            <td class="border-0"> <?php echo e($price->ytd_return); ?> <i class="fa fa-percentage"></i></td>

                                            <td class="border-0">
                                                <form action="<?php echo e(route('prices.destroy',$price->id)); ?>" method="POST">
                                                    <a class="btn btn-sm btn-soft-primary" href="<?php echo e(route('EditPrice', ['PriceId' => $price->id, 'classType' => 2])); ?>">Edit</a>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php else: ?>

                                      <tr><td colspan=6 align="center">No Records Available..</td></tr>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            <?php echo $class_b_priceHistorys->links('pagination::bootstrap-4'); ?> 
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/prices/index.blade.php ENDPATH**/ ?>