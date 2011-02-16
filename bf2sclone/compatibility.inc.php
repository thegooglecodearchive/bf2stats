<?php

function file_put_contents($n,$d) {
  $f=@fopen($n,"w");
  if (!$f) {
   return false;
  } else {
   fwrite($f,$d);
   fclose($f);
   return true;
  }
}
/*
function file_get_contents($filename) {
       $fp = fopen($filename, "rb");
       $buffer = fread($fp, filesize($filename));
       fclose($fp);
       //$lines = preg_split("/\r?\n|\r/", $buffer);
       return $lines;
}
*/

?>