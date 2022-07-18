@extends('layouts.member.app')

@section('title','List Products')
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
    span a {
        color: #6c757d;
        text-decoration: none;
    }
    .form-group select {
        width: 200px;
        margin: 10px 10px;
    }
</style>
@endpush

@section('content')
<form action="{{ url('/') }}" method="GET">
    <div class="row" id="filter">
        <div class="form-group">
            <select data-filter="make" name="category_id" id="select-category" class="filter-make filter form-control">
                <option value="" >Select Category</option>
                <option value="0" >Show All</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select data-filter="model" class="filter-model filter form-control">
                <option value="" >Select Price Range</option>
                <option value="">Show All</option>
            </select>
        </div>
        <div class="form-group">
            <select name="recorder" id="select-page" class="filter-price filter form-control">
                <option @if(request()->get('recorder') == 6 ) selected @endif value="6">6</option>
                <option @if(request()->get('recorder') == 12 ) selected @endif value="12">12</option>
                <option @if(request()->get('recorder') == 30 ) selected @endif value="30">30</option>
                <option @if(request()->get('recorder') == 50 ) selected @endif value="50">50</option>
            </select>
        </div>
        {{-- <button type="submit" class="btn btn-success form-group" style="height: 40px;
    margin: 10px;"> Filter </button> --}}
    </div> 
</form>
<div id="grid">
	
    @foreach($products as $item)
    @php
        $listSize = "";
        $imgs = explode(",", $item->images);
        $images = array_slice($imgs,1,3);
        foreach($item->sizes as $size){
            $listSize = $listSize .",". $size->name;
        }
    @endphp
    <div class="product">
        <div class="make3D">
            <div class="product-front">
                <div class="shadow"></div>
                <img src="{{ asset('storage/product/'.$images[0]) }}" alt="" />
                <div class="image_overlay"></div>
                <div class="add_to_cart">Add to cart</div>
                <div class="view_gallery">View gallery</div>                
                <div class="stats">        	
                    <div class="stats-container set-width">
                        <span class="product_price">${{$item->price}}</span>
                        <span class="product_name"><a href="{{route('product.detail', $item->slug)}}">{{$item->name}}</a></span>    
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
                        <li><img src="{{ asset('storage/product/'.$image) }}" alt="" /></li>
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
@push('script')
<script>

    $(document).ready(function () {

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

    })

        
    </script>
@endpush