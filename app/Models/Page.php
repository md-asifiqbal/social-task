<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_name',
        'user_id'
    ];

    /**
     * Get all of the page's posts.
     */
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }
}
