@extends('layouts.app')


@section('content')
    
    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Track records update</div>
                    </div>
                    <div class="page-header-action">
                        <a href="{{ route('trackrecords.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            <div class="card-body">

                                <form action="{{ route('trackrecords.update',$record->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <strong>Period :</strong>
                                                <input type="text" name="period" value="{{ $record->period }}" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <strong>Quarterly Returns (%) :</strong>
                                                <input type="text" name="returns" value="{{ $record->returns }}" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
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

