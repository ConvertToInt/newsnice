@foreach($comments as $comment)
<div class="display-comment">
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box has-background-white-ter has-text-black-lighter">
                <div class="columns">
                    <div class="column is-11">
                        <p>
                            <small>Comment by u/{{$comment->user->username}}</small> <small>{{$comment->created_at->diffForHumans()}}</small> {{-- diffforhumans uses created at to calculate time since creation --}}
                            <br><br>
                            <p class="is-5 has-text-black-lighter">{{$comment->body}}</p>
                        </p>
                    </div>
                    @auth
                    @if (Auth::user()->id = $comment->user_id) {{-- or Auth::user()->id = $subweddit->mod_id (SHOULD BE ADMIN ID --}}
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
                    @endif
                    @endauth
                </div>

                <div class="columns is-centered">
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
                </div>
            </div>
        </div>
    </div>
    @include('snippets._comments-replies', ['comments' => $comment->replies])
</div>

@endforeach