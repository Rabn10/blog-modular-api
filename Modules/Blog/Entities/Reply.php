<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'user_id', 'reply', 'delete_flag'];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\ReplyFactory::new();
    }
}