<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cycle;

class Post_SearchesController extends Controller
{
    public function index(Request $request){
        //投稿を1ページにつき9件ずつ表示
        $query = Cycle::query()->orderBy('created_at', 'desc');
        $cycles = $query->paginate(9);
        if (\Auth::check()) {
            $searches = $request->input('search');
            // 検索ワード入力フォームで入力した文字列を含むカラムを取得
            if ($request->has('search') && $searches != '') {
                $cycles = $query->where('content', 'like', '%'.$searches.'%')->orWhere('area', 'like', '%'.$searches.'%')->orWhere('location', 'like', '%'.$searches.'%')->paginate(9);
            }   
            return view('post_searches.index',[
                'cycles' => $cycles
            ]);
        }
    }
}

