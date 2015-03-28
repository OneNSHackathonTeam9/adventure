<?php namespace App\Http\Controllers;

use Session;
use Input;
use Flash;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Scenario;
use App\Answer;

use Illuminate\Http\Request;

class StoryController extends Controller {
	
	public $stories = ['lemonstand'=>'Lemon Stand'];

	public function show($name) {

		$current = Session::get('current', 2);

		return view(
			'story', 
			[ 
				'name' => $this->stories[$name],
				'scenario' => Scenario::find($current),
			]
		);	
	}
	
	public function process($name) {

		$current = Session::get('current', 2);
		$process = Input::get('scenario');

		$processed = DB::table('user_story')
			->where('scenario', '=', $process)->count() > 0;

		if($current != $process) {
			Flash::error('Try answering this question again.' . $current . $process);
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

		// Go to next question
		Session::set('current', $answer->next_scenario);

		return $this->show($name);

	}

	public function restart($name) {
		Session::set('current', 2);
		DB::table('user_story')
			->where('user', '=', Auth::user()->id)
			->delete();
		return redirect(action('StoryController@show', [$name]));
	}

}
