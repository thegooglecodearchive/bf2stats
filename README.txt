Bf2statistics Intallation guide Written by wilson212

Referances:
www.bf2statistics.com

// **************************************************************
// Intro

		Welcome and thank you for downloading BF2statistics UnOfficial version 1.4.3! This BF2stats system was written by Chump, MrNiceGuy,
	The shadow, and many more. All i have done is take BF2statistics 1.4.2 and added many fixes that myself and many others have pushed in the
	forums. I donot take all credit for these fixes, and I certently donot take credit for writting any of the BF2statistics scripts.

// **************************************************************
// Things Needed for intallation

	- Battlefield 2 Version 1.41 or 1.50 (patch found on various websites, just googe bf2 1.41 / 1.50 patch)
	- Bf2 dedicated server 1.41 or 1.50 (found here: http://www.bf-games.net/index.php?action=download_details&new=1&downloadid=953 and here http://www.gamershell.com/download_16478.shtml)
	- xampp or other Apache, PHP, CuRL, and Mysql software

// **************************************************************
// Installation

	=== Table of contents ===

	1.Installing xampp
	2.Creating the database
	3.Installing the dedicated server
	4.Installing/Updating the database
	5.Final Installation of script files
	6. Online accounts and unlocks
	7.FAQ / Editing
	_______________________________

	1. So first off is to install xampp on your computer(included in This folder). When it bring up the screen that asks
		you to pick which services to install, make sure you check off MySql, and Apache services. If you already have apache, MySQL,
		PHP, and CuRL installed on your machine, then xampp isnt needed
		
	2. When all is said and done and it is installed, open up your webbrowser and type 127.0.0.1 in the address bar.

	2.1 Click on Phpmyadmin on the left hand side about halfway down the screen.

	2.2 Next, under "create new database", (about halway down the screen towards the middle), Type in bf2stats. Then select "create".

	2.3 Next, your going to add a user to access and modify these stats. At the top of the screen, click "localhost", then click on "privilages"

	2.4 you should get a table that looks like this:

		User overview
		A	B 	C	D	E	F	G	H	I	J	K	L	M	N	O	P 	Q	R 	S	T	U	V	W	X	Y	Z	[Show all]
			User 	Host 	Password 	Global privileges Tip 	Grant 	
			pma 	localhost 	No 	SHUTDOWN 	No 	Edit Privileges
			root 	127.0.0.1 	No 	ALL PRIVILEGES 	Yes 	Edit Privileges
			root 	localhost 	No 	ALL PRIVILEGES 	Yes 	Edit Privileges
		With selected: Check All / Uncheck All

		Add a new User  <--- CLICK ON THIS!!!

	2.5 Click on "ADD NEW USER" shown above.

	2.6 For user name type in bf2statslogger, and for host pick local, and for password, put bf2. Down below make sure
	you select all privilages 
	
	3. Next Install the Bf2 dediacted server. by default it shoud install in %systemroot%\program files\EAgames\ 

	3.1 next, swap out the python folder (%systemroot%\program files\EAgames\battlefield 2 server\python) with the one in this folder.

	3.2 after that, Place the ASP folder into your htdocs or www folder (%systemroot%\xampp\htdocs.)
	
	3.3 I also included BF2s Clone. If you want to use this ( Its a player stats web interface like this -> http://bf2s.com ) Then also insert this into your htdocs / www folder
	
	3.3.1 To install BF2s Clone, go www.yourIP.com/yourBF2s_clone_folder/install.php
	
	4. Next, open your browser and type in the address bar "127.0.0.1/asp" ... for the username, type: Admin and the password is: Password. The username
		and password ARE CASE SENSATIVE!

	4.1 Once logged in we need to install the database...do so by clicking "install DB" ont he top left corner.

	4.2 On this next screen it will ask:
					____________________________
			         |server	|localhost	|
				     |databse	|bf2stats	|	
				     |username	|bf2statslogger	|
				     |password	|bf2		|
				     ____________________________
	input that following information and click "confirm process" at the bottom, then click "process"

	4.3 The next screen should show you installing and loading various information. you should only get 1 error as shown in screen shot...warnings are ok.

	4.4 Next click on Upgrade DB (left hand corner) and type in the information just like before. you WILL ALWAYS see 10 ERRORS! this is normal dont freak out.

	4.5 next click "test Config" (refer to photo step_4.5 as needed).everything should pass except "backup path writable"
		which is always gonna happen. If you get 1 or 2 warnings, thats fine as well.
		
	5. You need to edit your host file in order for your stats to be loaded from YOUR stats database and not the Gamepsy one. 
		To do this you need to edit this file, go to %systemroot%\windows\system32\drivers\etc\host. You may or may 
		not need admin rights to change the file name, i dont know, but if you dont then just rename the the host file to 
		host_ or something, then copy the one included in my folder into you host directory. If you open the hosts file with 
		notepad, you will see "127.0.0.1   bf2web.gamespy.com". This is the redirect. If you want to play on the official
		servers again, just put a # infront of the 127.0.0.1. Note that 127.0.0.1 is the address of your ASP.
		
	5.1 If you are not hosting the ASP on the same machine as the server, then you need to edit the BF2 server statistics config
		It is located "<bf2 server>/python/bf2/BF2StatisticsConfig.py"
		
	5.2 Next you need to setup your server settings. Go to battlefield 2 server\mods\bf2\setting\serversettings.con
		If you are gonna Play offline, then you leave the sv.serverIP blank. If you want to play locally with a few friends,
		then you need to import your computers IPv4 address.to get your IPv4 address, open your command prompt and type
		"ipconfig" and hit enter...scroll up till you see your IPv4 Address and copy that down. Edit all the other setting to
		your liking. At this point in time you are ready to play!!
		
	6. If you want to use unlocks on your private server, then there is a few things to do. First... You need to make sure that
		anyone playing on your server, has their host files set like so "<your BF2 Server IP>   bf2web.gamespy.com". Even with hamanchi!
		If the computer is local for you, then its just 127.0.0.1. Users can now login with an online account, and play on your srever. 
		As long as the redirect is there in the hosts file, you can login with online accounts and use this stats system with unlocks.
		
	----------------------------------------------------------------------------------------------------------------------
	----------------------------------------------------------------------------------------------------------------------
													 FAQ / EDITING

	1.How do i edit the number of bots in a game and there difficulty settings?

		Y can have only up to 32 bots in a coop game. to adjust these settings,
		go to battlefield 2 server\mods\bf2\settings\serversettings.con. towards the bottom you will see the options
		to adjust these settings.

	2.how do i change the gamemodes and maps i play on?

		To easy... Go to battlefield 2 server\mods\bf2\setting\maplist.con. An example is shown here: for Conquest mode
		on map dalian plant looks like this: "mapList.append Dalian_plant gpm_cq 32"... for Co-Op it should look like 
		this: "mapList.append dalian_plant gpm_coop 16"... Note that coop only supports 16 size maps unless its a custon
		map.

	3.How do i change the requirment for earning medals and ranks?

		Open up your "bf2 server directory, in python\bf2\stats\medal_data.py" is where you can edit anything and 
		everything concerning awards and rank. Note that for awards and badges, when it says time, It's refered to in
		seconds. So 3600 is 1 hour of gameplay. Also note that ranks such as SMOC and 4 star general can be awarded
		within your database as well. Type in 127.0.0.1/phpmyadmin in your address bar. Click on bf2stats under databases
		in the left hand side of the screen. Then click Player, On the far left hand of the screen under bf2stats (#).
		Then towards the top under where it says "server: localhost >" click browse, Find who ever it is you wanna
		promote and then click on the pencil to edit there stats.

	4. How do i host my server Locally again?

		Go into your bf2 server directory, \mods\bf2\settings\serversettings.con and under the sv.serverIP, input your
		computers IPv4 address. to get your IPv4 address, open your command prompt and type"ipconfig" and hit 
		enter...scroll up till you see your IPv4 Address and copy that down.

	5.How do i adjust the amount of points i get for kills and flag captures etc?

		For editing kills and those kind of stats, you have to edit batlefield 2 server\mods\bf2\python\game
		\scoringCommon.py. Now to deit the amount of points for flag captures, flag defends, neutralization
		points, battlefield 2 server\mods\bf2\python\game\gamemodes\gpm_coop.py or gpm_cq.py.
		
// **************************************************************
// Referances and Help

	If you have any issues... Please refer to the BF2statistics forums please (bf2statistics.com)
