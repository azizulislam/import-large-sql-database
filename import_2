<!DOCTYPE html>
<html lang="en">
<head>
<title>Import large database</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<style>
body {
padding-top: 70px;
font-family: 'Open Sans', sans-serif;
}
.form-group.required .control-label::after {
color: #d00;
content: "*";
margin-left: 5px;
}
</style>
</head>
<body>
<div class="container">
<div class="panel panel-primary">
<div class="panel-heading"><h4>Import large database using php/mysql</h4></div>
<div class="panel-body">
	<?php
	error_reporting(0);
	//Max execution time for large database. By default 900 Seconds or 15 minutes 
	ini_set('max_execution_time', 7200);
	//Database information
	$mysql_host_name     = 'localhost';
	$mysql_database_name = 'essexnorthshore_db';
	$mysql_user_name     = 'essexnorthshore_db';
	$mysql_password      = 'Tmax33!!';
	$mysql_file_name     = 'essextech_wp.sql1'; //Upload .sql file and path of .sql file
	//Create php.ini 
	$myfile = fopen("php.ini", "w") or die("Unable to open file!");
	$txt = "disable_functions none\n";
	fwrite($myfile, $txt);
	fclose($myfile);
	//Import the database and output the status
	$command = 'mysql -h' . $mysql_host_name . ' -u' . $mysql_user_name . ' -p' . $mysql_password . ' ' . $mysql_database_name . ' < ' . $mysql_file_name;
	exec($command, $output = array(), $worked);
	switch ($worked)
	{
		case 0:
			echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' . $mysql_file_name . '</strong> successfully imported to database <strong>' . $mysql_database_name . '</strong></div>';
			break;
		case 1:
			echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><ul><li>MySQL Host Name: <b>' . $mysql_host_name . '</b></li><li>MySQL Database Name: <b>' . $mysql_database_name . '</b></li><li>MySQL User Name: <b>' . $mysql_user_name . '</b></li><li>MySQL Password: <b>' . $mysql_password . '</b></li><li>MySQL Import Filename: <b>' . $mysql_file_name . '</b></li></ul></div>';
			break;
	}
	?>
</div> <!-- panel body close -->
</div><!-- panel close -->
</div>
</body>
</html>   
