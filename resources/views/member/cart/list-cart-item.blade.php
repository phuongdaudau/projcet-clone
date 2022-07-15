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
                        <button class="delete" id="{{$item['productInfo']->id}}" >Delete</button>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>