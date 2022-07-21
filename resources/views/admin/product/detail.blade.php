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
        .body {
            margin-top: 10px;
            background: white;
            border: 1px solid #463f41;
            padding: 10px;
            box-shadow: 5px 4px 0px 0px #888888;
        }
        p.form-control.date {
            min-height: 42px;
            padding: 10px;
        }
        .text-title{
            font-weight: bolder;
            color: black;
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
                            <p> Name Product:</p>
                            <h1 class="text-title">
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
                                    $images = explode(",", $product->images);
                                @endphp
                                @foreach($images as $image)
                                    @if ($image != '')
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{ asset($image) }}" target="_blank" >
                                                <img class="img-responsive thumbnail" src="{{ asset($image) }}">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
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
                            {{-- <textarea id="tinymce" name="description" readonly>
                                {{$product->description}}
                            </textarea> --}}
                            {!! $product->description !!}

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Category
                        </h2>
                    </div>
                    <div class="body">
                        <span class="label bg-green">{{ $product->category->name }}</span>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
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
                    <div class="header">
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
            <a style="margin-top: 30px;" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.product.edit', $product->id) }}">Edit</a>
            <button style="margin-top: 30px;"  class= "btn btn-danger waves-effect" type="button" onclick="deleteproduct({{ $product->id }})">
                    Delete
            </button>
            <form id="delete-form-{{ $product->id }}" action=" {{ route('admin.product.destroy', $product->id)}}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
            </form>
    </div>
@endsection

@push('scripts')
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('assets/plugins/tinymce/tinymce.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        function deleteproduct(id){
            console.log(1);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  event.preventDefault();
                  document.getElementById('delete-form-'+id).submit();
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                  )
                }
              })
        }

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