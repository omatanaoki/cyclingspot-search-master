<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
   protected $fillable = ['content', 'user_id', 'area', 'city', 'location', 'time', 'image', 'title', 'lat', 'lng', 'edit'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function cyclings()
    {
        return $this->hasMany(Cycling::class);
    }
    
    
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites', 'cycle_id', 'user_id')->withTimestamps();
    }
    
    public function favorite($cycleId)
    {
        // 既にいいねしているかの確認
        $exist = $this->is_favorite($cycleId);
    
        if ($exist) {
            // 既にいいねしていれば何もしない
            return false;
        } else {
            // 未いいねであればいいねする
            $this->favorited()->attach($cycleId);
            return true;
        }
    }
    
    public function unfavorite($cycleId)
    {
        // 既にいいねしているかの確認
        $exist = $this->is_favorite($cycleId);
      
        if ($exist) {
            // 既にいいねしていればいいねを外す
            $this->favorited()->detach($cycleId);
            return true;
        } else {
            // 未いいねであれば何もしない
            return false;
        }
    }
    
    public function is_favorite($cycleId)
    {
        return $this->favorited()->where('cycle_id', $cycleId)->exists();
    }
}

