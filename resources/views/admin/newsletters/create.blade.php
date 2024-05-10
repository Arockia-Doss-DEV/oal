@extends('layouts.app')

@section('title', 'Create Newsletter')

@section('styles')
    <style type="text/css">
        .ck-editor__editable {
          min-height: 350px;
        }
    </style>
@stop

@section('content')

    <div class="container-fluid">
        
        @include("admin.elements.sidebar")

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header-container">
                    <div class="page-header-main">
                        <div class="page-title">Newsletter</div>
                         <div class="header-breadcrumb">
                            <a href="#"><i data-feather="airplay"></i> Create</a>
                        </div>
                    </div>

                    <div class="page-header-action">
                        <a href="{{ route('newsletters.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 card-margin">
                        <div class="card ">
                            
                            <div class="card-body">

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif

                                <form action="{{ route('newsletters.store') }}" method="POST" enctype='multipart/form-data' data-parsley-validate="">

                                	@csrf
                                     <div class="row">
                            		    <div class="col-xs-12 col-sm-12 col-md-12">
                            		        <div class="form-group">
                            		            <strong>Name:</strong>
                            		            <input type="text" name="title" class="form-control" placeholder="Name" required="required" value="{{ old('title') }}">
                            		        </div>
                            		    </div>
                            		    <div class="col-xs-12 col-sm-12 col-md-12">
                            		        <div class="form-group">
                            		            <strong>Detail:</strong>

                                                <textarea class="form-control ckeditor" style="height:150px" name="detail" placeholder="Detail" id="summary-ckeditor">{{ old('detail') }}</textarea>

                            		            {{-- <textarea class="form-control ckeditor" style="height:150px" name="detail" placeholder="Detail" required="required" id="summary-ckeditor" data-parsley-errors-container="#detail-validation-error-block">{{ old('detail') }}</textarea> --}}

                                                {{-- <div id="detail-validation-error-block"></div> --}}

                                                @if($errors->has('detail'))
                                                    <div class="text-danger">{{ $errors->first('detail') }}</div>
                                                @endif
                            		        </div>
                            		    </div>

                                       <!--  <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Slug:</strong>
                                                <input type="text" name="slug" class="form-control" placeholder="Ex: offer-for-new-user" required="required" value="{{ old('slug') }}">

                                                @if ($errors->has('slug'))
                                                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                                                @endif
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <strong>Image:</strong>
                                            <input type="file" name="image" class="file-input" data-parsley-max-file-size="5024" accept=".jpeg,.png,.jpg">

                                            @if ($errors->has('image'))
                                                <br>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                        <br>
                                            <div class="form-group">
                                                <strong>Active:</strong>
                                                <input name="active" type="checkbox" value="1">
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

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    {{-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script> --}}
    
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

    {{-- <script>
        CKEDITOR.replace('summary-ckeditor', {
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script> --}} 

    <script type="text/javascript">
        $(document).ready(function () {

            ClassicEditor
            .create(document.querySelector( '#summary-ckeditor'),{
                ckfinder: {
                    uploadUrl: '{{route('ckeditor.image-upload').'?_token='.csrf_token()}}',
                }
            })
            .catch( error => {
                console.error( error );
            });
        });
    </script> 
    
    {{-- <script type="text/javascript">
        $(document).ready(function () {

            CKEDITOR.replace('ckeditor');
            CKEDITOR.config = {
                autoUpdateElement: true,
            }

            CKEDITOR.on('instanceReady', function(){
                $.each( CKEDITOR.instances, function(instance) {
                    CKEDITOR.instances[instance].on("change", function(e) {
                        for ( instance in CKEDITOR.instances )
                        CKEDITOR.instances[instance].updateElement();
                    });
                });
            });

            $('form textarea').attr('required', '');


            window.Parsley.addValidator('maxFileSize', {
                validateString: function(_value, maxSize, parsleyInstance) {
                    if (!window.FormData) {
                        alert('You are making all developpers in the world cringe. Upgrade your browser!');
                        return true;
                    }
                    var files = parsleyInstance.$element[0].files;
                    return files.length != 1  || files[0].size <= maxSize * 1024;
                },
                requirementType: 'integer',
                messages: {
                    en: 'This file should not be larger than %s Kb',
                    fr: 'Ce fichier est plus grand que %s Kb.'
                }
            });

            
        });
    </script> --}}

@endsection