<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class   Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'space_id' ,
        'begin_time' ,
        'end_time',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function space()
    {
        return $this->belongsTo(Space::class);
    }
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeTime($query)
    {
        $query
            ->where('user_id', Auth::user()->id)
            ->where('begin_time', '>=',
                Carbon::create(0, 0, 0,
                    request()->begin_time_hour,
                    request()->begin_time_minute)
                ->format('H:i'))
            ->where('end_time', '<=',
                Carbon::create(0, 0, 0,
                request()->end_time_hour,
                request()->end_time_minute)
                    ->format('H:i'));
    }
    public function scopeSpaceCheck($query)
    {
        $space = Space::where('name',
            request()->space_name)
            ->first();
        $query
            ->where('end_time', '>=',
                Carbon::create(0, 0, 0,
                    request()->end_time_hour,
                    request()->end_time_minute)
                ->format('H:i'))
            ->where('space_id', '=',$space->id);

    }
}
