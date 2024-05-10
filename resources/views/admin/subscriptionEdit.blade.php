@extends('layouts.app')

@section('title', 'Subscription Update')

@section('content')
<script src="{{ asset('common/js/jSignature.min.js') }}"></script>

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
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-secondary" href="#" onclick="location.href = document.referrer; return false;" style="float: right"><i class="fa fa-angle-double-left"></i> Back</a>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <div class="card card-margin">
                                        <div class="card-header signup-card-header">
                                            <h5 class="card-title"> SUBSCRIPTION FORM UPDATE</h5>                                 
                                        </div>
                                        <div class="card-body">
                                             {!! Form::open(['url' => '/subscriptionEditSave', 'files' => true, 'id' => 'subscriptionform', 'data-parsley-validate' => 'data-parsley-validate', "data-parsley-trigger"=>"keyup", 'autocomplete'=>"off" ]) !!}
                                                
                                                {!! Form::hidden('subId', $subscription['id']) !!}
                                                <input type="hidden" name="subscriptionId" id="subscriptionId" value="{{ $subscription['id'] }}">
                                                
                                                @if(!empty($userData))
                                                    <input type="hidden" name="user_id" id="user_id" value="{{ $userData['id'] }}">
                                                @endif

                                                <div>
                                                    <h3>SUBSCRIBER DETAILS</h3>
                                                    <section>
                                                        <h4>SUBSCRIBER DETAILS</h4>
                                                        <div class="row">
                                                                @include("admin.elements.editSubscription.editSubscription")
                                                        </div>
                                                    </section>

                                                    <h3>ADDITIONAL DETAILS</h3>
                                                    <section>
                                                        <h4>LEAD CONTACT DETAILS</h4>

                                                        @include("admin.elements.editSubscription.editAdditional")
                                                    </section>

                                                    <h3>DOCUMENTS</h3>
                                                    <section>
                                                        {{-- <h4>CHECKLIST FOR SUBSCRIBERS</h4> --}}

                                                        <h4>CERTIFIED SUPPORTING DOCUMENTS</h4>
                                                        @include("admin.elements.editSubscription.editDocument")
                                                    </section>

                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
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

@include('admin.elements.editSubscriptionScript')