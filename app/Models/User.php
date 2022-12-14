<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\Translation\Dumper\PoFileDumper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shops(){
        return $this->hasMany(Shop::class);
    }

    public function shopsCart(){
        return $this->belongsToMany(Shop::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function BoughtCart(){
        return $this->belongsToMany(Shop::class)
            ->withPivot('quantity', 'color', 'status')
            ->withTimestamps();
    }

    public function postswithStatus($status){
        return $this->belongsToMany(Shop::class)
            ->wherePivot('status', $status)
            ->withPivot('quantity', 'color', 'status')
            ->withTimestamps();
    }

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function RatedShop(){
        return $this->belongsToMany(Shop::class, 'rating')
            ->withPivot('rating')
            ->withTimestamps();
    }
}
