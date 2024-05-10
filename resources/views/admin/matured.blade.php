@extends('layouts.app')

@section('title', 'Matured')

@section('content')

<div class="container-fluid page-body-wrapper">

    @include("admin.elements.sidebar")

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Matured Investment</h4>
                                </div>
                            </div>

                            {{-- <form method="get" class="needs-validation mt-3" action="{{ url('/matured')}}">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group mb-3">
                                            <input type="text" name="q" placeholder="Search By Investment No" class="form-control search-input" value="" autocomplete="off"/>
                                            <div class="input-group-append">
                                                <button type="submit" id="searchSubmitId" class="btn btn-info"> 
                                                    <i data-feather="search"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}

                            <form method="get" class="needs-validation mt-3" action="{{ url('/matured') }}">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Search By Investment ID, Name, Amount </label>
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
                                            <th>AMOUNT</th>
                                            <th>COMMENCEMENT DATE</th>
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
                                                    <span class="badge badge-success mt-2 mr-2 text-white">ADDITIONAL</span>
                                                @else
                                                    <span class="badge badge-info mt-2 mr-2">INITIAL</span>
                                                @endif
                                            </td>

                                            <td> 
                                                <span class="badge badge-soft-warning mt-2 mr-2">Matured</span> 
                                            </td>

                                            {{-- <td>     
                                                <button type="button" class="btn btn-success btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionView/'.$subscription->id) }}';">View</button>   

                                                <button type="button" class="btn btn-warning btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionEdit/'.$subscription->id) }}';">Edit</button>  
                                            </td> --}}

                                            <td>
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
                                        @endforeach

                                    @else

                                      <tr><td colspan=8 align="center">No Records Available..</td></tr>
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

        @include('admin.elements.footer')
    </div>
</div>

@endsection

@section('scripts')

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