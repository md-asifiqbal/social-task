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
        protected $appends = ['full_name'];


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


    public function getFullNameAttribute()
{
    return $this->first_name . ' ' . $this->last_name;
}

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

    //login user following check


    public function isFollowing($id)
    {
        return !! $this->personFollowers()->where('follower_id',$id)->count();
    }


   

    //many to  many relationship for followings between persion to page
    public function pageFollowings()
    {
        return $this->belongsToMany(Page::class)->withTimestamps();
    }


    //login user following check


    public function isPageFollowing($id)
    {
        return !! $this->pageFollowings()->where('page_id',$id)->count();
    }

    /**
     * Get all of the user's posts.
     */
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

     /**
     * Get all of the user's pages.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }


    /**
     * Get all feed of the users.
     */

    public function userfeed(){

        // get user ids of those who this user is following
        $following = $this->personFollowers->pluck('id')->toArray();

        // also append own posts
        $following[] = $this->id;

        //page follow
        $arr1=$this->pages->pluck('id')->toArray();

        $arr2=$this->pageFollowings->pluck('id')->toArray();

        $pageFollowings=array_merge($arr1,$arr2);
        

        // get posts 
        $posts = Post::with('postable')->where(function($q) use($following){
           $q->whereIn('postable_id', $following)->where('postable_type',"App\\Models\\User"); 
        })->orWhere(function($q)use($pageFollowings){
            if(!empty($pageFollowings) || isset($pageFollowings))
           $q->whereIn('postable_id', $pageFollowings)->where('postable_type',"App\\Models\\Page"); 
        })
            ->orderByDesc('id')
            ->get();


        return $posts;
    }

}
