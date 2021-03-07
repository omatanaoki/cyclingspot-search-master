<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cycling;
use App\Cycle;
use App\User;
use DB;
use App\Http\Requests\StoreCyclecomment;


class CyclecommentsController extends Controller
{
    public function ajax(Request $request){
        //$cyclecommentにクリックしたコメントのデータを入れる。
        $cyclecomment = Cyclecomment::find($request->id);
        $user = User::find($cyclecomment->user_id);
        
        //クリックしたコメントに親コメントがなければ
        if($cyclecomment->parent_id == null){
            //クリックしたコメントに子コメントがあれば
            if(Alertcomment::where('parent_id', $request->id)->exists()){
                //$undercommentにクリックしたコメントの子コメントのデータを入れる。
                $undercomments = Cyclecomment::join('users', 'users.id', '=', 'cyclecomments.user_id')->where('parent_id' , $request->id)->orderBy('cyclecomments.created_at', 'asc')->get();
                
                return response()->json([
                    'responseData' => $cyclecomment,
                    'userData' => $user,
                    'underDatas' => $undercomments,
                    'upData' => '',
                    'upuserData' => '',
                ]);
            
            //クリックしたコメントに子コメントがなければ
            }else{
                return response()->json([
                    'responseData' => $cyclecomment,
                    'userData' => $user,
                    'underDatas' => '',
                    'upData' => '',
                    'upuserData' => '',
                ]);
            }
        
        //クリックしたコメントに親コメントがあれば    
        }else{
            //クリックしたコメントに子コメントがあれば
            if(Cyclecomment::where('parent_id', $request->id)->exists()){
                
                //$upcommentにクリックしたコメントの親コメントのデータを入れる。
                $upcomment = Cyclecomment::find(optional($cyclecomment)->parent_id);
                $upuser = User::find(optional($upcomment)->user_id);
                $undercomments = Cyclecomment::join('users', 'users.id', '=', 'cyclecomments.user_id')->where('parent_id' , $request->id)->orderBy('cyclecomments.created_at', 'asc')->get();
                return response()->json([
                    'responseData' => $cyclecomment,
                    'userData' => $user,
                    'underDatas' => $undercomments,
                    'upData' => $upcomment,
                    'upuserData' => $upuser,
                ]);
            //クリックしたコメントに子コメントがなければ 
            }else{
                $upcomment = Cyclecomment::find(optional($cyclecomment)->parent_id);
                $upuser = User::find(optional($upcomment)->user_id);
                
                return response()->json([
                    'responseData' => $cyclecomment,
                    'userData' => $user,
                    'underDatas' => '',
                    'upData' => $upcomment,
                    'upuserData' => $upuser,
                ]);
            }
        }
    }    

    public function ajaxindex($id)
    {
         // id順に取得
        $cyclecomments = DB::table('cyclecomments')->select('cyclecomments.id','cyclecomments.cycle_id','users.id as users.userId','users.email','cyclecomments.parent_id','cyclecomments.time','users.name','users.image','cyclecomments.comment','cyclecomments.user_id')->where('cycle_id', $id)->join('users','cyclecomments.user_id', '=', 'users.id')->orderBy('cyclecomments.created_at', 'desc')->get();
        $AuthId = Auth::id();
       
        return response()->json([
            "status" => "success",
            "message" => "成功",
            "comments" => $cyclecomments,
            "AuthId" => $AuthId,
           
        ]);
    }
    
    public function ajaxstore(StoreCyclecomment $request)
    {
            if($request->parent_id == null){
                $params = $request->validate([
                    'cycle_id' => 'required|exists:cycle,id',
                    'comment' => 'required|max:140',
                ]);
            }
            else{
                 $params = $request->validate([
                    'cycle_id' => 'required|exists:cycles,id',
                    'parent_id' => 'required|exists:cyclecomments,id',
                    'comment' => 'required|max:140',
                ]);
            }
            
            //時間のセット
            date_default_timezone_set('Asia/Tokyo');
            $now = date("Y/m/d H:i");
            
            $request->user()->cyclecomments()->create([
                'comment' => $request->comment,
                'cycle_id' => $request->cycle_id,
                'parent_id' => $request->parent_id,
                'time' => $now,
            ]);
            return redirect("/ajax/{$request->cycle_id}");
    }
    
    // deleteでalerts/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $cyclecomment = Cyclecomment::find($id);
        if (\Auth::id() === $cyclecomment->user_id) {
            $cyclecomment->delete();
        }
        return back();
    }
}