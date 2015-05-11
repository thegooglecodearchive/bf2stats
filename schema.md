# How it all works #
Here is a small wiki page i setup that explains how things work alittle.


## Server Startup ##

---

When the server starts up, the battlefield server calls on the init.py file. This file has specific instructions on what files to include and load. The init.py calls forth the files and functions that will be loaded into the game server. This is the main reason BF2statistics works... it has its own function and files that are loaded with the init.py. Here is a brief explaination of what the main files do:
> - stats.py: Handles everything to do with in game stats, including scores, time in squad, kills, deaths etc etc. When the game has ended, this file invokes the Endofround script.

> - endofround.py: Determines the the top players of each round.

> - snapshot.py: This scripts assembles all of the players stats and round information and puts it in something called a string (1 huge sentence). Once it has done that, it calls on the miniclient.py file, to "post" (send) the stats to the webserver. Once the snapshot is sent, it clears out all the rounds stats and medals so the server can restart fresh.

> - miniclient.py: This is the main script for sending and receiving players stats from the stats server and game server.

> - medals.py: This script uses the miniclient.py to load each of the players stats, rank, and medals when the player connects to the server. It also checks after every action a player makes, if he is eligible for the next rank, award, medal etc. If the player is elible, then this script will send to the gameserver, a code to actually "issue" you the medal in-game. At the end of the round, this script also actually issues the top 3 players their positional medals.

There are alot more files but thats for another wiki page :P



## Client & Obtaining Stats ##

---

When you join a game, BF2 will send out a request to get your stats from the gamespy server. This is one of the reasons why a redirect is needed when using a private stats system... So you can load the stats that BF2 is requesting from a private stats Database instead of the gamespy one. This is where the ASP folder comes into play. the ASP uses its files to obtain, and send the information back to the BF2 gameserver. Because of this, you can use an Online account and view your stats in BFHQ.



## The ASP ##

---

The ASP is responsible for sending stats to the BF2 server & client, as well as process end game snapshots, so the stats can be stored in a database.

## Additional Stuff ##

---

Here is an image i found that shows how everything ties together.

![http://i288.photobucket.com/albums/ll187/wilson212/bf2-stats.jpg](http://i288.photobucket.com/albums/ll187/wilson212/bf2-stats.jpg)