<link rel="stylesheet" href="{{url('css/article.css')}}">

<div class="columns is-centered">
    <div class="column is-half">
        <a href="{{route('article_show', ['article'=>$article->slug])}}">
            <div class="box has-background-white-ter mb-5 pb-0">
                <div class="columns is-centered">
                    <div class="column"></div>
                        <div class="column is-3">
                            <div class="imageBox">
                                @if($article->thumbnail == "default")
                                    <img src="img/placeholder.png" style="height:35px; width:35px">
                                @else
                                    <img src="{{$article->thumbnail}}" style="object-fit: cover; height:100%; width: 100%; border-radius:3%;">
                                @endif
                            </div>
                        </div>
                        <div class="column is-9">
                            <h1 class="has-text-weight-bold is-size-6 has-text-blue">{{$article->title}}</h1>
                        </div>
                    <div class="column"></div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="icon {{$article->id}}_like">
                            <i class="fa fa-heart fa-lg"></i>
                        </div>
                        <span id="{{$article->id}}_likes"></span>
                    
                        <div style="float:right">
                            <span class="has-text-weight-bold is-size-6 has-text-grey-darker">{{$article->category->category}}</span>&nbsp&middot;&nbsp{{$article->created_at->diffForHumans()}} {{-- diffforhumans uses created at to calculate time since creation --}}
                        </div>
                    
                        {{-- <form method ="POST" action='{{url("/article/{$article->id}/checkLikes")}}'>
                        @csrf
                        <button class="submit">test</button>
                        <input type="hidden" name="id" value="{{ $article->id }}" />
                        <input type="hidden" name="type" value="{{ $type }}" />
                        </form> --}}
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<script>

    /**
     * Check if article is liked
     */
    @auth
        $.ajax({
            url: "{{url("/article/$article->id/checkLiked")}}",
            type:"POST",
            data:{
                id:('{{$article->id}}'), // DECLARE AT START OF SCRIPT
                _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
                type:('Article'), // DECLARE AT START OF SCRIPT
            },
            success:function(response){
                if (response == true){
                    $('.{{$article->id}}_like').find('i').toggleClass("liked");
                }
            },
        });
    @endauth

    /**
     * Check the amount of likes for the article
     */
    $.ajax({
        url: "{{url("/article/$article->id/checkLikes")}}",
        type:"POST",
        data:{
            id:('{{$article->id}}'), // DECLARE AT START OF SCRIPT
            _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
            type:('Article'), // DECLARE AT START OF SCRIPT
        },
        success:function(response){
            var likes = document.getElementById('{{$article->id}}_likes'); // DECLARE AT START OF SCRIPT
            likes.innerHTML = response;
        },
    });

    /**
     * When article is liked, ajax call to toggle like status, then if successful ajax call to retrieve like status and total likes
     */
    $(".{{$article->id}}_like").click(function(event){
        event.preventDefault();

        //$('.{{$article->id}}_like').find('i').toggleClass("liked");

        //var _token   = $('meta[name="csrf-token"]').attr('content');
        //var id = ('{{$article->id}}');

        $.ajax({
            url: "{{url("/article/toggleLike")}}",
            type:"POST",
            data:{
                id:('{{$article->id}}'), 
                _token:('{{ csrf_token()}}'), 
                type:('Article'), 
            },
            
            success:function(response)
            {
                $.ajax({
                    url: "{{url("/article/$article->id/checkLikes")}}",
                    type:"POST",
                    data:{
                        id:('{{$article->id}}'),
                        _token:('{{ csrf_token()}}'),
                        type:('Article'),
                    },
                    success:function(response){
                        var likes = document.getElementById('{{$article->id}}_likes'); // DECLARE AT START OF SCRIPT
                        likes.innerHTML = response;
                    },
                });

                $.ajax({
                    url: "{{url("/article/$article->id/checkLiked")}}",
                    type:"POST",
                    data:{
                        id:('{{$article->id}}'), // DECLARE AT START OF SCRIPT
                        _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
                        type:('Article'), // DECLARE AT START OF SCRIPT
                    },
                    success:function(response){
                        if (response == true){
                            $('.{{$article->id}}_like').find('i').toggleClass("liked");
                        } else if (response == false){
                            $('.{{$article->id}}_like').find('i').toggleClass("liked");
                        }
                    },
                });
            },
        }); 
    });
</script>