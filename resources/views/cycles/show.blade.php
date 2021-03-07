@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold font-family-Tahoma">DETAILS</h1>
    <div class='form-row'>
        <div class="col-md-6" style="text-align:center; margin-top:30px;">
            <div class="card-header" style="max-height:80px; width:80%; border:solid; border-width:thin; display:inline-block;">
                <a href="/users/{{$cycle->user->id}}">
                    @if($cycle->user->image == null)
                        <img class="img-fluid float-left user-img" src="{{ Gravatar::src($cycle->user->email, 45) }}" alt="" style="border-radius:50%; margin-right:10px; margin-bottom:10px;">
                    @else
                        <img class="float-left user-img" src="{{$cycle->user->image}}" width="45" height="45" style="border-radius:50%; margin-right:10px; margin-bottom:10px;">
                    @endif
                </a>
                <div class="side">
                    <a href="/users/{{$cycle->user->id}}" class="user_name" style="color:black; font-size:1.2em;">{{$cycle->user->name}}</a>
                    @if(Auth::id() === $cycle->user_id)
                        <a href="#" class="nav-link" data-toggle="dropdown" style="color:black">
                            <span class="fas fa-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu" style="list-style: none;">
                            <li class="dropdown-item">
                                <a href="{{ route('cycles.edit', [$cycle->id]) }}">
                                    <span class="fa fa-edit" style="color:black;"></span>
                                </a>
                                {!! link_to_route('cycles.edit', '編集', [$cycle->id], ['class' => 'btn btn-default']) !!}
                            </li>
                            <li class="dropdown-item">
                                <a href="#" type="button" data-toggle="modal" data-target="#cycle-delete{{$cycle->id}}">
                                    <span class="fa fa-trash delete-btn" style="color:black;"></span>
                                </a>
                                <a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#cycle-delete{{$cycle->id}}">削除</a>
                            </li>
                        </ul>
                    @endif
                </div>
                <p style="text-align:right;">{{$cycle->edit}}</p>
            </div>
            <div class="img">
                <img class="place-img" src="{{$cycle->image}}" width="80%" height="auto" style="border-bottom:solid; border-right:solid; border-left:solid; border-width:thin;">
            </div>
            <div style="width:80%; display:inline-block;">
                <div class="side">
                    <h4>{{$cycle->title}}</h4>
                    <div class="fav-btn" style="font-size:x-large;">
                        <span>
                            @include('favorites.favorite_button', ['cycle'=>$cycle])
                        </span>
                        <span id="favorite_count{{$cycle->id}}">{{count($cycle->favorited)}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <span style="vertical-align:middle;">
                <div class="row map">
                    <div id="map" style="border:solid; border-width:thin; width:80%; height:350px;"></div>
                </div>
            </span>
        </div>
    </div>
    <p style="font-weight:bold; margin-top:8px;">メッセージ</p>
    <div class='form-row'>
        <div class='col-md-7'>
            <table class="justify-content-center" style="display:flex; margin-top:5px;">
                <tr class="message_parent">
                    <td class="table-bordered" id="message" style="font-size:1.2em; min-height:147px;">
                        <span style="margin-left:10px;">
                            {{ $cycle->content }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <div class='col-md-5'>
            <table class="table table-bordered" height="147" style="margin-top:5px;">
                <tr>
                    <th>エリア</th>
                    <td>{{$cycle->area}}<span style="padding-left:8px;">{{$cycle->city}}</span></td>
                </tr>
                <tr>
                    <th>場所</th>
                    <td>{{ $cycle->location }}</td>
                </tr>
                <tr>
                    <th>時間</th>
                    <td>{{ $cycle->time }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class='form-row'>
        <div class="col-sm-8 offset-sm-2">
            <form id="form" method="POST" action="/ajax">
                <div class="form-group">
                    {{ csrf_field() }}
                    <input type="hidden" name="cycle_id" value="{{$cycle->id}}">
                    <label for="comment" class="comment"style="font-weight:bold;">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" style="font-size:1.3em;"></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="コメントする" style="float:right;">
            </form>
        </div>
    </div>
    <div id="results" style="margin-bottom:10px;"></div>
    <div style="margin-bottom:10px;">
        @if(count($cyclings)>0)
            @foreach ($cyclings as $cycling)
                <div class="form-row">
                    <div class="col-sm-8 offset-sm-2">
                        <div class="card cycle-comment cycling-body-{{$cycling->id}}" style="min-height: 150px; cursor:pointer; margin-top:10px;" onclick="postData({{$cycling->id}})">
                            <div class="side" style="margin-left:8px; margin-top:8px;">
                                <a href="/users/{{$cycling->user->id}}" onclick="event.stopPropagation();">
                                    <div>
                                        @if($cycling->user->image == null)
                                            <img class="img-fluid float-left user-img" src="{{ Gravatar::src($cycling->user->email, 35) }}" alt="" style="margin-right:15px; border-radius:50%;" onclick="location:href='/users/{{$cycling->user->id}}';">
                                        @else
                                            <img class="float-left user-img" src="{{$cycling->user->image}}" width="35" height="35" style="margin-right:15px; border-radius:50%;" onclick="location:href='/users/{{$cycling->user->id}}';">
                                        @endif
                                        <span class="commentuser_name" style="color:black;">{{$cycling->user->name}}</span>
                                    </div>
                                </a>
                                <small>
                                    <span style="text-align:right; list-style: none; margin-right:8px;">{{$cycling->time}}</span>
                                </small>
                            </div>
                            <p style="margin-top:10px; margin-left:60px; margin-right:10px;">{{$cycling->comment}}</p>
                            <p style="margin-top:8px;">
                                <ul class="icons" style="list-style: none;">
                                    <li>
                                        <span class="far fa-comment icon" style="color:black;" onclick="openCommentModal({{$cycling->id}}); event.stopPropagation();"></span> 
                                     </li>
                                    <li>
                                        @if(Auth::id() === $cycling->user_id)
                                            <span class="fa fa-trash fa-lg icon" style="color:black;" onclick="openDeleteModal({{$cycling->id}}); event.stopPropagation();"></span> 
                                        @endif
                                    </li>
                                </ul>
                            </p>
                        </div>
                        
                        <!--ボタン・リンククリック後に表示される画面の内容 -->
                        <div class="modal fade" id="cycling-comment-thread{{$cycling->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="height:35px;">
                                        <h4></h4>
                                        <span class="fa fa-times fa-xs" style="cursor:pointer;" data-dismiss="modal"></span>
                                    </div>
                                     <div style="margin-right:7px; margin-left:7px;">
                                        @if(count($cyclings)>0)
                                            <p>
                                                <div id="deleted{{$cycling->id}}"></div>
                                            </p>
                                            <div> 
                                                @if($cycling->parent_id !== null)
                                                    @if($cyclings->where('id', $cycling->parent_id)->first() !== null)
                                                        <div id="upData{{$cycling->id}}" style="min-height: 150px;"></div>
                                                    @endif
                                                @endif
                                                <div class="card" style="min-height:150px;">
                                                    <div class="side" style="margin-left:8px; margin-top:8px;">
                                                        <a href="/users/{{$cycling->user->id}}">
                                                            @if($cycling->user->image == null)
                                                                <img class="img-fluid float-left user-img" src="{{ Gravatar::src($cycling->user->email, 35) }}" alt="" style="margin-right:15px; border-radius:50%;">
                                                            @else
                                                                <img class="float-left user-img" src="{{$cycling->user->image}}" width="35" height="35" style="margin-right:15px; border-radius:50%;">
                                                            @endif
                                                            <span id="modal-user_name{{$cycling->id}}" style="color:black;"></span>
                                                        </a>
                                                        <small>
                                                            <span id="modal-time{{$cycling->id}}" style="text-align:right; list-style: none; margin-right:8px;"></span>
                                                        </small>
                                                    </div>
                                                    <p style="margin-top:10px; margin-left:60px;">
                                                        <span id="modal-comment{{$cycling->id}}"></span>
                                                    </p>
                                                </div>
                                                @if($cyclings->where('parent_id', $cycling->id)->first() !== null)
                                                    <div style="max-height:20px;">
                                                        <div id="vertical{{$cycling->id}}"></div>
                                                    </div>
                                                    <div id="underDatas{{$cycling->id}}"></div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="blank"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!--ボタン・リンククリック後に表示される画面の内容 -->
                        <div class="modal fade" id="cycling-comment{{$cycling->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">コメント</h4>
                                        <button id="delete-modal{{$cycling->id}}" type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                    </div>
                                    <div class="modal-body">
                                        @include('commons.error_messages')
                                        <form id="comment{{$cycling->id}}" method="POST" action="/ajax">
                                            <div class="form-group">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="alert_id" value="{{$cycle->id}}">
                                                <input type="hidden" name="parent_id" value="{{$cycling->id}}">
                                                <textarea class="form-control" name="comment" style="font-size:1.3em;"></textarea>
                                            </div>
                                            <button type="button" class="comment-button btn btn-primary" style="float:right;">コメントする</button>
                                        </form>
                                    </div>
                                </div>
                                @if ($errors->has('comment'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('comment') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!--ボタン・リンククリック後に表示される画面の内容 -->
                        <div class="modal fade" id="cycling-delete{{$cycling->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">投稿削除確認画面</h4>
                                        <span class="fa fa-times" data-dismiss="modal" style="cursor:pointer;"></span>
                                    </div>
                                    <div class="modal-body">
                                        <label>本当に削除しますか？（この操作は取り消しできません。）</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" onclick="postDeletedata({{$cycling->id}})" data-dismiss="modal">削除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <!--ボタン・リンククリック後に表示される画面の内容 -->
    <div class="modal fade" id="cycle-delete{{$cycle->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">投稿削除確認画面</h4>
                    <span class="fa fa-times" data-dismiss="modal" style="cursor:pointer;"></span>
                </div>
                <div class="modal-body">
                    <label>本当に削除しますか？（この操作は取り消しできません。）</label>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('cycledestroys.destroy', [$cycle->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <input class="btn btn-danger" type="submit" value="削除">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <span id="js-getVariable" data-name="{{ $cycle }}"></span>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/md5.js') }}"></script>
    <script src="{{ asset('/js/comments_display.js') }}"></script>
    <script src="{{asset('/js/comment_delete.js')}}"></script>
    <script src="{{asset('/js/comment_modal.js')}}"></script>
    <script src="{{asset('/js/delete_modal.js')}}"></script>
    <script src="{{asset('/js/favorite.js')}}"></script>
    <script src="{{asset('/js/comment_ajax.js')}}"></script>
    <script src="{{asset('/js/map.js')}}"></script>
    <script src="{{ asset('/js/submit_disable.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACynbQFfINh_-6Yi-iRfaFAOrzU9ks6rY&callback=initMap"></script>
    <link rel="stylesheet" href="{{ asset('css/cycles_show.css') }}">
@endsection