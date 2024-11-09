<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'media_type',
        'media_path',
        'media_public_id',
        'user_id'
    ];

    // Tambahkan field yang perlu di-cache
    protected $withCount = ['likes', 'comments'];

     // Relasi ke User (setiap post dimiliki oleh satu user)
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     // Relasi ke Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke Likes
   // app/Models/Post.php

public function likes()
{
    return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
}

    // Method untuk cek apakah user sudah like post ini
    public function isLikedBy(User $user)
{
    return $this->likes()->where('user_id', $user->id)->exists();
}

    // Method untuk toggle like
    public function toggleLike(User $user)
    {
        if ($this->isLikedBy($user)) {
            return $this->likes()->where('user_id', $user->id)->delete();
        }
        
        return $this->likes()->create(['user_id' => $user->id]);
    }
}
