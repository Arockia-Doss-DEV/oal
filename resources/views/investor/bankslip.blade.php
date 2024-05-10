@extends('layouts.app')

@section('title', 'Upload Bank Slip')

@section('content')

<div class="container-fluid page-body-wrapper">
        
    @include("investor.elements.sidebar")

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Pending Funding Investment</h4>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>INVESTMENT ID</th>
                                            <th>AMOUNT</th>
                                            <th>COMMENCEMENT DATE</th>
                                            <th>SUBMISSION DATE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscriptions as $subscription)
                                        <tr>
                                            <td>
                                                <?php 
                                                    if (!empty($subscription->investment_name)) {
                                                        if (($subscription->status == 3) || ($subscription->status == 6)) {
                                                            $investment_no = $subscription->investment_name.$subscription->investment_no;
                                                        } else {
                                                            $investment_no = $subscription->investment_name.$subscription->investment_no;
                                                        }
                                                    }else{
                                                        $investment_no = $subscription->investment_no;
                                                    }
                                                ?>

                                                #{{ $investment_no }}
                                            </td>
                                            <td>{{$subscription->amount}}</td>
                                            <td>{{ $subscription->commencement_date ? date('d-M-y', strtotime($subscription->commencement_date))  : '' }}</td>
                                            <td>{{ $subscription->created_at ? date('d-M-y', strtotime($subscription->created_at))  : '' }}</td>
                                            <td> <span class="badge badge-warning mt-2 mr-2">Pending Funding</span> </td>
                                            <td class="actions">

                                                <?php 
                                                    if(!empty($subscription['SsDocumentAs'])):
                                                        $documents = getDocument($subscription['SsDocumentAs']);
                                                        foreach ($documents as $document):
                                                ?>
                                                    <a class="btn btn-sm btn-elevate btn-brand btn-elevate btn-info" href="{{ asset('storage/'.$document['file']) }}" target="_blank" >Open</a>
                                                <?php 
                                                    endforeach;
                                                endif; ?> 

                                                <button type="button" class="btn btn-sm btn-elevate btn-brand btn-elevate btn-danger uploadDocLink" get-sub-id="{{ $subscription->id }}" >
                                                     Bank Slip Upload
                                                </button>
                                            </td> 
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('investor.elements.footer')

    </div>
</div>


 <div class="modal fade" id="updatepassportDataModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">Upload Bank Slip</h5>
            </div>

            {!! Form::open(['url' => '/investor/uploadBankslipSave', 'files' => true, 'id' => 'formBankSlip', 'data-parsley-validate' => 'data-parsley-validate', 'autocomplete'=>"off" ]) !!}

            <div class="modal-body">
                
                <div class="row">
                    
                    <input type="hidden" name="sub_att_id" id="sub_att_id">
                    
                    <div class="col-md-12">
                        <div class="kt-portlet__head-label">
                            <h6 class="kt-portlet__head-title"><br>Bank Slip</h6>
                            <span class="text-danger">Note: 
                                <br>1. Maximum upload file size: 5MB. Supported file type: PDF, JPEG and PNG 
                                <br>2. You can upload 1 file at the same time.
                            </span>
                        </div><br><br>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label>Document</label> 
                        <input type="file" class="updateSignDocument" attr-sub_type="11" data-height="300" data-max-file-size="5M" data-allowed-file-extensions="pdf png jpg" data-show-remove="false" required/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="actions">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<?php 
    
    function getDocument($ssDocumentAs){

        $output = [];
        foreach ($ssDocumentAs as $document) {
                                            
            $id = $document['id'];
            $main_type = $document['main_type'];
            $sub_type = $document['sub_type'];
            $file = $document['file'];
            $name = $document['remarks'];

            if($main_type == 7){
                //*******3********///
                if($sub_type == 71){

                    $output[] = ["id"=> $id, "main_type"=> $main_type,"sub_type"=> $sub_type, "file" => $file, "name" => $name];
                }
            }
        }// For Loop
        return $output;
    }//End Function
?>

@endsection



@section('scripts')
<script type="text/javascript">

    $('.uploadDocLink').click(function(e){
        $('#formBankSlip')[0].reset();
        $('#updatepassportDataModel').modal('show');
        
        var source_id = $(this).attr("get-sub-id");
        $("#sub_att_id").val(source_id);
    });


    var drEvent = $('.updateSignDocument').dropify();

    drEvent.on('dropify.beforeClear', function(event, element){
        console.log(element);
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element){
        
        alert('File deleted');
    });

    $('.updateSignDocument').change(function() {
        
        if ($(this).get(0).files.length) {

            preloader_init();

            var csrfToken = "{{ csrf_token() }}";
            var fd = new FormData();
            var file = $(this)[0].files[0];
    
            fd.append('file', file);
            fd.append('sub_att_id', $("#sub_att_id").val());
    
            axios.post(SITE_URL+'investor/uploadBankslipSave',fd,{
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-Token': csrfToken}}
            ).then(function(response){

                preloader_off();

                Swal.fire('Great Job !','You have uploaded Bank Slip successfully, OAL team will verify the Bank Slip!','success');
    
                $('#updatepassportDataModel').modal('hide');
                setTimeout(location.reload.bind(location), 1500);  
    
            })
            .catch(function(){

                preloader_off();
                
                $('#updatepassportDataModel').modal('hide');
                Swal.fire('Sorry !','Bank Slip upload faild!','error');
            });
        }
    });


</script>
@endsection

