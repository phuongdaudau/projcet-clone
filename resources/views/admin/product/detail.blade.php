@extends('layouts.admin.app')

@section('title','Sản Phẩm')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <style>
        .header{
            margin-top: 20px;
        }
        .body{
            margin-top: 10px;
        }
        .label{
            font-size: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header" style="margin-bottom: 20px;">
                            <h1>
                                {{$product->name}}
                                
                                </h1>
                                <small>Người tạo:  <strong><a href="">{{$product->admin->name }}</a></strong>
                                    vào {{ $product->created_at->toFormattedDateString()}}
                                </small>
                        </div>
                        <div class="body">
                            <div class="demo-masked-input">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <b>Price ($)</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <div class="form-line">
                                            <p class="form-control date">  {{number_format($product->price)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <b>Quantity</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">access_time</i>
                                            </span>
                                            <div class="form-line">
                                            <p class="form-control date">  {{$product->quantity}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Images
                            </h2>
                        </div>
                        <div class="body">
                            <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                @php
                                    $imgs = explode(",", $product->images);
                                    $images = array_slice($imgs,1,5);
                                @endphp
                                @foreach($images as $image)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <a href="{{$image}}" data-sub-html="Demo Description">
                                            <img class="img-responsive thumbnail" src="{{$image}}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-indigo">
                        <h2>
                            Description
                        </h2>
                    </div>
                    <div class="body">
                    {!! $product->description !!}
                    </div>
                </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-blue">
                        <h2>
                            Category
                        </h2>
                    </div>
                    <div class="body">
                        <span class="label bg-green">{{ $product->category->name }}</span>
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-blue">
                        <h2>
                            Colors
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($product->colors as $color)
                            <span class="label bg-green">{{ $color->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-blue">
                        <h2>
                            Sizes
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($product->sizes as $size)
                            <span class="label bg-green">{{ $size->name }}</span>
                        @endforeach
                    </div>
                </div>
                </div>
            </div> 
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