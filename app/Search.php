<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

	protected $fillable = ['title', 'terms'];

	public function results()
	{
		return $this->hasMany('App\Result');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
