<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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

    //many to  many relationship for followers between persion to person
    public function personFollowers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    //many to  many relationship for followings between persion to person
    public function persionFollowings()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }


   

    //many to  many relationship for followings between persion to page
    public function pageFollowings()
    {
        return $this->belongsToMany(Page::class)->withTimestamps();
    }

    /**
     * Get all of the user's posts.
     */
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }


    /**
     * Get all feed of the users.
     */

    public function userfeed(){

        // get user ids of those who this user is following
        $following = $this->personFollowers->pluck('id')->toArray();

        // also append own posts
        $following[] = $this->id;


        // get posts 
        $posts = Post::where(function($q) use($following){
           $q->whereIn('postable_id', $following)->where('postable_type',"App\\Models\\User"); 
        })->orWhere(function($q)use($following){
           $q->whereIn('postable_id', $following)->where('postable_type',"App\\Models\\Page"); 
        })
            ->orderByDesc('id')
            ->get();


        return $posts;
    }

}
