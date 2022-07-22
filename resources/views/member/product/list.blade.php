@extends('layouts.member.app')

@section('title', 'List Products')
@push('css')
    <style>
        .circle-color {
            border-radius: 50%;
            border: 1px solid #e8e9eb;
        }

        .pagination {
            margin: 50px 30px;
            float: right;
        }

        .set-width {
            width: 315px !important;
            height: 300px;
        }

        span a {
            color: #6c757d;
            text-decoration: none;
        }

        .form-group select {
            width: 200px;
            margin: 10px 10px;
        }

        .make3D.animate .stats-container {
            top: 200px
        }
        .add-to-cart{
            color: white;
            background-color: unset;
        }
    </style>
@endpush

@section('content')
    <form action="{{ url('/') }}" method="GET">
        <div class="row" id="filter">
            <div class="form-group">
                <select data-filter="make" name="category_id" id="select-category" class="filter-make filter form-control">
                    <option value="">Select Category</option>
                    <option value="0">Show All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select data-filter="model" class="filter-model filter form-control">
                    <option value="">Select Price Range</option>
                    <option value="">Show All</option>
                </select>
            </div>
            <div class="form-group">
                <select name="recorder" id="select-page" class="filter-price filter form-control">
                    <option @if (request()->get('recorder') == 6) selected @endif value="6">6</option>
                    <option @if (request()->get('recorder') == 12) selected @endif value="12">12</option>
                    <option @if (request()->get('recorder') == 30) selected @endif value="30">30</option>
                    <option @if (request()->get('recorder') == 50) selected @endif value="50">50</option>
                </select>
            </div>
            {{-- <button type="submit" class="btn btn-success form-group" style="height: 40px;
    margin: 10px;"> Filter </button> --}}
        </div>
    </form>
    <div id="grid">

        @foreach ($products as $item)
            @php
                $listSize = '';
                $images = explode(',', $item->images);
                foreach ($item->sizes as $size) {
                    $listSize = $listSize . ',' . $size->name;
                }
            @endphp
            <div class="product">
                <div class="make3D">
                    <div class="product-front">
                        <div class="shadow"></div>
                        <img src="{{ asset($images[1]) }}" alt="" />
                        <div class="image_overlay"></div>
                        <input style="" 
                            value="Add to card"
                            class="add_to_cart add-to-cart" data-id_product="{{ $item->id }}"
                            name="add-to-cart">

                        <div class="view_gallery">View gallery</div>
                        <div class="stats">
                            <div class="stats-container set-width">
                                <span class="product_price">${{ $item->price }}</span>
                                <span class="product_name"><a
                                        href="{{ route('product.detail', $item->slug) }}">{{ $item->name }}</a></span>
                                <p>{{ $item->category->name }}</p>
                                <div class="product-options">
                                    <strong>SIZES</strong>
                                    <span>
                                        <select name="size_id" id="size_id" class="filter-make filter form-control">
                                            <option value="">Select Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->name }}" data-id="{{ $item->id }}"
                                                    {{ request()->get('size_id') == $size->name ? 'selected' : '' }}>
                                                    {{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <strong>COLORS</strong>
                                    <span>
                                        <select name="color_id" id="color_id" class="filter-make filter form-control">
                                            <option value="">Select Size</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->name }}" data-id="{{ $item->id }}"
                                                    {{ request()->get('color_id') == $color->name ? 'selected' : '' }}>
                                                    {{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-back">
                        <div class="shadow"></div>
                        <div class="carousel">
                            <ul class="carousel-container">
                                @foreach ($images as $image)
                                    <li><img src="{{ asset($image) }}" alt="" /></li>
                                @endforeach
                            </ul>
                            <div class="arrows-perspective">
                                <div class="carouselPrev">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                                <div class="carouselNext">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flip-back">
                            <div class="cy"></div>
                            <div class="cx"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="{{ $item->id }}" class="cart_product_id_{{ $item->id }}">
                <input type="hidden" value="" class="cart_product_size_{{ $item->id }}">
                <input type="hidden" value="" class="cart_product_color_{{ $item->id }}">
                <input type="hidden" value="1" class="cart_product_qty_{{ $item->id }}">
                <input type="hidden" value="{{ $item->name }}" class="cart_product_name_{{ $item->id }}">
                <input type="hidden" value="{{ $images[1] }}" class="cart_product_image_{{ $item->id }}">
                <input type="hidden" value="{{ $item->price }}" class="cart_product_price_{{ $item->id }}">

            </div>
        @endforeach
        <div class="row">
            {{ $products->links('vendor.pagination.bootstrap-4', ['paginator' => $products]) }}
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('#select-page').on('change', function() {
                var url = $(this).val();
                if (url) {
                    console.log(url)
                    window.location = `?recorder=${url}`;
                }
                return false;
            });

            $('#select-category').on('change', function() {
                var url = $(this).val();
                if (url) {
                    console.log(url)
                    window.location = `?category=${url}`;
                }
                return false;
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

        })
    </script>
@endpush
