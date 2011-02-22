<?php
function getUnlock($id)
{
	$lines  = file(getcwd()."/queries/unlock-id.list");
	return trim($lines[$id]);
}

function getUnlockID($id)
{
	$lines  = file(getcwd()."/queries/unlock-id.list");
	foreach ($lines as $key => $value)
	{
		if ($value == $id)
		return $key;
	}
}

function getUnlockCount()
{
	$lines  = file(getcwd()."/queries/unlock-id.list");
	return count($lines);	
}

?>