<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	use HasFactory;

	protected $fillable = [
        'title', 'content', 'user_id','category_id','image','video'
    ];

    public function Category(){
		// 投稿は1つのカテゴリーに属する
		return $this->belongsTo(Category::class,'category_id');
	}

    public function User(){
		// 投稿は一人のユーザーに属する
		return $this->belongsTo(User::class,'user_id');
	}

	public function Answers(){
		// 投稿はたくさんの回答を持つ
		return $this->hasMany(Answer::class,'question_id','id');
	}


}
