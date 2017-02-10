<?php

$db_name = "test";
$db_user = "root";
$db_pw = "";
$db_host = "localhost";

$db = mysqli_connect($db_host, $db_user, $db_pw, $db_name);

$folder = ucfirst($db_name)."Models";

if(!file_exists($folder)) {
    mkdir($folder);
}

$result = $db->query("SHOW TABLES");
$tables = mysqli_fetch_all($result);
foreach($tables as $table) {
  $table = $table[0];
  $controller = fopen($folder."/".ucfirst($table).".php", "w") or die("Unable to open file!");
  $modelName = ucfirst($table);
  $resp = $db->query("select column_name from information_schema.columns where table_schema = '$db_name' and table_name = '$table' order by table_name,ordinal_position");
  $array = mysqli_fetch_all($resp);
  $fillables = array();
  $primary = $array[0][0];
  foreach($array as $a) {
    $fillables[] = "'".$a[0]."'";
  }
  $text = '<?php
namespace App\$folder;

use Illuminate\Database\Eloquent\Model;

class '.$modelName.' extends Model {
  protected $table = "'.$table.'";
  
  protected $primaryKey = "'.$primary.'";

  protected $fillable = array('.implode(",",$fillables).');

  public $timestamps = false;
}
';
  fwrite($controller, $text);
  fclose($controller);
}
echo "Now you have all your models created, enjoy!";

?>
