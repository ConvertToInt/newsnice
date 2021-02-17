<link rel="stylesheet" href="{{url('css/article.css')}}">

@foreach($comments as $comment)
<div class="display-comment">
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box has-background-white-ter has-text-black-lighter">
                <div class="columns" style="border-bottom:1px solid #DEDEDE">
                    <div class="column is-11">
                        <p>
                            <strong>Comment by {{$comment->user->display_name}}</strong> <small>{{$comment->created_at->diffForHumans()}}</small> {{-- diffforhumans uses created at to calculate time since creation --}}
                        </p>
                    </div>
                    <div class="column is-1">
                        <div class="icon has-text-black-lighter">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    @auth
                    {{--@if (Auth::user()->id = $comment->user_id)  or Auth::user()->id = $subweddit->mod_id (SHOULD BE ADMIN ID 
                        <div class="column is-1">
                            <form method ="POST"
                                    action='{{route('comment_delete',['article'=>$article])}}'  
                                    style="display:inline!Important;">

                                    @csrf
                                    @method('delete')

                                    <div class="field">
                                        <div class="control">
                                            <button class="submit delete is-primary">Edit</button>
                                        </div>
                                    </div>
                            </form>  
                        </div>
                    @endif--}}
                    @endauth
                </div>

                <div class="columns">
                    <div class="column">
                    <p class="is-5 has-text-black-lighter">{{$comment->body}}</p>
                    </div>
                </div>
                            

                {{-- <div class="columns is-centered reply">
                    <div class="column is-12">
                    @auth
                        <form method="post" action='{{route('reply',['article'=>$article])}}'>
                            @csrf

                            <div class="field has-addons">
                                <div class="control is-expanded">
                                    <input class="input is-small" type="text" name="body"  placeholder="Write a reply...">
                                </div>
                                <div class="control">
                                    <button class="button is-primary is-small">Reply</button>
                                </div>
                            </div>

                            <input type="hidden" name="post_id" value="{{ $article->id }}" />
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                        </form>
                    @endauth
                    </div>
                </div> --}}
                <div class="columns">
                    <div class="column">
                        <div class="icon {{$comment->id}}_like">
                            <i class="fa fa-heart fa-lg"></i>
                        </div>
                        <span id="{{$comment->id}}_likes"></span>
                        <a class="ml-3" href="#">Reply</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    /**
     * Check if comment is liked
     */
    @auth
        $.ajax({
            url: "{{url("/comment/$comment->id/checkLiked")}}",
            type:"POST",
            data:{
                id:('{{$comment->id}}'), // DECLARE AT START OF SCRIPT
                _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
                type:('Comment'), // DECLARE AT START OF SCRIPT
            },
            success:function(response){
                if (response == true){
                    $('.{{$comment->id}}_like').find('i').toggleClass("liked");
                }
                console.log(response);
            },
        });
    @endauth

    /**
     * Check the amount of likes for the article
     */
    $.ajax({
        url: "{{url("/comment/$comment->id/checkLikes")}}",
        type:"POST",
        data:{
            id:('{{$comment->id}}'), // DECLARE AT START OF SCRIPT
            _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
            type:('Comment'), // DECLARE AT START OF SCRIPT
        },
        success:function(response){
            var likes = document.getElementById('{{$comment->id}}_likes'); // DECLARE AT START OF SCRIPT
            console.log(response);
            likes.innerHTML = response;
        },
    });

    /**
     * When article is liked, ajax call to toggle like status, then if successful ajax call to retrieve like status and total likes
     */
    $(".{{$comment->id}}_like").click(function(event){
        event.preventDefault();

        //$('.{{$article->id}}_like').find('i').toggleClass("liked");

        //var _token   = $('meta[name="csrf-token"]').attr('content');
        //var id = ('{{$article->id}}');

        $.ajax({
            url: "{{url("/comment/toggleLike")}}",
            type:"POST",
            data:{
                id:('{{$comment->id}}'), 
                _token:('{{ csrf_token()}}'), 
                type:('Comment'), 
            },
            
            success:function(response)
            {
                $.ajax({
                    url: "{{url("/comment/$comment->id/checkLikes")}}",
                    type:"POST",
                    data:{
                        id:('{{$comment->id}}'),
                        _token:('{{ csrf_token()}}'),
                        type:('Comment'),
                    },
                    success:function(response){
                        var likes = document.getElementById('{{$comment->id}}_likes'); // DECLARE AT START OF SCRIPT
                        console.log(response);
                        likes.innerHTML = response;
                    },
                });

                $.ajax({
                    url: "{{url("/comment/$comment->id/checkLiked")}}",
                    type:"POST",
                    data:{
                        id:('{{$comment->id}}'), // DECLARE AT START OF SCRIPT
                        _token:('{{ csrf_token()}}'), // DECLARE AT START OF SCRIPT
                        type:('Comment'), // DECLARE AT START OF SCRIPT
                    },
                    success:function(response){
                        if (response == true){
                            $('.{{$comment->id}}_like').find('i').toggleClass("liked");
                        } else if (response == false){
                            $('.{{$comment->id}}_like').find('i').toggleClass("liked");
                        }
                        console.log(response);
                    },
                });
            },
        }); 
    });

    </script>
    
    @include('snippets._comments-replies', ['comments' => $comment->replies])
</div>

@endforeach

