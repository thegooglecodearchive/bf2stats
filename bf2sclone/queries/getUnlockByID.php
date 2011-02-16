<?php
function getUnlockByID($id)
{
	$lines  = file(getcwd()."/queries/unlocks.list");
	return $lines [$id];
}

?>