<?php namespace App\Http\Controllers;

use Session;
use Validator;
use Input;
use Flash;
use DB;
use Auth;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Scenario;
use App\User;
use App\Answer;

//use Illuminate\Http\Request;

class StoryController extends Controller {
	
	public $stories = ['lemonstand'=>'Lemon Stand'];
	public $dependency = [ 
		15 => 1,
		16 => 1,
		17 => 2,
		18 => 2,
		19 => 9,
		20 => 10,
		21 => 9,
		22 => 10,
		23 => 9,
		24 => 10,
		25 => 9,
		26 => 10,
		];
	public $positions = [27, 29, 31, 33];
	public $not_positions = [28, 30, 32, 34];

	private function contains($answer) {
		return DB::table('user_story')
			->where('user', '=', Auth::user()->id)
			->where('answer', '=', $answer)
			->count() > 0;
	}
	private function positions_correct() {
		return (($this->contains(3) && $this->contains(11) && ($this->contains(15) || $this->contains(17))) || ($this->contains(4) && $this->contains(12) && ($this->contains(16) || $this->contains(18))));
	}

	public function show($name) {

		$current = Session::get('current', 2);

		// Filter answers
		$scenario = Scenario::find($current);
		$answers = [];
		foreach($scenario->answers as $answer) {
			if(array_key_exists($answer->id, $this->dependency)) {
				if($this->contains($this->dependency[$answer->id]))
					$answers[] = $answer;
			} else if(in_array($answer->id, $this->positions)){
				if($this->positions_correct())
					$answers[] = $answer;
			} else if(in_array($answer->id, $this->not_positions)){
				if(!$this->positions_correct())
					$answers[] = $answer;
			} else {
				$answers[] = $answer;
			}
		}
		
		$vars = DB::table('user_variables')
				->where('user', '=', Auth::user()->id)
				->get();
		foreach($vars as $var) {
			foreach($answers as $answer) {
				$answer->answer = str_replace('$' . $var->key, $var->value, $answer->answer);
			}
			$scenario->scenario= str_replace('$' . $var->key, $var->value, $scenario->scenario);
		}

		$done = count($answers) == 0;

		return view(
			'story', 
			[ 
				'name' => $this->stories[$name],
				'scenario' => $scenario->scenario,
				'id' => $scenario->id,
				'answers' => $answers,
				'done' => $done,
			]
		);	
	}
	
	public function process($name) {

		$current = Session::get('current', 2);
		$process = Input::get('scenario');

		$processed = DB::table('user_story')
			->where('scenario', '=', $process)->count() > 0;

		if($current != $process) {
			Flash::error('Try answering this question again.');
			return redirect(action('StoryController@show', [$name]));
		} else if($processed) {
			Flash::error('You already answered this question.');
			return redirect(action('StoryController@show', [$name]));
		}

		$answer = Answer::find(Input::get('answer'));

		// Register answer
		DB::table('user_story')
			->insert([
				'user' => Auth::user()->id,
				'scenario' => $current,
				'answer' => $answer->id,
			]);

		// Register variables
		switch($answer->id) {
			case 3:
				User::put('Person1', 'Jenny');
				break;
			case 4:
				User::put('Person1', 'Glenn');
				break;
			case 11:
				User::put('Person2', 'Andrew');
				break;
			case 12:
				User::put('Person2', 'Sarah');
				break;
		}

		// Go to next question
		Session::set('current', $answer->next_scenario);

		return $this->show($name);

	}

	public function restart($name) {
		Session::forget('current');
		DB::table('user_story')
			->where('user', '=', Auth::user()->id)
			->delete();
		User::purge();
		return redirect(action('StoryController@first', [$name]));
	}
	public function current($name) {
		return User::current();
	}

	public function first($name) {
		return view(
			'first',
			[
				'name' => $this->stories[$name],
			]);
	}

	public function first_process($name) {

		$v = Validator::make(Input::all(), [
			'business' => 'required|alpha',
		]);
		if($v->fails()) {
			Flash::error($v->messages()->first('business'));
			return view(
				'first',
				[
					'name' => $this->stories[$name],
				]);
		}

		$business= Input::get('business');

		User::put('businessname', $business);
		
		return redirect(action('StoryController@show', [$name]));
	}
	
}
