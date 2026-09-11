<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'description',
        'cover_image',
        'book_file',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function isAvailable()
    {
        return $this->borrowings()->whereNull('returned_at')->doesntExist();
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }


    public function canBeReadBy(User $user): bool
    {
        if (in_array($user->role, ['admin', 'librarian'])) {
            return true;
        }

        return $this->borrowings()
            ->whereHas('member', fn ($query) =>
                $query->where('user_id', $user->id)
            )
            ->whereNull('returned_at')
            ->whereDate('borrowed_at', '<=', today())
            ->whereDate('due_date', '>=', today())
            ->whereHas('payments', fn ($query) => $query->where('status', 'completed'))
            ->exists();
    }
}
