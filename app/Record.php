<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['type', 'account_id', 'category_id', 'person_id', 'project_id', 'value', 'payment_date', 'paid_date', 'description'];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function person()
	{
		return $this->belongsTo(Person::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function by($id)
	{
		$this->user_id = $id;
	}
}
