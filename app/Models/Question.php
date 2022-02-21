<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function Category(){
		// 投稿は1つのカテゴリーに属する
		return $this->belongsTo(Category::class,'category_id');
	}

    public function User(){
		// 投稿は1つのカテゴリーに属する
		return $this->belongsTo(User::class,'user_id');
	}

	public function Comments(){
		// 投稿は1つのカテゴリーに属する
		return $this->hasMany(Comment::class,'question_id','id');
	}


}
