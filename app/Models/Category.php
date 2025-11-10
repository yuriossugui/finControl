<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'type',
        'color',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
