@if (Auth::user()->is_favorite($cycle->id))
    <div id="favorite_parent{{$cycle->id}}" class="unfavorite">
        <span id="favorite{{$cycle->id}}" class="far fa-thumbs-up" onclick="postFavorite({{ $cycle->id }}, {{ count($cycle->favorited)}})"></span>
    </div>
@else
    <div id="favorite_parent{{$cycle->id}}" class="favorite">
        <span id="favorite{{$cycle->id}}" class="far fa-thumbs-up" onclick="postFavorite({{ $cycle->id }}, {{ count($cycle->favorited)}})"></span>
    </div>
@endif
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="{{ asset('js/favorite.js') }}"></script>
<link rel="stylesheet" href="{{asset('/css/favorite_button.css')}}">