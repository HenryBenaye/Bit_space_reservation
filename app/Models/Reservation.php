<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'space_id' ,
        'begin_time' ,
        'end_time',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function space()
    {
        return $this->belongsTo(Space::class);
    }
}
