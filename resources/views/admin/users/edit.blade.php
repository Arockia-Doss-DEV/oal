@extends('layouts.app')

@section('title', 'Update Investor')

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
                                    <h4 class="card_title">Update Investor</h4>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-secondary" href="#" onclick="location.href = document.referrer; return false;" style="float: right"><i class="fa fa-angle-double-left"></i> Back</a>
                                </div>
                            </div>
                        </div>


                        {!! Form::model($user, array('route' => ['users.update', $user->id], 'method'=>'PATCH', 'files' => true, 'id' => 'user-form', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" )) !!}
                        <div class="card-body">


                            <div class="row col-md-12">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Salutation</label>
                                        <?php $salutationOption = ['Mr.'=> 'Mr','Mrs.'=> 'Mrs','Ms.'=> 'Ms','Dr.'=> 'Dr','Prof.'=> 'Prof','Assoc. Prof.'=> 'Assoc. Prof','Dato.'=> 'Dato',"Dato Sri."=>"Dato Sri","Datin."=>"Datin","Datuk."=>"Datuk", "Datuk Sri."=>"Datuk Sri","Haji."=>"Haji","Hajjah."=>"Hajjah","Puteri."=>"Puteri","Puan Sri."=>"Puan Sri","Raja."=>"Raja","Tan Sri."=>"Tan Sri","Tengku."=>"Tengku","Tun."=>"Tun","Tun Poh."=>"Tun Poh", 'Tunku.'=>'Tunku']; ?>
                                        {!! Form::select('salutation', $salutationOption, old('salutation') ? old('salutation') : "", ['class' => 'form-control', 'id' => 'salutation']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="date">Name</label>

                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ? $user->name : old('name') }}" required  oninput="this.value = this.value.toUpperCase()" autofocus placeholder="Name">

                                        {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="date">Email</label>

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ? $user->email : old('email') }}" placeholder="Email" required data-parsley-group="block1" data-parsley-checkemail data-parsley-checkemail-message="Email Address already Exists" data-parsley-trigger="focusout" readonly>

                                        {{-- {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'readonly')) !!} --}}

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="ip">Country Code</label>

                                        <select class="form-control" name="mobile_prefix" id="mobile_prefix" data-parsley-type="digits" required>
                                            @foreach ($phone_prefix as $key => $data)
                                                <option {{ $user->mobile_prefix == $data['code'] ? 'selected' : '' }} value="{{$data['code']}}">{{$data['country']}}</option>
                                            @endforeach
                                        </select>

                                        {{-- {!! Form::select('mobile_prefix', $phone_prefix, old('mobile_prefix'), ['class' => 'form-control', 'id'=>'mobile_prefix', "data-parsley-type"=>"digits", 'required' =>'required']) !!} --}}
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="ip">Phone Number</label>
                                        {!! Form::text('mobile_no', null, array('class' => 'form-control', 'data-parsley-type'=>"digits", 'required'=>'required')) !!}

                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="time">Address Line 1</label>
                                        {!! Form::text('address_line1', $user->address_line1 ? $user->address_line1 : old('address_line1'), array('class' => 'form-control', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="time">Address Line 2</label>
                                        {!! Form::text('address_line2', $user->address_line2 ? $user->address_line2 : old('address_line2'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="datetime">City</label>
                                        {!! Form::text('city', $user->city ? $user->city : old('city'), array('class' => 'form-control', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Country</label>
                                        {!! Form::select('country', $countries, null, ['class' => 'form-control', 'id'=>'country_id']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="credit-card">Post Code</label>
                                        {!! Form::text('post_code', $user->post_code ? $user->post_code : old('post_code'), array('class' => 'form-control', 'required'=>'required')) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">State</label>
                                        <select class="form-control" name="state" id="state_id">
                                            <option value="">--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row col-md-12 mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group float-sm-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        {!! Form::close() !!}

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

        
        $('#country_id').change(function(){
            $.ajax({
                url: SITE_URL+'selectBoxStateList?country_id='+$(this).val(),
                type:"GET",
                success: function(data) {
                    var state = data.data;
                    $('#state_id').empty();
                    for (var key in state) {
                        if (state.hasOwnProperty(key)) {
                            $('#state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
                        }
                    }
                }
            });
        });

        var country_id = $('#country_id').val();
        if(country_id){
            $.ajax({
                url: SITE_URL+'selectBoxStateList?country_id='+country_id,
                type:"GET",
                success: function(data) {
                    var default_state = "{{ $user->state }}";

                    var state = data.data;
                    $('#state_id').empty();
                    for (var key in state) {
                        if (state.hasOwnProperty(key)) {
                            $('#state_id').append('<option value="'+key+'" >'+state[key]+'</option>');
                        }
                    }

                    $('#state_id').val(default_state);
                }
            });
        }
     </script>
@stop