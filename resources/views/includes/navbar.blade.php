

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">{{ $data->store_name }} </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
         <div style="padding-right: 20px;">
                @auth
                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                @endauth
            </div>
      </li>
      <li>
           @auth
           <a href="{{ route('auth.viewcart') }}">
                    <span>
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-info">
                            @{{ cartCounts }}
                        </span>
                    </span>
                </a>
           @endauth

           @guest
           <a href="{{ route('guest.user-login') }}">
                    <span>
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-info">
                            @{{ cartCounts }}
                        </span>
                    </span>
                </a>
           @endguest
      </li>
      <li class="nav-item">
         <a class="text-muted" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3">
                    <circle cx="10.5" cy="10.5" r="7.5"></circle>
                    <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                </svg>
            </a>
      </li>
      <li class="nav-item">
      @auth
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('auth.buyerLogout') }}">Logout</a>
      @endauth
      @guest
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('guest.user-login') }}">Login</a>
      @endguest
      </li>
    </ul>
    
  </div>
</nav>