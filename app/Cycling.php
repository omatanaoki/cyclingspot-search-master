<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycling extends Model
{
    protected $fillable = ['parent_id', 'user_id', 'comment', 'cycle_id', 'time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}