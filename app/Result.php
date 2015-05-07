<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model {

	protected $fillable = ['message_id', 'message_user_id', 'message_screen_name', 'message_created_at', 'message_text', 'extra'];

	public function getDates()
	{
		return ['created_at', 'updated_at', 'message_created_at'];
	}

	public function search()
	{
		return $this->belongsTo('App\Search');
	}

	public function getExtraAttribute($value)
	{
		return json_decode($value, true);
	}

	public function setExtraAttribute($value)
	{
		$this->attributes['extra'] = json_encode($value);
	}

}
