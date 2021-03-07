<div id="lists" class="row">
    @if (count($cycles) > 0)
        <table class="table table-striped">
            @foreach ($cycles as $cycle)
                <div id="alert_card{{$cycle->id}}" class="col-sm-3 alert_card">
                    <div class="card" style="border:solid; border-width:thin; margin-bottom:10px;">
                        <div class="card-header" style="max-height: 70px; border-bottom:solid; border-width:thin;">
                            @if($cycle->user->image == null)
                                <a href="/users/{{$cycle->user->id}}"><img class="img-fluid float-left user-img" style="border-radius:50%; margin-bottom:10px; margin-right:10px;" src="{{ Gravatar::src($cycle->user->email) }}" width="35" height="35" alt=""></a>
                            @else
                                <a href="/users/{{$cycle->user->id}}"><img src="{{$cycle->user->image}}" class="img-fluid float-left user-img" style="border-radius:50%; margin-bottom:10px; margin-right:10px; width:35px; height:35px;"></a>
                            @endif
                            <div class="side">
                                <a href="/users/{{$cycle->user->id}}" class="user_name" style="color:black;">{{$cycle->user->name}}</a>
                                @if(Auth::id() == $cycle->user_id)
                                    <a href="#" class="nav-link" data-toggle="dropdown" style="color:black"><span class="fas fa-chevron-down"></span></a>
                                    <ul class="dropdown-menu" style="list-style: none;">
                                        <li class="dropdown-item">
                                            <a href="{{ route('cycle.edit', [$cycle->id]) }}"><span class="fa fa-edit" style="color:black;"></span></a>
                                            {!! link_to_route('cycle.edit', '編集', [$cycle->id], ['class' => 'btn btn-default']) !!}
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="#" type="button" data-toggle="modal" data-target="#cycle-delete{{$cycle->id}}"><span class="fa fa-trash delete-btn" style="color:black;"></span></a>
                                            <a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#cycle-delete{{$cycle->id}}">削除</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div style="font-size:x-small;">
                                <ul class="edit" style="text-align:right">
                                    <li>{{$cycle->time}}</li>
                                    <li>{{$cycle->edit}}</li>
                                </ul>
                            </div>
                        </div>
                        <a href="/cycles/{{$cycle->id}}"><img src="{{$cycle->image}}" style="width:100%; max-height:175px;"></a>
                        <div class="card-footer" style="border-top:solid; border-width:thin;">
                            <div class="title" style="text-align:left;">{{$cycle->title}}</div>
                            <div class="side">
                                <div style="font-size:small;">
                                    <div class="city_name">{{$cycle->area}}<span style="padding-left:8px;">{{$cycle->city}}</span></div>
                                    <ul class="icons">
                                        <li><span class="far fa-comment"></span></li>
                                        <li>{{count($cycle->cyclings)}}</li>
                                        <li>
                                            @include('favorites.favorite_button', ['cycle'=>$cycle])
                                        </li>
                                        <li id="favorite_count{{$cycle->id}}">{{count($cycle->favorited)}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--ボタン・リンククリック後に表示される画面の内容 -->
                <div class="modal fade" id="cycle-delete{{$cycle->id}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4><class="modal-title">投稿削除確認画面</h4>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span></button>
                            </div>
                            <div class="modal-body">
                                <label>本当に削除しますか？（この操作は取り消しできません。）</label>
                            </div>
                            <div class="modal-footer">
                                {!! Form::model($cycle, ['route' => ['cycles.destroy', $cycle->id], 'method' => 'delete']) !!}
                                    <input class="btn btn-danger" type="submit" value="削除">
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </table>
    @endif
    {{ $cycles->links('pagination::bootstrap-4') }}
</div>
<script src="{{asset('/js/cycles_response.js')}}"></script>
<link rel="stylesheet" href="{{asset('/css/cycles_cycles.css')}}">
            
            
      