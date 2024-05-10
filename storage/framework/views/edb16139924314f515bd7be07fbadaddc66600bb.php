

<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

    <style type="text/css">

    .multiselect-container {
      width: 100% !important;
    }

    .dropdown-menu {width:100% !important;}

    </style>
<?php $__env->stopSection(); ?>

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
                                    <h4 class="card_title">Reports</h4>
                                </div>
                            </div>

                            <?php echo e(Form::open(['url' => '/contract/reports', 'id'=>'reportsForm', 'class'=>'', 'data-parsley-validate'=>'data-parsley-validate', 'autocomplete'=>"off", 'files' => true])); ?>


                            <div class="row">
                                <form method="get" action="<?php echo e(url('/contract/reports')); ?>">
                                    <div class="col-lg-3">
                                         <label>Search by </label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" id="query" placeholder=" Name, Investment ID, Bank, Account Name, Account Number" class="form-control search-input" value="<?php echo e(request()->get('q','')); ?>" />
                                            <div class="input-group-append">
                                                <button type="submit" id="search_btn" class="btn btn-info"> 
                                                    <i data-feather="search"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-lg-2">
                                    <label>Start Date: </label>
                                    <input type="date" class="form-control search-input" name="start_date" id="start_date" data-parsley-errors-container="#start_date_error" required="required">
                                    <div id="start_date_error"></div>
                                </div>
                            
                                <div class="col-lg-2">
                                    <label>End Date: </label>
                                    <input type="date" class="form-control search-input" name="end_date" id="end_date" data-parsley-errors-container="#end_date_error" required="required">
                                    <div id="end_date_error"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label>Class Type</label><br>
                                    <select class="form-control fund-sub-input" id="class_type" data-parsley-errors-container="#class_type_error" name="class_type" required="required">
                                        <option value="">Select class ...</option>
                                        <option value="0">All</option>
                                        <?php $__currentLoopData = $investmentClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div id="class_type_error"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label>Status</label><br>
                                    <?php 
                                        $options = ["0" =>"Draft", "1"=> "Pending", "2"=>"Pending Funding", "3"=>"Active", "4"=>"Redeemed ", "5"=>"Rejected" ];
                                    ?>
                                    <?php echo Form::select('status[]', $options, null, ['class' => 'form-control fund-sub-input', 'id' => 'status', 'multiple' => '', 'data-parsley-errors-container' => '#status_error', 'required'=> 'required']); ?>

                                    <div id="status_error"></div>
                                </div>
                                <div class="col-lg-1 text-md-left mt-4 pt-2">
                                    <button type="button" class="btn btn-info" id="viewButton"><i data-feather="filter"></i></button>
                                </div>
                            </div>

                            <?php echo e(Form::close()); ?>


                            <div class="table-responsive mt-2" id="data">

                                <?php echo $__env->make('admin.report.child', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                            </div>
                            
                            <br>

                            <div class="mt-3 text-right">
                                <button type="button" id="exportButton" class="btn btn-info"><i data-feather="download"></i> Export</button>
                            </div>

                            
                            
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    $('#excelButton').click(function(){
        $('#excelButton').button('please wait ...');
    });

    $(document).ready(function(){

        $('#status').multiselect({
            nonSelectedText: 'Select status',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonClass: 'form-control fund-sub-input',
        });

        $(document).on('click', '.page-link', function(e){
            e.preventDefault();

            // let status = $('#status').children("option:selected").val();
            var status=[];
            var $el=$("#status");
            $el.find('option:selected').each(function(){
                status.push($(this).val());
            });

            $('.pagination li').removeClass('active');
            $(this).parent('li').addClass('active');

            var url = $(this).attr('href').split('page=')[1];
            history.pushState(null,null,'?page=' + url);
            getReport(url);
        });

        function getReport(url) {

            let _token = $("input[name=_token]").val();

            var status=[];
            var $el=$("#status");
            $el.find('option:selected').each(function(){
                status.push($(this).val());
            });

            let start_date = $("#start_date").val();
            let end_date = $("#end_date").val();

            if(start_date != null && start_date != '' || end_date != null && end_date != '') {
               
                var date = '&start_date=' + start_date + '&end_date=' + end_date;
            } else {
                var date = "";
            }

            $.ajax({
                
                url:SITE_URL+"contract/reports/?page=" + url + '&status=' + status + date,
                type: 'GET',
                datatype: 'html',
                data:{status:status, _token:_token},

            }).done(function (data) {

                // console.log(data);
                // $('#data').html(data);
                $('#data').empty().html(data);

            }).fail(function () {
                alert('Reports could not be loaded.');
            });
        }

        $(document).on("click","#viewButton",function(e) {
            if ($('#reportsForm').parsley().validate()) {

                // let status = $('#status').children("option:selected").val();

                var status=[];
                var $el=$("#status");
                $el.find('option:selected').each(function(){
                    status.push($(this).val());
                });

                var class_type = $("#class_type").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                // if(start_date != null && start_date != '' || end_date != null && end_date != '') {
                //     var date = '&start_date=' + start_date + '&end_date=' + end_date;
                // } else {
                //     var date = "";
                // }

                let page = 1;
                history.pushState(null,null,'?page=' + page);
                $.ajax({
                    url:SITE_URL+"contract/reports/?page=" + page,
                    type: 'get',
                    datatype: 'html',
                    data:{status:status, class_type:class_type, start_date:start_date, end_date:end_date},
                    success:function(data){
                        $('#data').empty().html(data);
                        // $('#data').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#search_btn', function(e){
            e.preventDefault();

            var query = $("#query").val();

            let page = 1;
            history.pushState(null,null,'?page=' + page);
            $.ajax({
                url:SITE_URL+"contract/reports/?page=" + page,
                type: 'get',
                datatype: 'html',
                data:{query:query},
                success:function(data){
                    $('#data').empty().html(data);
                    // $('#data').html(data);
                }
            });
        });

    });

    $(document).on("click","#exportButton",function(e) {

        if ($('#reportsForm').parsley().validate()) {

            e.preventDefault();
            preloader_init();

            var csrfToken = "<?php echo e(csrf_token()); ?>";
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            // var status = $('#status').children("option:selected").val();

            var status=[];
            var $el=$("#status");
            $el.find('option:selected').each(function(){
                status.push($(this).val());
            });
            
            var class_type = $("#class_type").val();

            const form = document.getElementById('reportsForm');
            let formData = new FormData(form);
            formData.set('start_date', start_date);
            formData.set('end_date', end_date);
            formData.set('status', status);
            formData.set('class_type', class_type);

            axios.post(SITE_URL+'reports/contractSummeryExcel',formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-Token': csrfToken}}
            ).then(function(response){
                
                preloader_off();

                if(response.data.data === "success"){ 

                    var file = response.data.filename;
                    var filename = base_url+"project_img/reports/"+file;
                    //window.open(filename, "_blank")

                    var link = document.createElement("a");
                    link.download = 'contract-summary'+'.xlsx';
                    link.href = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    delete link;

                }else{
                    Swal.fire('Sorry!',"Please try again.",'error');
                }

            })
            .catch(function(error){
                console.log(error);
                // alert('File not detected');
                preloader_off();
            });
        }
    });

</script>  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/admin/report/index.blade.php ENDPATH**/ ?>