@extends('layouts.admin.app')

@section('title','Sản Phẩm')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <style>

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Add new product
                            </h2>
                        </div>
                        <div class="body">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Name</label>
                                    <input type="text" id="name" class="form-control" name="name">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Price</label>
                                    <input type="text" id="price" class="form-control" name="price">
                                </div>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Quanity</label>
                                    <input type="text" id="quantity" class="form-control" name="quantity">
                                </div>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="images">Images</label>
                                <input type="file" name="images[]" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('category') ? 'focused error' : '' }}">
                                    <label for="category">Select Category</label>
                                    <select name="category" id="category" class="form-control show-tick">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                    <label for="size">Select Colors</label>
                                <div class="form-line {{ $errors->has('colors') ? 'focused error' : '' }}" style="display:flex;">
                                    @foreach($colors as $color)
                                        <div class="form-check" style="margin-right:50px">
                                            <input type="checkbox" class="form-check-input" id="size" name="colors[]" value="{{ $color->id }}" style="margin-right: 10px;">{{ $color->name }}
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group form-float">
                                    <label for="size">Select Sizes</label>
                                <div class="form-line {{ $errors->has('sizes') ? 'focused error' : '' }}" style="display:flex;">
                                    @foreach($sizes as $size)
                                        <div class="form-check" style="margin-right:50px">
                                            <input type="checkbox" class="form-check-input" id="size" name="sizes[]" value="{{ $size->id }}" style="margin-right: 10px;">{{ $size->name }}
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Description
                            </h2>
                        </div>
                        <div class="body">
                            <textarea id="tinymce" name="description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <a  class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.product.index') }}">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('assets/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/plugins/tinymce') }}';
        });
    </script>

@endpush