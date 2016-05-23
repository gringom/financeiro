<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'year', 'description'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function by($id)
	{
		$this->user_id = $id;
	}
}
