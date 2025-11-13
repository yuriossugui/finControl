<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;

    protected $table = 'goals';

    protected $fillable = [
        'category_id',
        'target_value',
        'current_value',
        'month',
        'year'
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
    ];

    public function getProgressAttribute()
    {
        if ($this->target_value == 0) {
            return 0;
        }
        return ($this->current_value / $this->target_value) * 100;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
