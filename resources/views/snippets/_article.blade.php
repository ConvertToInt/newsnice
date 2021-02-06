{{-- <a href="{{url("/w/{$article->slug}")}}"> --}}
    <div class="box has-background-white-ter mb-5">
        <div class="columns is-centered">
            <div class="column"></div>
                <div class="column is-3">
                    <div class="imageBox" style="display: flex; justify-content: center; align-items: center;">
                        @if($article->thumbnail == "default")
                            <img src="img/placeholder.png" style="height:35px; width:35px">
                        @else
                            <img src="{{$article->thumbnail}}" style="object-fit: cover; height:100px; width: 150px; border-radius:3%">
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
                <p>
                    <span class="has-text-weight-bold is-size-6 has-text-grey-lighter">{{$article->category->category}}</span>&nbsp&middot;&nbsp{{$article->created_at->diffForHumans()}} {{-- diffforhumans uses created at to calculate time since creation --}}
                </p><br>
            </div>
        </div>
    </div>
{{-- </a> --}}