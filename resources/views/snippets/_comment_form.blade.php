<div class="columns is-centered mt-4">
    <div class="column is-half">
        <div class="box has-background-white-ter has-text-black-lighter">
            <article class="media">
            <div class="media-content">
            <form method ="POST" action='{{route('comment',['article'=>$article])}}' >
            @csrf
                <div class="field">
                <p class="control">
                    <textarea name ="body" class="textarea has-background-white-bis has-text-white-bis" placeholder="Add a comment..."></textarea>
                </p>
                </div>
                <nav class="level">
                <div class="level-left">
                    @auth
                    <div class="level-item">
                        <input type="submit" class="button is-primary" value="Post Comment"></a>
                    </div>
                    @endauth
                    @guest
                    <div class="level-item">
                        <a href="/login"><input class="button is-primary" value="Log in to comment"></a>
                    </div>
                    @endguest
                </div>
                </nav>
                {{-- <input type="hidden" name="post_id" value="{{ $article->id }}" /> --}}
                </form>
            </div>
            </article>
        </div>
    </div>
</div>