<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "post_id", "content"];
    
    protected static function newFactory(): CommentFactory
    {
        //return CommentFactory::new();
    }
}
