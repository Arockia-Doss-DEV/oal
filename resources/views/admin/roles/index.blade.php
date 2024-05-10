
@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Role Management</div>
                        <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Index</a>
                        </div>
                    </div>

                    {{-- @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif --}}

                    @can('role-create')
                    <div class="page-header-action">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}"> Create New Role</a>
                    </div>
                    @endcan
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table center-aligned-table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Guard Name</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->guard_name }}</td>
                                                <td>{{ $role->created_at }}</td>

                                                
                                                <td class="action">

                                                    <a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}">Show</a>
                                                    @can('role-edit')
                                                        <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                                    @endcan
                                                    @can('role-delete')
                                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan

                                                    {{-- <form class="formPermission" action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                                                        
                                                        @can('permission-edit')
                                                        <a class="btn btn-primary btn-sm" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                                                        @endcan

                                                    
                                                        @csrf
                                                        @method('DELETE')
                                                        @can('permission-delete')
                                                            <button type="button" class="btn btn-danger btn-sm delete-confirm">Delete</button>
                                                        @endcan
                                                    </form> --}}

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {!! $roles->render() !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            var _this = this;
            swal({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    $(_this).closest("form").submit();
                }
            });
        });
    </script>
@endsection