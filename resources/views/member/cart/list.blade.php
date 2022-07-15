@extends('layouts.member.app')

@section('title','Cart')
@push('css')
<style>

</style>
@endpush

@section('content')
<section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" id="list-cart">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Save</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(Session::has('Cart') !=null)
                                @foreach(Session::get('Cart')->products as $item)
                                @php 
                                    $images = explode(",", $item['productInfo']->images);
                                @endphp
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img style="width: 150px;" src="{{ $images[0] }}" alt="">
                                            <h5><a href="{{route('product.detail', $item['productInfo']->slug)}}">{{$item['productInfo']->name }}</a></h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                        ${{ $item['productInfo']->price}}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input id="quantity-item-{{$item['productInfo']->id}}" type="text" value="{{$item['quantity']}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                        ${{ $item['price'] }}
                                        </td>
                                        <td class="shoping__cart__total">
                                            <span class="save" id="{{$item['productInfo']->id}}" >Save</span>
                                        </td>
                                        <td class="shoping__cart__total">
                                            <span class="delete" id="{{$item['productInfo']->id}}" >Delete</sp>
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
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        UPDATE CART</a>
                    </div>
                </div>
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        @if(Session::has('Cart') !=null)
                        <ul>
                            <li>Total product<span>{{Session::get('Cart')->totalQuantity}}</span></li>
                            <li>Total <span>${{Session::get('Cart')->totalPrice}}</span></li>
                        </ul>
                        <a href="#" class="primary-btn">CHECKOUT</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $(".save").click(function() {
            var id= this.id;
            $.ajax({
                url: 'saveQtyItemCart/' + id + '/' + $("#quantity-item-" + id).val(),
                type: 'GET',
            }).done(function (respone) {
                renderListCart(respone);
                alertify.success('Đã cập nhật sản phẩm!');
            });
        });
        $(".delete").click(function() {
            var id= this.id;
            $.ajax({
                url: 'deleteListCart/' + id,
                type: 'GET',
            }).done(function (respone) {
                renderListCart(respone);
                alertify.success('Đã cập nhật sản phẩm!');
            });
        });

        function renderListCart(respone) {
            $("#list-cart").empty();
            $("#list-cart").html(respone);
            var proQty = $('.pro-qty');
            proQty.prepend('<span class="dec qtybtn">-</span>');
            proQty.append('<span class="inc qtybtn">+</span>');
            proQty.on('click', '.qtybtn', function () {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $button.parent().find('input').val(newVal);
            });
        }
    });
</script>
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
@endpush