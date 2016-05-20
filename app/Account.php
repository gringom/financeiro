<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['title', 'description'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function by($id)
	{
		$this->user_id = $id;
	}
}
