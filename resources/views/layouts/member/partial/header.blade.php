<div id="header" class="row">
    <div class="col-6">
        <ul>
            <li><a href="{{route('product.list')}}">Home</a></li>
            <li><a href="">BRANDS</a></li>
            <li><a href="">DESIGNERS</a></li>
            <li><a href="{{ route('login') }}">LOGIN</a></li>	                                              
        </ul>
    </div>	
    <div class="col-6 pt-4">
            <form method="GET" action="{{ route('product.search') }}">	
                <div class="input-group">
                <input value="{{ isset($query) ? $query : '' }}" name="query" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary">search</button>
                </div>
            </form>
    </div>
</div>