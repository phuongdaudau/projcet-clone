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
        @if(Session::has('Cart') !=null && !Auth::check())
            @foreach(Session::get('Cart')->products as $item)
            @php 
                $images = explode(",", $item['productInfo']->images);
            @endphp
            <tr>
                <td class="shoping__cart__item">
                    <img style="width: 150px;" src="{{ asset('storage/product/'.$images[1]) }}" alt="">
                    <h5><a href="{{route('product.detail', $item['productInfo']->slug)}}">{{$item['productInfo']->name }}</a></h5>
                </td> 
                <td class="shoping__cart__price">
                ${{ $item['productInfo']->price}}
                </td>
                <td class="shoping__cart__price">
                {{ $item['size']}}
                </td>
                <td class="shoping__cart__price">
                {{ $item['color']}}
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
        @if(Auth::check())
            @foreach($cartAuth as $item)
                @php 
                    $images = explode(",", $item->product->images);
                @endphp
                <tr>
                    <td class="shoping__cart__item">
                        <img style="width: 100px;" src="{{ asset('storage/product/'.$images[1]) }}" alt="">
                        <h5><a href="{{route('product.detail', $item->product->slug)}}">{{$item->product->name }}</a></h5>
                    </td> 
                    <td class="shoping__cart__price">
                    ${{ $item->product->price}}
                    </td>
                    <td class="shoping__cart__price">
                    {{ $item['size']}}
                    </td>
                    <td class="shoping__cart__price">
                    {{ $item['color']}}
                    </td>
                    <td class="shoping__cart__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input id="quantity-item-{{$item->product->id}}" type="text" value="{{$item['quantity']}}">
                            </div>
                        </div>
                    </td>
                    <td class="shoping__cart__total">
                    ${{  $item->product->price * $item['quantity']}}
                    </td>
                    <td class="shoping__cart__total">
                        <span class="save" id="{{$item->product->id}}" >Save</span>
                    </td>
                    <td class="shoping__cart__total">
                        <span class="delete" id="{{$item->product->id}}" >Delete</sp>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>