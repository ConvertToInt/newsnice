<link rel="stylesheet" href="{{url('css/article.css')}}">

<div class="columns is-centered font-sm">
    <div class="column is-7 mx-3">
        <a href="{{route('article_show', ['article'=>$article->slug])}}">
            <div class="box has-background-white-ter mb-5 article">
                    <div class="columns">
                        <div class="column" style="width:170px">
                            {{-- <div style="width:18%; display:inline-block; height:6.5em; float:left"> --}}
                                <div class="imageBox">
                                    <img src="{{$article->thumbnail}}" style="object-fit: cover; height:100%; width: 100%; border-radius:3%;">
                                </div>
                            </div>
                            <div class="column is-10 pr-6 mt-1">
                            {{-- <div style="width:82%; display:inline-block; height:6.5em; float:right"> --}}
                                <span class="has-text-weight-bold">{{$article->title}}</span>
                            </div>
                         
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="icon {{$article->id}}_like">
                                <i class="fa fa-heart fa-lg"></i>
                            </div>
                            <span id="{{$article->id}}_likes"></span>
                        
                            <div style="float:right">
                                <span class="has-text-weight-bold">{{$article->category->name}}</span>&nbsp&middot;&nbsp{{$article->created_at->diffForHumans()}} {{-- diffforhumans uses created at to calculate time since creation --}}
                            </div>
                        </div>
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