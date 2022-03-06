<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'question_id', 'answer'
    ];

    public function User(){
		// 回答は一人のユーザーに属する
		return $this->belongsTo(User::class,'user_id');
	}
}
