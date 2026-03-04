<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Menentukan nama tabel secara spesifik
     * (Mencegah Laravel mencari tabel default 'users')
     */
    protected $table = 'user';

    /**
     * Nonaktifkan timestamps jika tabel Anda tidak memiliki
     * kolom 'created_at' dan 'updated_at'.
     * (Hapus tanda // di bawah ini jika error timestamps muncul)
     */
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'level',
        'status',
        'nama_satker',
        'id_opd',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            // 'email_verified_at' => 'datetime', // Dikomentari jika tidak ada fitur verifikasi email
            'password' => 'hashed',
        ];
    }
}