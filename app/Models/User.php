<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        // Sesuaikan logika ini berdasarkan bagaimana Anda menentukan seorang user adalah admin
        // Contoh: return $this->role === 'admin';
        // Atau: return $this->hasRole('admin');
        // Atau: return $this->is_admin === true;
        
        // Untuk sementara, kita gunakan contoh sederhana:
        return $this->email === 'admin@example.com'; // Ganti dengan email admin yang sesuai
    }

    public function clients()
    {
        // Definisikan relasi dengan client jika belum ada
        return $this->belongsToMany(Client::class);
    }

    public function token_for_client($client_id)
    {
        // Implementasi ini tergantung pada bagaimana Anda menyimpan token
        // Ini hanya contoh, sesuaikan dengan implementasi Anda
        return $this->tokens()->where('client_id', $client_id)->first()->token;
    }
}
