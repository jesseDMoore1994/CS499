<?php

if (isset($_POST["server"])) {
// Name of the file
$filename = 'dump.sql';
// MySQL host
$mysql_host = $_POST["server"];
// MySQL username
$mysql_username = $_POST["username"];
// MySQL password
$mysql_password = $_POST["password"];
// Database name
$mysql_database = $_POST["database"];

// Connect to MySQL server
@mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
@mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    @mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    // Reset temp variable to empty
    $templine = '';
}
}
 echo "Tables imported successfully";
 exit;

}
?>
<html>
	<head>
		<title>Install TicketAngel</title>
	</head>
	<body>
		<form action="" method="post">
			<div>MySQL Server: <input type="text" name="server" value="localhost" /></div>
			<div>MySQL Username: <input type="text" name="username" value="root" /></div>
			<div>MySQL Passowrd: <input type="text" name="password" value="" /></div>
			<div>MySQL Database: <input type="text" name="database" value="ticketangel" /></div>
			<div><input type="submit" value="Instal" />
		</form>
	</body>
</html>