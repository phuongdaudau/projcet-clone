@extends('layouts.member.app')

@section('title','List Products')
@push('css')
<style>
    .circle-color{
        border-radius:50%; 
        border:1px solid #e8e9eb;
        margin: 0 20px;
    }
</style>
@endpush

@section('content')

<div id="grid">
    @php
        $images = explode(",", $product[0]->images);
        $images2 = array_slice($images,1,2);
    @endphp
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{ $images[0] }}" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach($images2 as $image)
                            <img data-imgbigurl="{{$image}}"
                                src="{{ $image }}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{$product[0]->name}}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price">${{$product[0]->price }}</div>
                        <p></p>
                        <form action="{{ url('/member/cart') }}" method="GET">
                            <input name="product_id" value="{{$product[0]->id}}" hidden>
                            <ul>
                                <li>
                                    <b>Color</b> 
                                    <div class="form-group">
                                        <select name="color_id" class="filter-make filter form-control">
                                            <option value="" >Select Color</option>
                                            @foreach($product[0]->colors as $color)
                                            <option value="{{$color->id}}" {{ request()->get('color_id') == $color->id ? 'selected' : '' }}>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <b>Size</b> 
                                    <div class="form-group">
                                        <select name="size_id" class="filter-make filter form-control">
                                            <option value="" >Select Size</option>
                                            @foreach($product[0]->sizes as $size)
                                            <option value="{{$size->id}}" {{ request()->get('size_id') == $size->id ? 'selected' : '' }}>{{$size->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input id="quantity-item" name="quantity" type="text" value="1">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success form-group" style="height: 40px;margin: 10px;"> Add to card </button>
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
                                    <p>{{ $product[0]->description}}</p>
                                </div>
                            </div>>
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