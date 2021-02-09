<nav class="navbar has-background-white-ter mb-6 py-3" role="navigation" aria-label="main navigation" style="border-bottom:2px solid hsl(0, 0%, 92%);">

            <div class="navbar-brand" style="margin-left:33%">
                <a class="navbar-item" href="{{ route('home') }}">
                    <img src="{{url('img/logobig.png')}}" width="500">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-end">
                <div class="navbar-item">
                    @if (Route::has('login'))
                        <div class="hidden top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <a href="{{ route('profile.show') }}">
                                    <img class="cog" src="{{url('img/cog.PNG')}}" width="40">
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="button is-primary">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="button is-light"><strong>Sign up</strong></a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
                </div>
            </div>
        </nav>   