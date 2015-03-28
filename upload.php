<?php

private function _import_csv($path, $filename)
{

$csv = $path . $filename; 

//ofcourse you have to modify that with proper table and field names
$query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE your_table FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\\n' IGNORE 1 LINES (`id`, `scenario`)", addslashes($csv));

return DB::connection()->getpdo()->exec($query);

}
