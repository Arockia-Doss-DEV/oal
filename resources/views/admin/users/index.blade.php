@extends('layouts.app')

@section('title', $title)

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
                                    <h4 class="card_title">{{ $title }}</h4>
                                </div>

                            @can('user-create')
                                <div class="col-md-2">
                                    <a class="btn btn-success text-white" href="{{ route('users.create') }}"><i class="fa fa-plus-circle"></i> Create New User</a>
                                </div>
                            @endcan
                            
                            </div>
                            
                            @if (\session('back') == 'index')
                                
                            <form method="get" class="needs-validation mt-2" action="{{ route('users.index') }}">

                            @elseif(\session('back') == 'investerDeactive')

                            <form method="get" class="needs-validation mt-2" action="{{ url('/deactive-invester') }}">

                            @else

                            <form method="get" class="needs-validation mt-2">

                            @endif

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

                                    {{-- <div class="col-md-4">
                                        <label>Class Type</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" name="class_type" >
                                                <option value="">Select</option>
                                                <option value="All">All</option>
                                                <option value="A">class A</option>
                                                <option value="">class B</option>
                                            </select>
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
                                    </div> --}}
                                    
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

                                    @if ($users->count() > 0)
                                            
                                        @foreach ($users as $key => $user)
                                        <tr>

                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>+{{ $user->mobile_prefix }} {{ $user->mobile_no }}</td>

                                            <?php 
                                                $role = $user->roles->pluck('name')->implode(',');
                                                $userRole = $role == "Invester" ? "Investor" : $role;
                                            ?>

                                            <td><span class="badge badge-soft-primary mt-2 mr-2">{{ $userRole }}</span></td>
                                            <td>
                                                @if($user["2fa_status"] == 1)
                                                    <span class="badge badge-soft-success mt-2 mr-2">Enable</span> 
                                                @else
                                                    <span class="badge badge-soft-danger mt-2 mr-2">Disable</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user["active"] == 1)
                                                    <span class="badge badge-soft-success mt-2 mr-2">Active</span>
                                                @else
                                                    <span class="badge badge-soft-danger mt-2 mr-2">De-active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-soft-primary shadow-none dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    @can('user-view')
                                                        <li class="dropdown-item"><a class="" href="{{ route('users.show',$user->id) }}">Show</a>
                                                        </li>
                                                    @endcan

                                                    @can('user-edit')
                                                        <li class="dropdown-item"> <a class="" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                                        </li>
                                                        <li class="dropdown-item"><a class="" href="{{ url('/userChangePassword',$user->id) }}">Change Password</a>
                                                        </li>

                                                        @if($user["2fa_status"] == 1)

                                                        <li class="dropdown-item"> <a class=" disable2FADataButton" href="#" attr-userID="{{ $user->id }}">Disable 2FA</a>
                                                        </li>

                                                        @else

                                                        <li class="dropdown-item"><a class="" href="{{ url('/enable2FaUser',$user->id) }}">Enable 2FA</a>
                                                        </li>

                                                        @endif
                                                        
                                                        @if($user["active"] == 1)

                                                        <li class="dropdown-item"> <a class="deactiveUserButton" href="#" attr-userID="{{ $user->id }}">De-active User</a>
                                                        </li>

                                                        @else

                                                        <li class="dropdown-item"> <a class="activeUserButton" href="#" attr-userID="{{ $user->id }}">Active User</a>
                                                        </li>

                                                        @endif

                                                    @endcan
                                                    </ul>
                                                </div>
                                            </td>

                                            {{-- <td> 
                                                <span class="badge badge-soft-warning mt-2 mr-2">Pending</span> 
                                            </td>
                                            <td>    
                            
                                                <button type="button" class="btn btn-success btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionView/'.$subscription->id) }}';">View</button>  

                                                <button type="button" class="btn btn-warning btn-sm mt-1 mr-1 text-white" onclick="location.href = '{{ url('subscriptionEdit/'.$subscription->id) }}';">Edit</button>  
                                            </td> --}}

                                        </tr>
                                        @endforeach

                                    @else

                                      <tr><td colspan=7 align="center">No Records Available..</td></tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            {!! $users->links('pagination::bootstrap-4') !!} 
                            
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
                    
                    var csrfToken = "{{ csrf_token() }}";
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
                    
                    var csrfToken = "{{ csrf_token() }}";
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
                    
                    var csrfToken = "{{ csrf_token() }}";
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
@stop