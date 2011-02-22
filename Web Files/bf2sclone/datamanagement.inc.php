<?php
/* IMPLEMENTED FUNCTIONS */
include_once('./functions.inc.php');

/* PLAYER STATS SQL FUNCTIONS*/
include_once('./playerstats.inc.php');
include_once('./awards.inc.php');
include_once('./expansions.inc.php');

/* RANKING STATS SQL FUNCTIONS*/
include_once('./rankingstats.inc.php');

/* SEARCH SQL FUNCTIONS*/
include_once('./search.inc.php');

/* LEADERBOARD AND HOME (as home includes leaderboard) */
include_once('./leaderboard.inc.php'); // load data from db - requires $LEADERBOARD
?>