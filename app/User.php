<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image','current_password', 'introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'password', 'remember_token','current_password',
    ];
    
    public function cycles()
    {
        return $this->hasMany(Cycle::class);
    }
    
    
    public function cyclings()
    {
        return $this->hasMany(Cycling::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Cycle::class, 'favorites', 'user_id', 'cycle_id')->withTimestamps();
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
            $this->favorites()->attach($cycleId);
            return true;
        }
    }
    
    public function unfavorite($cycleId)
    {
        // 既にいいねしているかの確認
        $exist = $this->is_favorite($cycleId);
      
        if ($exist) {
            // 既にいいねしていればいいねを外す
            $this->favorites()->detach($cycleId);
            return true;
        } else {
            // 未いいねであれば何もしない
            return false;
        }
    }
    
    public function is_favorite($cycleId)
    {
        return $this->favorites()->where('cycle_id', $cycleId)->exists();
    }
}
