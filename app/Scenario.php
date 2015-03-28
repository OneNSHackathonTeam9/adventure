<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model {

	protected $table = 'scenarios';

	public function answers() {
		return $this->belongsToMany('App\Answer', 'scenario_answers', 'scenario', 'answer');
	}

}
