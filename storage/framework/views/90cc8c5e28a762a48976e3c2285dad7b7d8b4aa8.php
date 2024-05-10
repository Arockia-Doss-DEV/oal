<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="main-container">
    <div class="container-fluid">
        
        <?php echo $__env->make("admin.elements.sidebar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- partial -->
        <!-- main-panel starts -->
        <div class="main-panel">
            <!-- content-wrapper Starts -->
            <div class="content-wrapper">
                <div class="row">

                    <div class="col-lg-5">
                        <div class="card card-margin widget-34">
                            <div class="card-body widget-34-container">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="widget-34-title">
                                            Welcome, <?php echo e(Auth::user()->name); ?>! 
                                        </div>
                                        <div class="widget-34-content">
                                            We will help you to conquer your goal
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Active
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_active); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Initial
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_initial); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Additional
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_additional); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Pending
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_pending); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Pending Funding
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_pending_funding); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Joint Accounts
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_joint); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Active Investors
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_active_investors); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-3 col-sm-6 col-6">
                                        <div class="widget-35 card-margin border-base">
                                            <div class="widget-35-title">
                                                Inactive Investors
                                            </div>
                                            <div class="widget-35-number">
                                                <?php echo e($total_inactive_investors); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                    </div>

                </div>

                <!-- Month wise investment bar chart -->

                
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 card-margin">

                        <form id="month_wise_investment" method="post" action="javascript:void(0)" enctype='multipart/form-data' autocomplete="off">
                        <div class="col-lg-12 card-margin">
                            <div class="row">
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="month" id="subscriptionMonth">
                                        <option value=''>Select Month</option>
                                        <option value='1' <?php echo e(app('request')->input('month') == 1 ? 'selected' : ''); ?>>January</option>
                                        <option value='2' <?php echo e(app('request')->input('month') == 2 ? 'selected' : ''); ?>>February</option>
                                        <option value='3' <?php echo e(app('request')->input('month') == 3 ? 'selected' : ''); ?>>March</option>
                                        <option value='4' <?php echo e(app('request')->input('month') == 4 ? 'selected' : ''); ?>>April</option>
                                        <option value='5' <?php echo e(app('request')->input('month') == 5 ? 'selected' : ''); ?>>May</option>
                                        <option value='6' <?php echo e(app('request')->input('month') == 6 ? 'selected' : ''); ?>>June</option>
                                        <option value='7' <?php echo e(app('request')->input('month') == 7 ? 'selected' : ''); ?>>July</option>
                                        <option value='8' <?php echo e(app('request')->input('month') == 8 ? 'selected' : ''); ?>>August</option>
                                        <option value='9' <?php echo e(app('request')->input('month') == 9 ? 'selected' : ''); ?>>September</option>
                                        <option value='10' <?php echo e(app('request')->input('month') == 10 ? 'selected' : ''); ?>>October</option>
                                        <option value='11' <?php echo e(app('request')->input('month') == 11 ? 'selected' : ''); ?>>November</option>
                                        <option value='12' <?php echo e(app('request')->input('month') == 12 ? 'selected' : ''); ?>>December</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="year" id="subscriptionYear">
                                        <option value=''>Select Year</option>
                                        <?php if(count($subscription_years) > 0): ?>
                                            <?php $__currentLoopData = $subscription_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($year->year); ?>"><?php echo e($year->year); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <div class="col-md-0 mt-4 pt-1">
                                        <button class="btn btn-primary" id="month_wise_investment_filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title m-0">Month investment (USD) </h6>
                            </div>
                            <div class="card-body">
                                <div id="month-wise-investment"></div>
                            </div>
                        </div>

                        </form>
                    </div>


                    <div class="col-lg-6 col-md-6 card-margin">
                        <form id="month_wise_additional_investment" method="post" action="javascript:void(0)" enctype='multipart/form-data' autocomplete="off">
                        <div class="col-lg-12 card-margin">
                            <div class="row">
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="month" id="additionalInvestmentSubscriptionMonth">
                                        <option value=''>Select Month</option>
                                        <option value='1' <?php echo e(app('request')->input('month') == 1 ? 'selected' : ''); ?>>January</option>
                                        <option value='2' <?php echo e(app('request')->input('month') == 2 ? 'selected' : ''); ?>>February</option>
                                        <option value='3' <?php echo e(app('request')->input('month') == 3 ? 'selected' : ''); ?>>March</option>
                                        <option value='4' <?php echo e(app('request')->input('month') == 4 ? 'selected' : ''); ?>>April</option>
                                        <option value='5' <?php echo e(app('request')->input('month') == 5 ? 'selected' : ''); ?>>May</option>
                                        <option value='6' <?php echo e(app('request')->input('month') == 6 ? 'selected' : ''); ?>>June</option>
                                        <option value='7' <?php echo e(app('request')->input('month') == 7 ? 'selected' : ''); ?>>July</option>
                                        <option value='8' <?php echo e(app('request')->input('month') == 8 ? 'selected' : ''); ?>>August</option>
                                        <option value='9' <?php echo e(app('request')->input('month') == 9 ? 'selected' : ''); ?>>September</option>
                                        <option value='10' <?php echo e(app('request')->input('month') == 10 ? 'selected' : ''); ?>>October</option>
                                        <option value='11' <?php echo e(app('request')->input('month') == 11 ? 'selected' : ''); ?>>November</option>
                                        <option value='12' <?php echo e(app('request')->input('month') == 12 ? 'selected' : ''); ?>>December</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="year" id="additionalInvestmentSubscriptionYear">
                                        <option value=''>Select Year</option>
                                        <?php if(count($subscription_years) > 0): ?>
                                            <?php $__currentLoopData = $subscription_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($year->year); ?>"><?php echo e($year->year); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <div class="col-md-0 mt-4 pt-1">
                                        <button class="btn btn-primary" id="month_wise_additional_investment_filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title m-0">Month additional investment (USD) </h6>
                            </div>
                            <div class="card-body">
                                <div id="additional-investment-bar-chart"></div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Month wise  new investment bar chart -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 card-margin">

                        <form id="month_wise_new_investment" method="post" action="javascript:void(0)" enctype='multipart/form-data' autocomplete="off">
                        <div class="col-lg-12 card-margin">
                            <div class="row">
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="month" id="newInvestmentSubscriptionMonth">
                                        <option value=''>Select Month</option>
                                        <option value='1' <?php echo e(app('request')->input('month') == 1 ? 'selected' : ''); ?>>January</option>
                                        <option value='2' <?php echo e(app('request')->input('month') == 2 ? 'selected' : ''); ?>>February</option>
                                        <option value='3' <?php echo e(app('request')->input('month') == 3 ? 'selected' : ''); ?>>March</option>
                                        <option value='4' <?php echo e(app('request')->input('month') == 4 ? 'selected' : ''); ?>>April</option>
                                        <option value='5' <?php echo e(app('request')->input('month') == 5 ? 'selected' : ''); ?>>May</option>
                                        <option value='6' <?php echo e(app('request')->input('month') == 6 ? 'selected' : ''); ?>>June</option>
                                        <option value='7' <?php echo e(app('request')->input('month') == 7 ? 'selected' : ''); ?>>July</option>
                                        <option value='8' <?php echo e(app('request')->input('month') == 8 ? 'selected' : ''); ?>>August</option>
                                        <option value='9' <?php echo e(app('request')->input('month') == 9 ? 'selected' : ''); ?>>September</option>
                                        <option value='10' <?php echo e(app('request')->input('month') == 10 ? 'selected' : ''); ?>>October</option>
                                        <option value='11' <?php echo e(app('request')->input('month') == 11 ? 'selected' : ''); ?>>November</option>
                                        <option value='12' <?php echo e(app('request')->input('month') == 12 ? 'selected' : ''); ?>>December</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4 pt-1">
                                    <select class="form-control select2" name="year" id="newInvestmentSubscriptionYear">
                                        <option value=''>Select Year</option>
                                        <?php if(count($subscription_years) > 0): ?>
                                            <?php $__currentLoopData = $subscription_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($year->year); ?>"><?php echo e($year->year); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <div class="col-md-0 mt-4 pt-1">
                                        <button class="btn btn-primary" id="month_wise_new_investment_filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title m-0">Number of new investments </h6>
                            </div>
                            <div class="card-body">
                                <div id="new-investment-bar-chart"></div>
                            </div>
                        </div>
                        </form>
                    </div>

                    <!--source of income  -->
                    
                    
                </div>

                <!--<div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="card card-margin card-rounded flex-grow-1">
                            <div class="card-header">
                                <h5 class="card-title">Country wise invest Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="widget-5">
                                    <div class="widget-5-canvas">
                                        <canvas id="canvas-stats" height="200" class="widget-5-canvas-chart"></canvas>
                                    </div>
                                    <div class="widget-5-canvas-bifurcation">
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">40%</div>
                                                <div class="widget-5-progress-title">India</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">55%</div>
                                                <div class="widget-5-progress-title">China</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-base" role="progressbar" style="width: 55%" aria-valuenow="55"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">60%</div>
                                                <div class="widget-5-progress-title">US</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">30%</div>
                                                <div class="widget-5-progress-title">UK</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="30"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">80%</div>
                                                <div class="widget-5-progress-title">Australia</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="widget-5-bifurcation">
                                            <div class="widget-5-progress">
                                                <div class="widget-5-progress-figure">45%</div>
                                                <div class="widget-5-progress-title">Canada</div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="45"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card card-margin flex-grow-1">
                            <div class="card-header">
                                <h5 class="card-title">Revenue</h5>
                            </div>
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs nav-tabs-block justify-content-center" id="nav-tab1" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-week-tab1" data-toggle="tab" href="#nav-week1" role="tab" aria-controls="nav-week1" aria-selected="true">Weekly</a>
                                        <a class="nav-item nav-link" id="nav-month-tab1" data-toggle="tab" href="#nav-month1" role="tab" aria-controls="nav-month1" aria-selected="false">Monthly</a>
                                        <a class="nav-item nav-link" id="nav-year-tab1" data-toggle="tab" href="#nav-year1" role="tab" aria-controls="nav-year1" aria-selected="false">Yearly</a>
                                    </div>
                                </nav>
                                <div class="tab-content pl-0 pr-0" id="nav-tabContent1">
                                    <div class="tab-pane fade show active" id="nav-week1" role="tabpanel" aria-labelledby="nav-week-tab1">
                                        <div class="widget-7">
                                            <div class="widghet-7-date-filters">
                                                <a href="javascript:void(0);" class="btn btn-sm shadow-none" id="daterange-picker-1">
                                                <i data-feather="calendar"></i>
                                                <span>July 21 - August 19</span>
                                                </a>
                                            </div>
                                            <div class="widghet-7-chart">
                                                <canvas id="revenue-weekly" height="279"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-month1" role="tabpanel" aria-labelledby="nav-month-tab1">
                                        <div class="widget-7">
                                            <div class="widghet-7-date-filters">
                                                <a href="javascript:void(0);" class="btn btn-sm shadow-none" id="daterange-picker-2">
                                                <i data-feather="calendar"></i>
                                                <span>July 21 - August 19</span>
                                                </a>
                                            </div>
                                            <div class="widghet-7-chart">
                                                <canvas id="revenue-monthly" height="279"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-year1" role="tabpanel" aria-labelledby="nav-year-tab1">
                                        <div class="widget-7">
                                            <div class="widghet-7-date-filters">
                                                <a href="javascript:void(0);" class="btn btn-sm shadow-none" id="daterange-picker-3">
                                                <i data-feather="calendar"></i>
                                                <span>July 21 - August 19</span>
                                                </a>
                                            </div>
                                            <div class="widghet-7-chart">
                                                <canvas id="revenue-yearly" height="279"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>-->
                
                <!--<div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card card-rounded">
                            <div class="card-header">
                                <h5 class="card-title">Contry Investor</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table widget-6">
                                                <tbody>
                                                    <tr>
                                                        <td class="border-top-0">
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-in" title="in" id="in"></i> India</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-top-0">
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">231K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">12K
                                                                        <small class="text-danger"><strong>23%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">31M
                                                                        <small class="text-success"><strong>23%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-cn" title="cn" id="cn"></i> China</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">389K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">18K
                                                                        <small class="text-danger"><strong>10%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">25M
                                                                        <small class="text-success"><strong>38%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-us" title="us" id="us"></i> United States</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">210K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">10K
                                                                        <small class="text-danger"><strong>5%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">19M
                                                                        <small class="text-success"><strong>15%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-gb" title="gb" id="gb"></i> Great Britain</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">192K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">6K
                                                                        <small class="text-danger"><strong>2%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">8M
                                                                        <small class="text-success"><strong>46%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-au" title="au" id="au"></i> Australia</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">154K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">5K
                                                                        <small class="text-danger"><strong>1.8%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">4M
                                                                        <small class="text-success"><strong>34%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-6-title-wrapper">
                                                                <div class="widget-6-product-info">
                                                                    <div class="title"><i class="flag-icon flag-icon-ca" title="ca" id="ca"></i> Canada</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-6-desc">
                                                                <div class="widget-6-order-wrapper">
                                                                    <div class="figure">128K</div>
                                                                    <div class="desc">Total Orders</div>
                                                                </div>
                                                                <div class="widget-6-return-wrapper">
                                                                    <div class="figure">4K
                                                                        <small class="text-danger"><strong>1.2%</strong> <i data-feather="arrow-down"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Returns</div>
                                                                </div>
                                                                <div class="widget-6-earning-wrapper">
                                                                    <div class="figure">2M
                                                                        <small class="text-success"><strong>28%</strong> <i data-feather="arrow-up"></i></small>
                                                                    </div>
                                                                    <div class="desc">Total Earnings</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="map-world"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->


            </div>
            <!-- content-wrapper ends -->
            
            <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('admin/js/components/legacy-sidebar/dashboard-msb.js')); ?>"></script>
<script type="text/javascript">
    (function () {
        'use strict';
        //Chart #3
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Total Investment Amount',
                data: <?php echo json_encode($investment_amount_rows); ?>
            }],
            xaxis: {
                categories: <?php echo json_encode($investment_month_rows); ?>,
            },
            yaxis: {
                title: {
                    text: 'USD'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " USD"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#month-wise-investment"),
            options
        );

        chart.render();


        //Chart #3
        var options = {
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Total Investment Amount',
                data: <?php echo json_encode($addinvestment_amount_rows); ?>
            }],
            xaxis: {
                categories: <?php echo json_encode($addinvestment_month_rows); ?>,
            },
            yaxis: {
                title: {
                    text: 'USD'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " USD"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#additional-investment-bar-chart"),
            options
        );

        chart.render();

        // Number Of New Investments
        Morris.Bar({
            element: 'new-investment-bar-chart',
            data: <?php echo json_encode($month_wise_new_investment_rows); ?>,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['No Of Investment'],
            lineColors: ['#09AD95'],
            barColors: ['#09AD95'],
            lineWidth: '2px',
            resize: true,
            redraw: true
        });

        // pie chart source of income
        // Morris.Donut({
        //     element: 'donut-chart',
        //     data: [{ "value": "36.36", "label": "Personal Saving \/ Salary" }, { "value": "63.64", "label": "Business Income" }, { "value": "0.00", "label": "Dividends from other entry" }, { "value": "0.00", "label": "Transactions" }, { "value": "0.00", "label": "Others" }],
        //     labelColor: '#637CF9',
        //     colors: [
        //         '#FBA752',
        //         '#1A9CDF',
        //         '#AC7E00',
        //         '#F34100',
        //         '#DE1BD1',
        //         '#8A52FB',
        //     ],
        //     resize: true,
        //     formatter: function (x) { return x + "%" }
        // });

    })(jQuery);


    var csrfToken = "<?php echo e(csrf_token()); ?>";

    /////////////////////////////////////////////////////////////////////

    $(document).on("click","#month_wise_investment_filter", function (e) {
        
        e.preventDefault();

        var month = $('#subscriptionMonth option:selected').val();
        var year = $('#subscriptionYear option:selected').val();

        if(month != null && month != '' && year != null && year != '') {

            preloader_init();

            const form = document.getElementById('month_wise_investment');
            let formData = new FormData(form);
            formData.set('month', month);
            formData.set('year', year);
            
            axios.post(SITE_URL+'month/investment',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){

                var item =response.data;

                var investment_amount_rows = item.data.investment_amount_rows;
                var investment_month_rows = item.data.investment_month_rows;

                // console.log(investment_amount_rows);
                
                preloader_off();

                (function () {
                    'use strict';

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Total Investment Amount',
                            data: investment_amount_rows
                        }],
                        xaxis: {
                            categories: investment_month_rows,
                        },
                        yaxis: {
                            title: {
                                text: 'USD'
                            }
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " USD"
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(
                        document.querySelector("#month-wise-investment"),
                        options
                    );

                    chart.render();


                    // preloader_off();

                    // var item =response.data;
                    // if(item.error === 0){
                    //     $('#subscription_id').val(item.data.id);
                    //     toastr.success("Your data saved successfully");
                    // }

                })(jQuery);

            });

        } else {
            alert('select field cannot be empty');
        }

    });

    ///////////////////////////////////////////////////////////////////////////////

    $(document).on("click","#month_wise_additional_investment_filter", function() {

        var month = $('#additionalInvestmentSubscriptionMonth option:selected').val();
        var year = $('#additionalInvestmentSubscriptionYear option:selected').val();

        if(month != null && month != '' && year != null && year != '') {

            preloader_init();

            const form = document.getElementById('month_wise_additional_investment');
            let formData = new FormData(form);
            formData.set('month', month);
            formData.set('year', year);
            
            axios.post(SITE_URL+'month/additional/investment',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){

                var item =response.data;

                var addinvestment_amount_rows = item.data.addinvestment_amount_rows;
                var addinvestment_month_rows = item.data.addinvestment_month_rows;

                // console.log(investment_amount_rows);
                
                preloader_off();

                (function () {
                    'use strict';

                    var options = {
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: [{
                            name: 'Total Investment Amount',
                            data: addinvestment_amount_rows
                        }],
                        xaxis: {
                            categories: addinvestment_month_rows,
                        },
                        yaxis: {
                            title: {
                                text: 'USD'
                            }
                        },
                        fill: {
                            opacity: 1

                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " USD"
                                }
                            }
                        }
                    }

                    var chart = new ApexCharts(
                        document.querySelector("#additional-investment-bar-chart"),
                        options
                    );

                    chart.render();

                })(jQuery);

            });

        } else {
            alert('select field cannot be empty');
        }

    });

    ///////////////////////////////////////////////////////////////////////////////

    $(document).on("click","#month_wise_new_investment_filter", function() {

        var month = $('#newInvestmentSubscriptionMonth option:selected').val();
        var year = $('#newInvestmentSubscriptionYear option:selected').val();

        if(month != null && month != '' && year != null && year != '') {

            preloader_init();

            const form = document.getElementById('month_wise_new_investment');
            let formData = new FormData(form);
            formData.set('month', month);
            formData.set('year', year);
            
            axios.post(SITE_URL+'month/new/investment',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){

                var item =response.data;

                var month_wise_new_investment_rows = item.data.month_wise_new_investment_rows;
                var targetId = 'new-investment-bar-chart';
                
                // console.log(investment_amount_rows);
                
                preloader_off();

                (function () {
                    'use strict';

                    Morris.Bar({
                        element: targetId,
                        data: month_wise_new_investment_rows,
                        xkey: 'y',
                        ykeys: ['a'],
                        labels: ['No Of Investment'],
                        lineColors: ['#09AD95'],
                        barColors: ['#09AD95'],
                        lineWidth: '2px',
                        resize: true,
                        redraw: true
                    });
                    
                })(jQuery);

            });

        } else {
            alert('select field cannot be empty');
        }

    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>