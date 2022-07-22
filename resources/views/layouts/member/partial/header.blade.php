<div id="header" class="row">
    <div class="col-6">
        <ul>
            <li><a href="{{route('product.list')}}">Home</a></li>
            <li><a href="">BRANDS</a></li>
            @if(auth('web')->user())
                <li><a href="">{{auth('web')->user()->name}}</a></li>
            @endif
            @if(Auth::check())
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOGOUT</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    class="d-none">
                    @csrf
                </form>
            @else
                <li><a href="{{ route('login') }}">LOGIN</a></li>
            @endif	                                              
        </ul>
    </div>	
    <div class="col-6 pt-4">
            <form method="GET" action="{{ route('product.search') }}">	
                <div class="input-group">
                <input value="{{ isset($query) ? $query : '' }}" name="query" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary ml-3">search</button>
                </div>
            </form>
    </div>
</div>