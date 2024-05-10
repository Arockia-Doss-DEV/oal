@extends('layouts.app')

@section('title', 'Subscriptions')

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
                                <div class="col-md-6">
                                    <h4 class="card_title">Investment Details</h4>
                                </div>
                                <div class="col-md-6 text-right">

                                    {{-- <?php if($check_investment == 1){ ?>
                                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ url('/investor/subscriptionCreate') }}';">Create Investment</button> 
                                    <?php }else{ ?>
                                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ url('/investor/subscriptionAdditionCreate') }}';"> Create Additional Investment </button>
                                    <?php } ?> --}}

                                    {{--  /////////////////////////////////// --}}


                                    {{-- @if ($check_investment == 1)
                                        
                                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createNewSubscription', ['classId' => $check_investment_class->investment_class_type]) }}';">Create Investment</button> 

                                    @elseif($check_investment == 0)

                                        <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createAdditionalSubscription', ['classId' => $check_investment_class->investment_class_type]) }}';"> Create Additional Investment </button> 
                                        
                                    @else

                                    @endif --}}


                                   {{--  /////////////////////////////////// --}}

                                   <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createNewSubscription', ['classId' => $check_investment_class->investment_class_type, 'isInitial' => 1]) }}';">Create Initial Investment</button> 

                                   <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createAdditionalSubscription', ['classId' => $check_investment_class->investment_class_type, 'isAdditional' => 1]) }}';"> Create Additional Investment</button> 


                                   {{--  /////////////////////////////////// --}}

                                    {{-- @if ($current_investment_class['is_first'] == 1)
                                        
                                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createNewSubscription', ['classId' => $current_investment_class['class_type'], 'isFirst' => $current_investment_class['is_first'], 'isInitial' => 1]) }}';">Create New Class</button>

                                    @elseif($current_investment_class['is_first'] == 0)
                                     
                                    <button type="button" class="btn btn-primary mt-1 mr-1 text-white" onclick="location.href = '{{ route('createAdditionalSubscription', ['classId' => $current_investment_class['class_type'], 'isFirst' => $current_investment_class['is_first'], 'isAdditional' => 1]) }}';"> Create Additional Class</button>                                    
                                    @endif --}}

                                </div>
                            </div>

                            <form method="get" class="needs-validation mt-3" action="{{ url("/investor/subscriptions") }}">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Search By Investment No </label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" placeholder="Search" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-info"> 
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
                                            <th>SUBMISSION DATE</th>
                                            <th>INVESTMENT CLASS</th>
                                            <th>INVESTMENT TYPE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @if ($subscriptions->count() > 0)
                                        
                                        @foreach($subscriptions as $subscription)

                                        @if (($subscription->is_first == 1) || ($subscription->status == 0) || ($subscription->status != 3))

                                        <tr>
                                            <td class="font-weight-bold">
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
                                                <?php
                                                    if(!empty($subscription->created_at)){
                                                        echo date('d M, Y', strtotime($subscription->created_at));
                                                    }else{
                                                        echo "-";
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
                                                    if($subscription->status == 1){
                                                        echo '<span class="badge badge-soft-warning"> Pending</span>';
                                                    }else if($subscription->status == 2){
                                                        echo '<span class="badge badge-soft-primary"> Pending Funding</span>';
                                                    }else if($subscription->status == 3){
                                                        echo '<span class="badge badge-soft-success">Active</span>';
                                                    }else if($subscription->status == 4){
                                                        echo '<span class="badge badge-soft-danger">Deactive</span>';
                                                    }else if($subscription->status == 5){
                                                        echo '<span class="badge badge-soft-danger"> Rejected</span>';
                                                    }else if($subscription->status == 6){
                                                        echo '<span class="badge badge-soft-info"> Matured</span>';
                                                    }else if($subscription->status == 7){
                                                        echo '<span class="badge badge-soft-success"> Reinvestment</span>';
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
                                                <button type="button" class="btn btn-success btn-sm text-white mt-1" onclick="location.href = '{{ url('/investor/subscriptionView/'.$subscription->id) }}';">View </button>   

                                                <?php if($subscription->status == 0){ ?>
                                                    <button type="button" class="btn btn-warning btn-sm text-white mt-1" onclick="location.href = '{{ route('investorSubscriptionEdit', ['subId' => $subscription->id, 'classId' => $subscription->investment_class_type]) }}';">Edit </button>
                                                <?php } ?>

                                                {{-- @if ($subscription->status == 0)
                                                    @if ($subscription->is_first == 0)
                                                        <button type="button" class="btn btn-warning btn-sm text-white mt-1" onclick="location.href = '{{ route('investorSubscriptionAdditionEdit', ['subId' => $subscription->id, 'classId' => $subscription->investment_class_type]) }}';">Edit </button>
                                                    @else
                                                        <button type="button" class="btn btn-warning btn-sm text-white mt-1" onclick="location.href = '{{ route('investorSubscriptionEdit', ['subId' => $subscription->id, 'classId' => $subscription->investment_class_type]) }}';">Edit </button>
                                                    @endif
                                                @endif --}}

                                                {{-- <button type="button" class="btn btn-warning btn-sm text-white mt-1" onclick="location.href = '{{ url('/investor/subscriptionEdit/'.$subscription->id) }}';">Edit</button> --}}

                                                {{-- <?php if($subscription->status == 0){ ?>
                                                        <button type="button" class="btn btn-warning btn-sm text-white mt-1" onclick="location.href = '{{ url('/investor/subscriptionEdit/'.$subscription->id) }}';">Edit</button>
                                                <?php } ?> --}}
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
                            {!! $subscriptions->links('pagination::bootstrap-4') !!} 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('investor.elements.footer')
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

@stop
