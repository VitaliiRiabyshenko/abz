<?php

namespace App\Models;

use App\Observers\UserObserver;
use App\Models\Traits\Paginationable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, Paginationable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_id',
        'image'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
