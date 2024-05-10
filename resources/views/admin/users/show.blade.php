@extends('layouts.app')

@section('title', 'Investor View')

@section('content')

<div class="container-fluid page-body-wrapper">

    @include("admin.elements.sidebar")

    <div class="main-panel">
        <div class="content-wrapper">

            <div class="page-header-container">
                <div class="page-header-main">
                    <div class="page-title">Investor Details & Subscriptions</div>
                    <div class="header-breadcrumb">
                        <a href="#"><i data-feather="airplay"></i> Show</a>
                    </div>
                </div>
                <div class="page-header-action">
                     
                    {{-- <button type="button" class="btn btn-primary btn-sm" id="contractButton">Contract Edit</button>

                    <button type="button" class="btn btn-primary btn-sm" id="investmentDetailsButton">Investment Details Edit</button> --}}



                    {{-- <a class="btn btn-primary" href="{{ url('/subscriptionCreate/'.$user->id) }}"><i class="fa fa-plus"></i> Create Subscription</a> --}}




                    {{-- old --}}

                    {{-- @if ($check_investment == 1)
                                        
                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createNewInvestorSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id]) }}';">Create Subscription</button> 

                    @elseif($check_investment == 0)

                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createInvestorAdditionalSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id]) }}';"> Create Additional Investment </button> 
                        
                    @else

                    @endif --}}

                    {{-- old --}}




                                        
                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createNewInvestorSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id, 'isInitial' => 1]) }}';">Create Subscription</button> 

                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createInvestorAdditionalSubscription', ['classId' => @$check_investment_class->investment_class_type, 'userId' => @$user->id, 'isAdditional' => 1]) }}';"> Create Additional Investment </button> 
                        
                    


                    <a class="btn btn-secondary btn-sm" href="#" onclick="location.href = document.referrer; return false;" ><i class="fa fa-angle-double-left"></i> Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">

                            {{-- <div class="row">
                                <div class="col-md-8">
                                    <h4 class="card_title">Investor Details</h4>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="{{ url('/subscriptionCreate/'.$user->id) }}"><i class="fa fa-plus"></i> Create Subscription</a>

                                    <a class="btn btn-secondary" style="float: right" href="#" onclick="location.href = document.referrer; return false;"><i class="fa fa-angle-double-left"></i> Back</a>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Investor Details</h4>
                            </div>

                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Name </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user->role_id == 3 ? $user->salutation : '' }} {{ $user->name }}
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Email </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Mobile No </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : +{{ $user->mobile_prefix }} {{ $user->mobile_no }}
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Country </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user['countryAs']['name'] }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Address</h4>
                            </div>

                            <div class="row mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Country </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user['countryAs']['name'] }}
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">City </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user->city }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">State </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user['stateAs']['name'] }}
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                <span class="">Post Code </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-1">
                                                : {{ $user->post_code }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-0">
                                                <span class="">Address Line 1 </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-0">
                                                : {{ $user->address_line1 }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 p-1">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 mt-0">
                                                <span class="">Address Line 2 </span>
                                            </div>

                                            <div class="col-md-6 col-sm-6 mt-0">
                                                : {{ $user->address_line2 }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- <div class="row mt-3 mb-2 ml-2 show-border">
                                <div class="row col-md-12 show-first-sec">
                                    {{ $user->address_line1 }}, {{ $user->address_line2 }}, {{ $user->city }}, {{ $user->post_code }}, {{ $user['stateAs']['name'] }}, {{ $user['countryAs']['name'] }}.
                                </div>
                            </div> --}}

                            {{-- <h5>Subscriptions</h5> --}}
                            <div class="col-md-6">
                                <h4 class="card_title title_bNone">Subscriptions</h4>
                            </div>
                            <form method="get" class="needs-validation mt-3" action="{{ route('users.show', $user->id) }}">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Search By Investment No </label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" placeholder="Search" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-info"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Class Type</label>
                                        <div class="input-group mb-3">
                                            <select id="class_type" class="form-control select2" name="class_type">
                                                <option value="">Select class ...</option>
                                                <option value="0">All</option>
                                                @foreach ($investmentClasses as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Investment Type</label>
                                        <div class="input-group mb-3">
                                            <select id="investment_type" class="form-control select2" name="investment_type">
                                                <option value="">Select investment type ...</option>
                                                <option value="3">All</option>
                                                <option value="1">Initial</option>
                                                <option value="0">Additional</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label></label>
                                        <div class="input-group mt-2">
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-primary"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                            <input type="hidden" name="clear" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-soft-danger"> 
                                                    <i data-feather="x"></i> 
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
                                            <th>INVESTMENT ID</th>
                                            <th>INITIAL AMOUNT</th>
                                            <th>COMMENCEMENT DATE</th>
                                            <th>TOTAL VALUE OF ADDITIONAL INVESTMENT</th>
                                            <th>VALUE OF SHAREHOLDING</th>
                                            <th>INVESTMENT CLASS</th>
                                            <th>INVESTMENT TYPE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @if ($subscriptions->count() > 0)
                                        
                                        @foreach($subscriptions as $subscription)

                                        {{-- @if ($subscription->is_first == 1) --}}
                                        @if (($subscription->is_first == 1) || ($subscription->status == 0) || ($subscription->status != 3))
                                           
                                        <tr>
                                            <td class="font-weight-bold">
                                                <?php 
                                                    if (!empty($subscription->investment_name)) {
                                                        if (($subscription->status == 3) || ($subscription->status == 6)) {
                                                            $investment_no = $subscription->investment_name;
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

                                            <td>
                                                <?php
                                                    if(!empty($subscription->commencement_date)){
                                                        
                                                        echo date('d M, Y', strtotime($subscription->commencement_date));
                                                    }else{
                                                        echo "-";
                                                    } 
                                                ?>
                                            </td>

                                            <?php
                                                $totalSumOfAdditional = \App\Subscription::where('user_id', $subscription->user_id)->where('investment_class_type', $subscription->investment_class_type)->where('is_first', 0)->where('status', 3)->sum('amount');
                                            ?>

                                            @if ($subscription->is_first)
                                                <td>{{ $totalSumOfAdditional }}</td>
                                            @else 
                                                <td>N/A</td>
                                            @endif

                                            <td>
                                                <?php
                                                    $latestCLassANavPrice = \App\Price::where('class_type', $subscription->investment_class_type)->where('active',1)->first();

                                                    $latest_price = $latestCLassANavPrice->latest_price;
                                                    $current_value = $subscription->no_of_share * $latest_price;

                                                    $current_value = $current_value - $subscription['PayoutAs']->sum('redemption_amount');

                                                    if(!empty($current_value)){
                                                        $current_value = floatvalue($current_value);
                                                        echo number_format($current_value, 2);
                                                    }else{
                                                        echo "0.00";
                                                    }
                                                ?>
                                            </td>

                                            <td>
                                                @if (!empty($subscription->investment_class_type))

                                                    @if ($subscription->investment_class_type == 1)
                                                        <span class="badge badge-success mt-2 mr-2 text-white">
                                                            {{ $subscription->InvestmentClassAs['name'] }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-info mt-2 mr-2">
                                                            {{ $subscription->InvestmentClassAs['name'] }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-danger mt-2 mr-2">Not Updated</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($subscription->is_first == 0)
                                                    <span class="badge badge-secondary mt-2 mr-2">ADDITIONAL</span>
                                                @else
                                                    <span class="badge badge-dark mt-2 mr-2">INITIAL</span>
                                                @endif
                                            </td>

                                            <td> 

                                                <?php
                                                    if($subscription->status == 0){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Draft</span>';
                                                    }else if($subscription->status == 1){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Pending</span>';
                                                    }else if($subscription->status == 2){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Pending Funding</span>';
                                                    }else if($subscription->status == 3){
                                                        echo '<span class="badge badge-soft-success mt-2 mr-2">Active</span>';
                                                    }else if($subscription->status == 4){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Deactive</span>';
                                                    }else if($subscription->status == 5){
                                                        echo '<span class="badge badge-soft-danger mt-2 mr-2">Rejected</span>';
                                                    }else if($subscription->status == 6){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2">Matured</span>';
                                                    }else if($subscription->status == 7){
                                                        echo '<span class="badge badge-soft-info mt-2 mr-2">Reinvestment</span>';
                                                    }else if($subscription->status == 8){
                                                        echo '<span class="badge badge-soft-info"> Payment Received</span>';
                                                    }else if($subscription->status == 9){
                                                        echo '<span class="badge badge-soft-info"> Fund Received</span>';
                                                    }else{
                                                        echo '<span class="badge badge-soft-info"> Draft</span>';
                                                    }                                                       
                                                ?> 
                                            </td>
                                            <td> 

                                                {{-- <button type="button" class="btn btn-success btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionView/'.$subscription->id) }}';">View</button>   

                                                <button type="button" class="btn btn-warning btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionEdit/'.$subscription->id) }}';">Edit</button> --}} 

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-soft-primary shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    @can('subscription-view')
                                                        <li class="dropdown-item"><a class="btn btn-success btn-sm mt-1 mr-1 text-white" href="{{ url('subscriptionView/'.$subscription->id) }}">Show</a>
                                                        </li>
                                                    @endcan

                                                    @can('subscription-edit')
                                                        <li class="dropdown-item"> <a class="btn btn-warning btn-sm mt-1 mr-1 text-white" href="{{ url('subscriptionEdit/'.$subscription->id) }}">Edit</a>
                                                        </li>
                                                    @endcan

                                                    @can('subscription-delete')
                                                        <li class="dropdown-item"><a class="deleteSubConfirmButton btn btn-danger btn-sm mt-1 mr-1 text-white" href="#" attr-subID="{{ $subscription->id }}">Delete</a>
                                                        </li>
                                                    @endcan
                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>

                                        @endif

                                        @endforeach

                                    @else

                                      <tr><td colspan=9 align="center">No Records Available..</td></tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>

                            {{-- {!! $subscriptions->links('pagination::bootstrap-4') !!}  --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.elements.footer')
    </div>
</div>

@endsection

<?php 
    
    function floatvalue($val){
            $val = str_replace(",",".",$val);
            $val = preg_replace('/\.(?=.*\.)/', '', $val);
            return floatval($val);
    }
?>

@section('scripts')

    {{-- <script type="text/javascript">
        $(function() {

          $('#class_type').multiselect({
            includeSelectAllOption: true
          });

          $('#btnget').click(function() {
            alert($('#class_type').val());
          });
        });
    </script> --}}

<script type="text/javascript">
    $(document).on("click",".deleteSubConfirmButton",function() {
            
        const subs_id = $(this).attr('attr-subID');
        Swal.fire({
            title: 'Are you sure?',
            text: "Please confirm do you want to delete the subscription!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                
                var csrfToken = "{{ csrf_token() }}";
                let formData = new FormData();
                formData.set('id', subs_id);
                axios.post(SITE_URL+'deleteSubscription',formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-Token': csrfToken}}
                ).then(function (response) {
                    Swal.fire('Great Job !','You Successfully Deleted the Subscription.','success');
                    setTimeout(location.reload.bind(location), 1500);
                });
            }
        });
    });
</script>

@stop

{{-- @if(!empty($user->getRoleNames()))
    @foreach($user->getRoleNames() as $v)
        <label class="badge badge-success">{{ $v }}</label>
    @endforeach
@endif --}}
