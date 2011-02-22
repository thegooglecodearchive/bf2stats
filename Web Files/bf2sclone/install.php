<?php
// Include Some Compatibility if php is less then 5
if(substr(phpversion(),0,1) != 5)
{
	include_once('compatibility.inc.php');
}

// Check for posted data
$ROOT = isset($_POST["root"]) ? $_POST["root"] : 0;
$DOMAIN = isset($_POST["domain"]) ? $_POST["domain"] : 0;
$SITE_TITLE = isset($_POST["site_title"]) ? $_POST["site_title"] : 0;
$DBIP = isset($_POST["dbip"]) ? $_POST["dbip"] : 0;
$DBNAME = isset($_POST["dbname"]) ? $_POST["dbname"] : 0;
$DBLOGIN = isset($_POST["dblogin"]) ? $_POST["dblogin"] : 0;
$DBPASSWORD = isset($_POST["dbpassword"]) ? $_POST["dbpassword"] : 0;

// If nothing is posted, then show the installation form
if($ROOT === 0)	
{
	echo '<style type="text/css">
	<!--
	.style1 {
		color: #FFFFFF;
		font-weight: bold;
	}
	.style4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
	.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small; }
.style7 {font-size: small}
.style8 {font-family: Verdana, Arial, Helvetica, sans-serif}
	-->
	</style>
	<form id="form1" name="form1" method="post" action="install.php">
	<table width="480" border="1" align="center" bordercolor="#000000" cellspacing="0">
	  <tr>
		<td bgcolor="#000000"><div align="center" class="style4"><span class="style1">B.F.2.S. Clone Install Guide </span></div></td>
	  </tr>
	  <tr>
		<td><span class="style7"><span class="style8">B.F.2.S. Clone - Web Interface Configuration</span><br />
		</span>
		  <table width="480" border="0" align="center" bordercolor="#000000">
            <tr>
              <td><span class="style6">Enter your Domain (eg.: &quot;mybf2stats.com&quot;) <br />
                NOTE: do not enter an http:// nor  &quot;/&quot; on the end <br />
                <input name="domain" type="text" value="localhost" maxlength="255" width="480" />
              </span></td>
            </tr>
            <tr>
              <td nowrap="nowrap"><span class="style6">Enter the Root Direcotry to B.F.2.S. Clone (eg.: &quot;http://mybf2sclone/bf2sclone/&quot;) <br />
                NOTE: do not forget the last &quot;/&quot; <br />
                <input name="root" type="text" value="http://localhost/bf2sclone/" maxlength="255" width="480" />
              </span></td>
            </tr>
			<tr>
              <td><span class="style6">Enter your site title (eg: Nuke Server) <br />
                <input name="site_title" type="text" value="Server Name" maxlength="255" width="480" />
              </span></td>
            </tr>
            <tr>
              <td nowrap="nowrap">&nbsp;</td>
            </tr>
          </table>
	    <span class="style7">          </span></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap"><span class="style8">B.F.2.S. Clone - Database Configuration 
		  </span>
		  <table width="480" border="0" align="center" bordercolor="#000000">
            <tr>
              <td class="style6">Enter the IP [and port if its not default] (format.: &quot;IP:PORT&quot; or &quot;IP&quot; or localhost) <br />
                <input name="dbip" type="text" value="localhost" maxlength="255" width="480" />              </td>
            </tr>
            <tr>
              <td nowrap="nowrap" class="style6">Enter database name (eg.: bf2stats) <br />
                <input name="dbname" type="text" value="bf2stats" maxlength="255" width="480" />
                <br />
              Enter login name (eg.: bf2) <br />
              <input name="dblogin" type="text" value="bf2" maxlength="255" width="480" />
              <br />
              Enter password (eg.: bf2stats) <br />
              <input name="dbpassword" type="password" value="mybf2" maxlength="255" width="480" /></td>
            </tr>
		  </table>
		  </td>
	  </tr>
	  <tr>
		<td nowrap="nowrap"><div align="center">
		  <input type="submit" name="Submit" value="install" />
		</div></td>
	  </tr>
	</table>
	<p>&nbsp;</p>
	</form>';
}
else
{
	include_once('functions.inc.php');
	// delete cache files, otherwise links wont work
	deleteCompleteCache();
	// patch css files - as they are not able to execute with variables *argh!*
	$css = file_get_contents(getcwd().'/template/two-tiers.css.template');
	$css = str_replace('{:ROOT:}', $ROOT, $css);
	file_put_contents(getcwd().'/css/two-tiers.css', $css);
	// patch config.inc.php
	$config = file_get_contents(getcwd().'/template/config.inc.php.template');
	$config = str_replace('{:ROOT:}', $ROOT, $config);
	$config = str_replace('{:DOMAIN:}', $DOMAIN, $config);
	$config = str_replace('{:SITE_TITLE:}', $SITE_TITLE, $config);
	// set database settings...
	$config = str_replace('{:DBIP:}', $DBIP, $config);
	$config = str_replace('{:DBNAME:}', $DBNAME, $config);
	$config = str_replace('{:DBLOGIN:}', $DBLOGIN, $config);
	$config = str_replace('{:DBPASSWORD:}', $DBPASSWORD, $config);		
	file_put_contents(getcwd().'/config.inc.php', $config);
	echo 'Thanks for using this installer<br>By the way... its done ;)';
}
?>