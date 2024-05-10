@extends('layouts.app')

@section('title', 'Create Admin')

@section('content')
    

    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Permission</div>
                         <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Create</a>
                        </div>
                    </div>
                    <div class="page-header-action">
                        <a href="{{ url('/system/admins') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                @if ($errors->any())
                                     @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            <p>{{ $error }}</p>
                                        </div>
                                     @endforeach
                                 @endif

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif

                                <form action="{{ route('admin.store') }}" method="POST" enctype='multipart/form-data' data-parsley-validate="">
                                	@csrf
                                    <div class="row col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Salutation</label>
                                                <?php 
                                                
                                                $salutationOption = ['Mr.'=> 'Mr','Mrs.'=> 'Mrs','Ms.'=> 'Ms','Dr.'=> 'Dr','Prof.'=> 'Prof','Assoc. Prof.'=> 'Assoc. Prof','Dato.'=> 'Dato',"Dato Sri."=>"Dato Sri","Datin."=>"Datin","Datuk."=>"Datuk", "Datuk Sri."=>"Datuk Sri","Haji."=>"Haji","Hajjah."=>"Hajjah","Puteri."=>"Puteri","Puan Sri."=>"Puan Sri","Raja."=>"Raja","Tan Sri."=>"Tan Sri","Tengku."=>"Tengku","Tun."=>"Tun","Tun Poh."=>"Tun Poh", 'Tunku.'=>'Tunku']; ?>
                                                {!! Form::select('salutation', $salutationOption, old('salutation') ? old('salutation') : "", ['class' => 'form-control', 'id' => 'salutation', 'data-parsley-group'=>"block1"]) !!}
                                            </div>
                                        </div>

                            		    <div class="col-md-4">
                            		        <div class="form-group">
                            		            <strong>Username *</strong>
                            		            <input type="text" name="username" class="form-control" placeholder="Username" required="required" value="{{ old('username') }}">
                            		        </div>
                            		    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Email *</strong>
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required" value="{{ old('email') }}">
                                            </div>
                                        </div>

                            		</div>

                                    <div class="row col-md-12">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="ip">Country Code *</label>

                                                <select class="form-control" name="mobile_prefix" id="mobile_prefix" data-parsley-group = "block1" data-parsley-type="digits" data-live-search="false" required>
                                                    @foreach ($phone_prefix as $key => $data)
                                                        <option value="{{$data['code']}}">{{$data['country']}}</option>
                                                    @endforeach
                                                </select>

                                                {{-- {!! Form::select('mobile_prefix', $phone_prefix, old('mobile_prefix'), ['class' => 'form-control', 'id'=>'mobile_prefix', "data-parsley-type"=>"digits", 'required' =>'required', 'data-parsley-group'=>"block1",'data-live-search'=>"false"]) !!} --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="ip">Phone Number *</label>
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Phone Number" data-parsley-type="digits" value="{{ old('mobile_no') }}" required data-parsley-group="block1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Password *</strong>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Confirm Password </strong>
                                                <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required="required">
                                            </div>
                                        </div>

                                    </div>

                                    {{-- <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Role:</strong>
                                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>User Role *</strong>
                                                <select name="role_id" class="form-control" required>
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('role_id'))
                                                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>User Status *</strong>
                                                <select name="active" class="form-control" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>

                                                @if ($errors->has('active'))
                                                    <span class="text-danger">{{ $errors->first('active') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                        		    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                        		          <button type="submit" class="btn btn-primary">Submit</button>
                        		    </div>
                            	
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
