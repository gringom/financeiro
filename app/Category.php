<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'type', 'description'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function by($id)
	{
		$this->user_id = $id;
	}
}
