<?php
/****************************************************************************/
/*  						   < BF2s Clone >  								*/
/*              		  Original Author:   <Lumo>                    		*/
/*              	Fixes and Updates by:   <Wilson212>                    	*/
/****************************************************************************/

/***************************************************************
 * LOAD THE CONFIG AND DEFINE RANK REFRESH TIME
 ***************************************************************/
include_once('config.inc.php');
define('RANKING_REFRESH_TIME', 600); // -> 10 minutes

// === ! Process a start time ! === //
$time_start = microtime(true);

/***************************************************************
 * REDIRECT TO INSTALLER IF NOT INSTALLED
 ***************************************************************/
if($DOMAIN == "default")
{
	header("Location: install.php"); // refresh for cookie
	exit();
}


/***************************************************************
 * LOAD COMPATIBILITY FOR PHP 4 IF NEEDED
 ***************************************************************/
if(substr(phpversion(),0,1) != 5)
{
	include_once('compatibility.inc.php');
}


/***************************************************************
 * GET POSTS AND URLs FOR FUTURE REFERENCE
 ***************************************************************/
$PID = isset($_GET["pid"]) ? $_GET["pid"] : "0";
$GO = isset($_GET["go"]) ? $_GET["go"] : "0";
$LEADERBOARD = isset($_POST["leaderboard"]) ? $_POST["leaderboard"] : "0";
$GET = isset($_POST["get"]) ? $_POST["get"] : 0;
$SET = isset($_POST["set"]) ? $_POST["set"] : 0;
$ADD = isset($_GET["add"]) ? $_GET["add"] : 0;
$REMOVE = isset($_GET["remove"]) ? $_GET["remove"] : 0;

// If my leaderboard was saved, then set will be true
if($SET)
{
	setcookie("leaderboard", $LEADERBOARD, time() + 315360000, '/', $DOMAIN); // delete after 10 years ;)
	#NOTE: after setting a cookie, you must redirect!
	header("Location: ".$ROOT."?go=my-leaderboard"); // refresh for cookie
	exit();
}

// Loads a My-Leaderboard cookie
if($GET)
{
	// output the nice save-url
	header("Location: ".$ROOT.'?go=my-leaderboard&pid='.urlencode($LEADERBOARD));
	exit();
}


/***************************************************************
 * ESTABLISH DATABASE CONNECTION AND DATA MANAGMENT
 ***************************************************************/
include_once('./datamanagement.inc.php');

$link = mysql_connect($DBIP, $DBLOGIN, $DBPASSWORD) or die('Could not connect: ' . mysql_error());
mysql_select_db($DBNAME) or die('Could not select database');


/***************************************************************
 * PLAYERSTATS
 ***************************************************************/
if($GO == "0" && $PID)
{	
	$player = getPlayerDataFromPID($PID); // receive player data
	$victims = getFavouriteVictims($PID); // receive victim data
	$enemies = getFavouriteEnemies($PID); // receive enemie data
	$armies = getArmyData($PID); // receive army data
	$armySummary = getArmySummaries($armies); // retrieve Army summary
	$unlocks = getUnlocksByPID($PID);	// retrieve unlock data
	$vehicles = getVehicleData($PID);	// retrieve vehivle data
	$vehicleSummary = getVehicleSummaries($vehicles); // retrieve Vehicle summary
	$weapons = getWeaponData($PID, $player); // retrieve Weapon data
	$weaponSummary = getWeaponSummary($weapons, $player); // retrieve weapon summary
	$equipmentSummary = getEquipmentSummary($weapons, $player); // retrieve equipment summary
	$kits = getKitData($PID); // retrieve kit data
	$kitSummary = getKitSummary($kits, $player); // retrieve kits summary
	$maps = getMapData($PID);
	$mapSummary = getMapSummary($maps);
	$playerSummary = getPlayerSummary($player, $weapons, $vehicles, $kits, $armies, $maps); // get player summary
	$PlayerAwards  = getAwardsByPID($PID);
	$TheaterData = getTheaterData($PID);  // retrueve Theater Data
	
	#$awards = getAwardsByPID($PID); // get earned awards
	if(isCached($PID))// already cached!
	{
		$template = getCache($PID);
		$LASTUPDATE = intToTime(getLastUpdate(getcwd().'/cache/'.$PID.'.cache'));
		$NEXTUPDATE = intToTime(getNextUpdate(getcwd().'/cache/'.$PID.'.cache', RANKING_REFRESH_TIME));
		$template = str_replace('{:LASTUPDATE:}', $LASTUPDATE, $template);
		$template = str_replace('{:NEXTUPDATE:}', $NEXTUPDATE, $template);
		#echo $template;
	}
	else
	{
		include_once('./template/playerstats.php');
		// write cache file
		writeCache($PID, $template);
		$LASTUPDATE = intToTime(0);
		$NEXTUPDATE = intToTime(RANKING_REFRESH_TIME);		
		$template = str_replace('{:LASTUPDATE:}', $LASTUPDATE, $template);
		$template = str_replace('{:NEXTUPDATE:}', $NEXTUPDATE, $template);		
		#echo $template;
	}
}

/***************************************************************
 * CURRENT RANKINGS
 ***************************************************************/
elseif(strcasecmp($GO, 'currentranking') == 0)
{
	$rankings = getRankingCollection();
	$LASTUPDATE = 0;
	$NEXTUPDATE = 0;
	if(isCached('current-ranking'))// already cached!
	{
		$template = getCache('current-ranking');
		$LASTUPDATE = intToTime(getLastUpdate(getcwd().'/cache/current-ranking.cache'));
		$NEXTUPDATE = intToTime(getNextUpdate(getcwd().'/cache/current-ranking.cache', RANKING_REFRESH_TIME));
	}
	else
	{
		include_once('./template/current-ranking.php');
		// write cache file
		writeCache('current-ranking', $template);
		$LASTUPDATE = intToTime(0);
		$NEXTUPDATE = intToTime(RANKING_REFRESH_TIME);		
	}	
	$template = str_replace('{:LASTUPDATE:}', $LASTUPDATE, $template);
	$template = str_replace('{:NEXTUPDATE:}', $NEXTUPDATE, $template);		
	#echo $template;	
}

/***************************************************************
 * MY LEADER BOARD
 ***************************************************************/
elseif((strcasecmp($GO, 'my-leaderboard') == 0))
{
	#print_r($_COOKIE);
	#echo $_COOKIE["leaderboard"];
	
	if($ADD > 0)
	{
		if ($_COOKIE['leaderboard'] != '')
		{
			$LEADERBOARD = $_COOKIE['leaderboard'].','.$ADD;
		}
		else
		{
			$LEADERBOARD = $ADD;
		}
		setcookie("leaderboard", $LEADERBOARD, time()+315360000, '/', $DOMAIN); // delete after 10 years ;)
		#NOTE: after setting a cookie, you must redirect!
		header("Location: ".$ROOT."?go=my-leaderboard"); // refresh for cookie
		exit();
	}
	elseif($REMOVE > 0)
	{
		$LEADERBOARD = explode(',', $_COOKIE['leaderboard']); // get array
		
		// delete "remove"
		foreach($LEADERBOARD as $i => $value) 
		{
			if($value == $REMOVE)
			{
				unset($LEADERBOARD[$i]);
			}
		}
		$LEADERBOARD = implode(',', $LEADERBOARD); // back to string ;)

		setcookie("leaderboard", $LEADERBOARD, time()+315360000, '/', $DOMAIN); // delete after 10 years ;)
		#NOTE: after setting a cookie, you must redirect!
		header("Location: ".$ROOT."?go=my-leaderboard"); // refresh for cookie
		exit();
	}
	# nothing todo -> load from cookie
	$LEADERBOARD = isset($_COOKIE['leaderboard']) ? $_COOKIE['leaderboard'] : '';
	
	if($PID != 0) // a saved leaderboard
	{
		$LEADER = getLeaderBoardEntries(urldecode($PID)); # query from database
	}
	else
	{
		$LEADER = getLeaderBoardEntries($LEADERBOARD); # query from database
	}

	#if ($LEADERBOARD==0) $LEADERBOARD = '';
	include_once('./template/my-leaderboard.php');
	#echo $template;
}

/***************************************************************
 * SEARCH FOR PLAYERS
 ***************************************************************/
elseif(strcasecmp($GO, 'search') == 0)
{
	$SEARCHVALUE = isset($_POST["searchvalue"]) ? $_POST["searchvalue"] : "0";
	if($SEARCHVALUE){ $searchresults = getSearchResults($SEARCHVALUE); }
	include_once('./template/search.php');
	#echo $template;
}

/***************************************************************
 * SHOW TOP TEN - default
 ***************************************************************/
else
{  // show the top ten

	$LASTUPDATE = 0;
	$NEXTUPDATE = 0;
	if(isCached('home'))// already cached!
	{
		$template = getCache('home');
		$LASTUPDATE = intToTime(getLastUpdate(getcwd().'/cache/home.cache'));
		$NEXTUPDATE = intToTime(getNextUpdate(getcwd().'/cache/home.cache', RANKING_REFRESH_TIME));
	}
	else
	{
		$topten = getTopTen();
		include_once('./template/home.php');
		// write cache file
		writeCache('home', $template);
		$LASTUPDATE = intToTime(0);
		$NEXTUPDATE = intToTime(RANKING_REFRESH_TIME);		
	}	
	$template = str_replace('{:LASTUPDATE:}', $LASTUPDATE, $template);
	$template = str_replace('{:NEXTUPDATE:}', $NEXTUPDATE, $template);		
	
}

/***************************************************************
 * CLOSE DATABASE CONNECTION AND PROCESS PAGE LOAD TIME
 ***************************************************************/
mysql_close($link);

//processing page END
$time_end = microtime(true);
$time = round($time_end - $time_start,4);
$template = str_replace('{:PROCESSED:}', $time, $template);

/***************************************************************
 * ECHO THE PAGE :)
 ***************************************************************/		
echo $template;	
?>