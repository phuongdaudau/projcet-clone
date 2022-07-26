@extends('layouts.member.app')

@section('title', 'List Products')
@push('css')
    <link rel="stylesheet"
        href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css" />
    <style>
        .circle-color {
            border-radius: 50%;
            border: 1px solid #e8e9eb;
            margin: 0 20px;
        }

        .product__details__pic__item img {
            height: 450px;
            width: 300px;
        }

        .owl-carousel {
            /* display: none; */
            width: 100%;
            z-index: 1;
            margin: 10px
        }
    </style>
@endpush

@section('content')
    <div id="grid">
        @php
            $images = explode(',', $product->images);
        @endphp
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img class="product__details__pic__item--large" src="{{ asset($images[1]) }}"
                                    alt="">
                            </div>
                            <div class="owl-carousel owl-theme">
                                @foreach ($images as $image)
                                    @if ($image != '')
                                        <div class="item">
                                            <img data-imgbigurl="{{ asset($image) }}" src="{{ asset($image) }}"
                                                alt="">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__text">
                            <h3>{{ $product->name }}</h3>
                            <div class="product__details__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                                <span>(18 reviews)</span>
                            </div>
                            <div class="product__details__price">${{ $product->price }}</div>
                            <p></p>
                            <form action="{{ url('/cart') }}" method="GET">
                                @csrf
                                <input name="product_id" value="{{ $product->id }}" hidden>
                                <ul>
                                    <li>
                                        <b>Color</b>
                                        <div class="form-group">
                                            <select name="color_id" id="color_id" class="filter-make filter form-control">
                                                <option value="">Select Color</option>
                                                @foreach ($product->colors as $color)
                                                    <option value="{{ $color->name }}" data-id="{{ $product->id }}"
                                                        {{ request()->get('color_id') == $color->name ? 'selected' : '' }}>
                                                        {{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <b>Size</b>
                                        <div class="form-group">
                                            <select name="size_id" id="size_id" class="filter-make filter form-control">
                                                <option value="">Select Size</option>
                                                @foreach ($product->sizes as $size)
                                                    <option value="{{ $size->name }}" data-id="{{ $product->id }}"
                                                        {{ request()->get('size_id') == $size->name ? 'selected' : '' }}>
                                                        {{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input id="quantity-item" data-id="{{ $product->id }}" name="quantity"
                                                type="text" value="1">
                                        </div>
                                    </div>
                                </div>
                                {{-- <button type="submit" class="btn btn-success form-group"
                                    style="height: 40px;margin: 10px;"> Add to card </button> --}}

                                <input type="hidden" value="{{ $product->id }}"
                                    class="cart_product_id_{{ $product->id }}">
                                <input type="hidden" value="" class="cart_product_size_{{ $product->id }}">
                                <input type="hidden" value="" class="cart_product_color_{{ $product->id }}">
                                <input type="hidden" value="1" class="cart_product_qty_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->name }}"
                                    class="cart_product_name_{{ $product->id }}">
                                <input type="hidden" value="{{ $images[1] }}"
                                    class="cart_product_image_{{ $product->id }}">
                                <input type="hidden" value="{{ $product->price }}"
                                    class="cart_product_price_{{ $product->id }}">
                                {{-- <input type="hidden" value="1" class="cart_product_price_{{$product->id}}"> --}}

                                <input type="button" style="height: 40px;margin: 10px;" value="Add to card"
                                    class="btn btn-success form-group add-to-cart" data-id_product="{{ $product->id }}"
                                    name="add-to-cart">
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                        aria-selected="true">Mô tả sản phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                        aria-selected="false">Nhận xét <span>(1)</span></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>{!! $product->description !!}</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script>
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })

        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_size = $('.cart_product_size_' + id).val();
                var cart_product_color = $('.cart_product_color_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('cart_ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_size: cart_product_size,
                        cart_product_color: cart_product_color,
                        cart_product_qty: cart_product_qty,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                    },

                    success: function(data) {
                        console.log(data)
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                            title: 'Add Succ',
                            text: "You won't be able to revert this!",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Đi đến giỏ hàng',
                            cancelButtonText: 'Xem Tiep',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ url('/show-cart-ajax') }}";
                            } else if (
                                result.dismiss === Swal.DismissReason.cancel
                            ) {}
                        })
                    }

                });
            });

            $('#size_id').on('change', function() {
                var sizeId = $(this).val();
                const selectedIndex = $(this)[0].selectedIndex;
                var idCategory = $(this).children('option').eq(selectedIndex).data('id');
                $(`.cart_product_size_${idCategory}`).val(sizeId);
                console.log(sizeId);
                console.log($(`.cart_product_size_${idCategory}`).val());
            });

            $('#color_id').on('change', function() {
                var colorId = $(this).val();
                const selectedIndex = $(this)[0].selectedIndex;
                var idCategory = $(this).children('option').eq(selectedIndex).data('id');
                $(`.cart_product_color_${idCategory}`).val(colorId);
                console.log(colorId);
                console.log($(`.cart_product_color_${idCategory}`).val());
            });

            $('#quantity-item').on('keyup', function() {
                console.log($(this).data('id'));
                var qty = $(this).val();
                var idCategory = $(this).data('id');
                $(`.cart_product_qty_${idCategory}`).val(qty);
                console.log($(`.cart_product_qty_${idCategory}`).val())
            })
        });
    </script>
@endpush
