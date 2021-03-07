<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cycle;
use App\Cycling;
use Storage;
use App\Http\Requests\StoreCycle;
use App\User;

class CyclesController extends Controller
{
    // getでalerts/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $cycles = Cycle::orderBy('created_at', 'desc')->paginate(9);
            
            $data = [
                'user' => $user,
                'cycles' => $cycles,
            ];
        }
        return view('cycles.index', $data);
    }
   
   // getでalerts/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $cycle = new Cycle;

        return view('cycles.create', [
            'cycle' => $cycle,
        ]);
    }
     
    // postでalerts/にアクセスされた場合の「新規登録処理」
    public function store(StoreCycle $request)
    {
        //画像ファイル受け取り処理
        $filename='';
        $url='';
        if ($request->file('thefile')->isValid()) {
            $filename = $request->file('thefile')->store('img');
            //s3アップロード開始
            $image = $request->file('thefile');
            // バケットの`pogtor528`フォルダへアップロード
            $path = Storage::disk('s3')->putFile('pogtor528', $image, 'public');
            // アップロードした画像のフルパスを取得
            $url = Storage::disk('s3')->url($path);
        }
        
        //時間のセット
        date_default_timezone_set('Asia/Tokyo');
        $now = date("Y/m/d H:i");
       
            $request->user()->cycles()->create([
                'content' => $request->content,
                'title' => $request->title,
                'area' => $request->area,
                'city' => $request->city,
                'location' => $request->location,
                'time' => $now,
                'image' => $url,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);
            return redirect('/cycles');
    }
    
    
   // getでalerts/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $cycle = Cycle::find($id);
        $user = \Auth::user();
        $cyclecomments = Cyclecomment::where('cycle_id', $id)->orderBy('created_at', 'desc')->get();
        
        $data = [
            'cycle' => $cycle,
            'user' => $user,
            'cyclecomments' => $cyclecomments,
        ];

        return view('cycles.show', $data);
    }
    
    public function update(StoreCycle $request, $id)
    {
        //画像ファイル受け取り処理
        $filename='';
        $url='';
        if ($request->file('thefile')->isValid()) {
            $filename = $request->file('thefile')->store('img');
            
            //s3アップロード開始
            $image = $request->file('thefile');
            // バケットの`pogtor528`フォルダへアップロード
            $path = Storage::disk('s3')->putFile('pogtor528', $image, 'public');
            // アップロードした画像のフルパスを取得
            $url = Storage::disk('s3')->url($path);
        }
        
        //時間のセット
        date_default_timezone_set('Asia/Tokyo');
        $now = date("Y/m/d H:i");

        $cycle = Cycle::find($id);
        
        $cycle->content = $request->content;
        $cycle->title = $request->title;
        $cycle->area = $request->area;
        $cycle->city = $request->city;
        $cycle->location = $request->location;
        $cycle->time = $now;
        $cycle->image = $url;
        $cycle->lat = $request->lat;
        $cycle->lng = $request->lng;
        $cycle->edit = $request->edit;
        
        $cycle->save();
        
        return redirect('/cycles');
    }
    
    // getでalerts/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        $cycle = Cycle::find($id);

        return view('cycles.edit', [
            'cycle' => $cycle,
        ]);
    }
    
    // deleteでalerts/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $cycle = \App\Cycle::find($id);
        if (\Auth::id() === $cycle->user_id) {
            $cycle->delete();
        }
            return back();
    }
}
