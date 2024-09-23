<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Working_History extends Model
{
    use HasFactory;

    protected $fillable = [
       'name',
       'start_time',
       'end_time',
       'rest_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
