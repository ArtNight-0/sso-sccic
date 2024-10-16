<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logout_url'];

    public function activeUsers()
    {
        return $this->hasMany(User::class)->whereHas('sessions', function ($query) {
            $query->whereNotNull('user_id');
        });
    }
}
