@extends('layouts.member.app')
@section('content')
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                @php
                    $total = 0;
                    $cart_ajax = Session::get('cart');
                @endphp
                @if ($cart_ajax == true)
                    <h1>Giỏ Hàng Của Bạn </h1>
                @else
                    <h1>Giỏ Hàng Của Bạn Hiện Đang Trống </h1>
                @endif
                <div class="col-lg-12" id="list-cart">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Product</th>
                                    <th>Price</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Save</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cart_ajax)
                                    @foreach ($cart_ajax as $key => $cart)
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img style="width: 150px;"
                                                    src="{{ asset($cart['product_image']) }}"
                                                    alt="">
                                                <h5>
                                                    <a
                                                        href="{{ route('product.detail', $cart['product_id']) }}">{{ $cart['product_name'] }}</a>
                                                </h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                ${{ $cart['product_price']}}
                                            </td>
                                            <td class="shoping__cart__price">
                                                {{ $cart['product_size'] }}
                                            </td>
                                            <td class="shoping__cart__price">
                                                {{ $cart['product_color'] }}
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input class="cart_quantity_{{ $cart['session_id'] ?? '' }}"
                                                            type="number" min="1" max="10"
                                                            value="{{ $cart['product_qty'] }}"
                                                            style="width: 55px;">
                                                        <input type="hidden"
                                                            class="cart_session_id_{{ $cart['session_id'] ?? '' }}"
                                                            value="{{ $cart['session_id'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                $total += $subtotal;
                                            @endphp
                                            <td class="shoping__cart__total">
                                                ${{ $total }}
                                            </td>
                                            <td class="shoping__cart__total">
                                                <input type="button" style="height: 40px;margin: 10px;"
                                                    data-session_id_cart="{{ $cart['session_id'] ?? '' }}" value="Update"
                                                    class="btn btn-success form-group update-to-cart" name="update-to-cart">
                                            </td>
                                            <td class="shoping__cart__total">
                                                <input type="button" style="height: 40px;margin: 10px;"
                                                    data-session_id_cart="{{ $cart['session_id'] ?? '' }}" value="Delete"
                                                    class="btn btn-success form-group delete-to-cart" name="delete-to-cart">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ url('/') }}" class="primary-btn cart-btn">CONTINUE SHOPPPING</a>
                        <a href="{{ route('update_cart_user') }}" class="primary-btn cart-btn cart-btn-right">
                            UPDATE CART
                        </a>
                        <a href="{{ route('delete_all_cart') }}" class="primary-btn cart-btn cart-btn-right">
                            Delete All
                        </a>
                    </div>
                </div>
                {{-- <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        @if (Session::has('Cart') != null)
                            <ul>
                                <li>Total product<span>{{ Session::get('Cart')->totalQuantity }}</span></li>
                                <li>Total <span>${{ Session::get('Cart')->totalPrice }}</span></li>
                            </ul>
                            <a href="#" class="primary-btn">CHECKOUT</a>
                        @endif
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $('.update-to-cart').click(function() {
            var id = $(this).data('session_id_cart');
            console.log(id);
            var cart_product_qty = $('.cart_quantity_' + id).val();
            console.log(cart_product_qty);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('update_cart_ajax') }}',
                method: 'POST',
                data: {
                    cart_product_id: id,
                    cart_product_qty: cart_product_qty,
                },

                success: function(data) {
                    window.location.reload()
                }

            });
        });

        $('.delete-to-cart').click(function() {
            var id = $(this).data('session_id_cart');
            console.log(id);
            var cart_product_qty = $('.cart_quantity_' + id).val();
            console.log(cart_product_qty);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('delete_cart_ajax') }}',
                method: 'POST',
                data: {
                    cart_product_id: id,
                    cart_product_qty: cart_product_qty,
                },

                success: function(data) {
                    window.location.reload()
                }

            });
        });
    </script>
@endpush
