<?php namespace App;

use DB;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function user_story() {
		//
	}

	public static function current() {
		$story_id = 2;
		while(!is_null($story_id)) {
			$curr = DB::table('user_story')
				->where('user', '=', Auth::user()->id)
				->where('scenario', '=', $story_id)
				->first();
			if(is_null($curr) || !is_object($curr))
				break;
			$story_id = Answer::find($curr->answer)->next_scenario;
		}
		return Scenario::find($story_id);
	}
	public static function put($key, $value) {
		if(DB::table('user_variables')
			->where('key', '=', $key)
			->where('user', '=', Auth::user()->id)->count() > 0) {
				DB::table('user_variables')
					->where('key', '=', $key)
					->where('user', '=', Auth::user()->id)
					->update([ 'value' => $value ]);
		} else {
			DB::table('user_variables')
				->insert([
					'key' => $key,
					'value' => $value,
					'user' => Auth::user()->id
			]);
		}
	}
	public static function get($key) {
		return DB::table('user_variables')
			->where('key', '=', $key)
			->where('user', '=', Auth::user()->id)
			->first();
	}
	public static function purge() {
		DB::table('user_variables')
			->where('user', '=', Auth::user()->id)
			->delete();
	}

}
