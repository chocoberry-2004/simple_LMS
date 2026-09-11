<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = ['user_id'];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
