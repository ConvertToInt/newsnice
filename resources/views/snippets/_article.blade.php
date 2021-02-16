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
                    <div class="column is-9">
                        <span class="icon {{$article->id}}_like">
                            <i class="fa fa-heart fa-lg {{ $article->isLiked($type) ? 'liked' : ''}}"></i> {{-- {{ $article->isLiked() ? 'color-red' : 'color-grey'}} --}}
                        </span>
                        <span class="has-text-weight-bold is-size-6 has-text-grey-lighter">{{$article->category->category}}</span>&nbsp&middot;&nbsp{{$article->created_at->diffForHumans()}} {{-- diffforhumans uses created at to calculate time since creation --}}
                    </div>
                    <div class="column is-2">
                    
                    {{-- <form method ="POST" action='{{url("/article/toggleLike")}}'>
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

    $(".{{$article->id}}_like").click(function(event){
        event.preventDefault();

        $('.{{$article->id}}_like').find('i').toggleClass("liked");

        //var _token   = $('meta[name="csrf-token"]').attr('content');
        //var id = ('{{$article->id}}');

        $.ajax({
            url: "/article/toggleLike",
            type:"POST",
            data:{
                id:('{{$article->id}}'),
                _token:('{{ csrf_token()}}'),
                type:('{{$type}}'),
            },
            
            success:function(response){
                console.log(response);
            },
        });
    });
</script>