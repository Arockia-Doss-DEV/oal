@extends('layouts.app')

@section('title', 'Reinvestment Request')

@section('content')

<div class="main-container">
    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <div class="main-panel">
            <!-- content-wrapper Starts -->
            <div class="content-wrapper">
                <!-- design1 -->
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Reinvestment Request</h4>
                                </div>
                            </div>

                            <form method="get" class="needs-validation mt-3" action="{{ url("/reinvestment")}}">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h6 class="panel-title text-semibold">Search By Investment No</h6>
                                        <input type="text" name="q" autocomplete="off" placeholder="Search ..." class="form-control" value="">
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        <h6 class="panel-title text-semibold">&nbsp;</h6>
                                        <div class="submit">
                                            <input type="submit" id="searchSubmitId" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="single-table">
                                <div class="table-responsive datatable-primary">
                                    <table id="dataTable2" class="table table-hover progress-table ">
                                        <thead class="text-uppercase">
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
                                                <td>{{$subscription->investment_name}}</td>
                                                <td>{{$subscription->amount}}</td>
                                                <td>{{ $subscription->commencement_date ? date('d-M-y', strtotime($subscription->commencement_date))  : '' }}</td>
                                                <td>{{ $subscription->created_at ? $subscription->created_at->format('d-M-Y')  : '' }}</td>
                                                <td> <span class="badge badge-danger mt-2 mr-2">Active</span> </td>

                                                {{-- <td>     
                                                    <button type="button" class="btn btn-success mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionView/'.$subscription->id) }}';">View</button> 

                                                    <button type="button" class="btn btn-warning mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionEdit/'.$subscription->id) }}';">Edit</button>    
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
                                        </tbody>
                                    </table>
                                </div>

                                {{ $subscriptions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.elements.footer')
        </div>
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






