@extends('layout')

@section('head')

{{-- <link href="<path-to-gemini-scrollbar>/gemini-scrollbar.css" rel="stylesheet">
<script src="<path-to-gemini-scrollbar>/index.js"></script> --}}

@endsection

@section('content')

    <h1 class="title has-text-centered has-text-weight-bold has-text-grey-darker is-size-3 mb-6"><a class="has-text-grey-darker" href="{{ route('home') }}">Home</a> | <a class="has-text-grey-darker" href="{{route('following_feed')}}">Following</a></h1>

    <div class="columns is-centered">
        <div class="column is-7">
            <div class="ml-2 dropdown is-hoverable" style="float:left">
                <div class="dropdown-trigger">
                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                    <span>Most Recent</span>
                    <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                    </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                    <div class="dropdown-content" style="width:9em">
                    <a href='#' class="dropdown-item is-active">
                        Most Recent
                    </a>
                    <hr class="dropdown-divider">
                    <a href='#' class="dropdown-item">
                        Top
                    </a>
                    </div>
                </div>
            </div>
            
            <div style="float:right">
                @isset($currentCategory)
                    @isset($following)
                        @if(! in_array($currentCategory, $following))
                            <button id="follow-btn" class="button" style="background-color:#FFEE33">
                                <i class="fas fa-plus-circle mr-2 has-text-grey-dark"></i>
                                Follow 
                            </button>
                        @elseif(! auth()->user()->following($currentCategory))
                            <button id="follow-btn" class="button" style="background-color:#FFEE33">
                                <i class="fas fa-plus-circle mr-2 has-text-grey-dark"></i>
                                Follow 
                            </button>
                        @endif
                    @else
                        @if(! auth()->user()->following($currentCategory))
                            <button id="follow-btn" class="button" style="background-color:#FFEE33">
                                <i class="fas fa-plus-circle mr-2 has-text-grey-dark"></i>
                                Follow 
                            </button>
                        @endif
                    @endisset
                @endisset
                <div class="mr-2 dropdown is-hoverable">
                    <div class="dropdown-trigger">
                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                            <span>{{ $currentCategory ?? 'Category' }}</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content" style="width:7.5em; max-height:10em; overflow: auto;">
                        <a href='/' class="dropdown-item">
                            All
                        </a>
                        @foreach ($categories as $category)
                            <a href='{{route('category', ['category'=>$category->name])}}' class="dropdown-item">
                                {{$category->name}}
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($articles as $article)
        @include('snippets._article')    
    @endforeach

@isset ($currentCategory)
    <script>

        $("#follow-btn").click(function(event){
            event.preventDefault();

            $.ajax({
                @auth url:'{{url("/$currentCategory/toggleFollow")}}', @endauth 
                @guest url:'{{url("/cookie/$currentCategory/toggleFollow")}}', @endguest
                type:"POST",
                data:{
                    _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
                    category:('$category->name')
                },
                success:function(response){
                    $('#follow-btn').toggle();
                },
            });
        });
</script>
@endisset
@endsection