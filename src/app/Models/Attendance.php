<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_time', 'end_time','rest_time','total'];

  public static $rules = array(
    'name' => 'required',
    'start_time' => 'required',
    'end_time' => 'required',
    'rest_time' => 'required',
    'total' => 'required'
  );
  public function getDetail()
  {
    $txt = $this->name . $this->start_time . $this->end_time . $this->rest_time . $this->total;
    return $txt;
  }
  public function user()
  {
    return $this->hasOne('App\Models\User');
  }
  public function users()
  {
    return $this->hasMany('App\Models\User');
  }
}
