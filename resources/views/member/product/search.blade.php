@extends('layouts.member.app')

@section('title','Search Results')
@push('css')
<style>
    .circle-color{
        border-radius:50%; 
        border:1px solid #e8e9eb;
    }
    .pagination{
        margin: 50px 30px;
        float: right;
    }
    .set-width{
        width: 315px !important;
        height: 300px;
    }
</style>
@endpush

@section('content')

<div id="grid">
    @foreach($products as $item)
    @php
        $listSize = "";
        $images = explode(",", $item->images);
        $frontImage = $images[0];
        foreach($item->sizes as $size){
            $listSize = $listSize .",". $size->name;
        }
    @endphp
    <div class="product">
        <div class="make3D">
            <div class="product-front">
                <div class="shadow"></div>
                <img src="{{$frontImage}}" alt="" />
                <div class="image_overlay"></div>
                <div class="add_to_cart">Add to cart</div>
                <div class="view_gallery">View gallery</div>                
                <div class="stats">        	
                    <div class="stats-container set-width">
                        <span class="product_price">${{$item->price}}</span>
                        <span class="product_name">{{$item->name}}</span>    
                        <p>{{$item->category->name}}</p>                                            
                        <div class="product-options">
                            <strong>SIZES</strong>
                            <span>{{ltrim($listSize,",")}}</span>
                            <strong>COLORS</strong>
                            <div class="colors">
                                @foreach($item->colors as $color)
                                <div class="circle-color" style="background: <?php echo $color->color_hex ?>;"><span></span></div>
                                @endforeach
                            </div>
                        </div>                       
                    </div>                         
                </div>
            </div>
            
            <div class="product-back">
                <div class="shadow"></div>
                <div class="carousel">
                    <ul class="carousel-container">
                        @foreach($images as $image)
                        <li><img src="{{$image}}" alt="" /></li>
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
    </div>    
    @endforeach
    <div class="row">
        {{ $products->links('vendor.pagination.bootstrap-4', ['paginator' => $products]) }}
    </div>
</div>
@endsection