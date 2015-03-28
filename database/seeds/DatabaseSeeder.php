<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');
		$this->_import_csv('/home/apple/Downloads/', 'Lemonade Stand Story - scenarios.csv', 'scenarios');
		$this->_import_csv('/home/apple/Downloads/', 'Lemonade Stand Story - answers.csv', 'answers');
		$this->_import_csv('/home/apple/Downloads/', 'Lemonade Stand Story - scenario_answers.csv', 'scenario_answers');
	}

	private function _import_csv($path, $filename, $table)
	{

	DB::table($table)->delete();

	$csv = $path . $filename;

	$file = fopen($csv,"r");
	  $line = fgetcsv($file);
	$head = [];
	foreach($line as $key) {
	$head[] = $key;
	}
	while(! feof($file))
	  {
	  $line = fgetcsv($file);
		$ins = [];
		for($i=0;$i<count($line);$i++) {
			$ins[$head[$i]] = $line[$i];
		}
		print_r($ins);
		DB::table($table)->insert($ins);
	  }
	fclose($file);

	}

}
