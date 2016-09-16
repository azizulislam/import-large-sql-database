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
	<form class="form-horizontal" enctype="multipart/form-data" method="post" action="" role="form" autocomplete="off">
	<fieldset>
<!-- Form Name -->
	<legend>Enter your database information</legend>

	<!-- Database Hostname-->
	<div class="form-group required">
	  <label class="col-md-4 control-label" for="db_host_name">Hostname</label>  
	  <div class="col-md-4">
	  <input id="db_host_name" name="db_host_name" placeholder="Enter hostname" class="form-control input-md" required="required" type="text">
	  <span class="help-block">i.e. localhost</span>  
	  </div>
	</div>

	<!-- Database Name -->
	<div class="form-group required">
	  <label class="col-md-4 control-label" for="db_name">Database Name</label>  
	  <div class="col-md-4">
	  <input id="db_name" name="db_name" placeholder="Enter database name " class="form-control input-md" required="required" type="text">
	  <span class="help-block">i.e. domain_dbname</span>  
	  </div>
	</div>

<!-- Database User Name -->

	<div class="form-group required">
	  <label class="col-md-4 control-label" for="db_username">Database User Name</label>  
	  <div class="col-md-4">
	  <input id="db_username" name="db_username" placeholder="Enter user name " class="form-control input-md" required="required" type="text">
	  <span class="help-block">i.e. domain_dbusername</span>  
	  </div>
	</div>

	<!-- Database Password-->
	<div class="form-group required">
	  <label class="col-md-4 control-label" for="db_password">Database Password</label>  
	  <div class="col-md-4">
	  <input id="db_password" name="db_password" placeholder="Enter database password" class="form-control input-md" required="required" type="text">
	  <span class="help-block">SQL user password</span>  
	  </div>
	</div>

	<!-- Max. Execution Time -->
	<div class="form-group required">
	  <label class="col-md-4 control-label" for="max_execution_time">Max. Execution Time (in second)</label>  
	  <div class="col-md-4">
	   <select id="max_execution_time" name="max_execution_time" class="form-control"  required="required">
		  <option value="900">15 minutes</option>
		  <option value="1800">30 minutes</option>
		  <option value="3600">1 hour</option>
		</select>
	  </div>
	</div>

	<!-- File Button --> 
	<div class="form-group required">
	  <label class="col-md-4 control-label" for="sql_file">Select .SQL file</label>
	  <div class="col-md-4">
		<input id="sql_file" name="sql_file" class="input-file" type="file"  required="required" accept=".sql">
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="Import"></label>
	  <div class="col-md-4">
		<button id="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-upload"></span> Import Database</button>
	  </div>
	</div>
	
	

	</fieldset>
	</form>
	
	<?php
	error_reporting(0);
	if(isset($_POST['submit']))
	{
		ini_set('max_execution_time', $_POST['max_execution_time']); //3600 seconds = 1hr 
		//Upload SQL
		$target_path = getcwd().'/';
		$target_path = $target_path . basename( $_FILES['sql_file']['name']); 
		
		if(move_uploaded_file($_FILES['sql_file']['tmp_name'], $target_path)) 
		{
			echo '<div class="alert alert-success fade in">The file <strong>' . basename( $_FILES['sql_file']['name']) .'</strong> has been uploaded</div>';
		} 
		else
		{
			echo '<div class="alert alert-danger fade in">The file <strong>Error! </strong>There was an error uploading the file, please try again!</div>';
		}
		//Database information
		$mysql_host_name = trim($_POST['db_host_name']);
		$mysql_database_name = trim($_POST['db_name']);
		$mysql_user_name = trim($_POST['db_username']);
		$mysql_password = trim($_POST['db_password']);
		$mysql_file_name = $_FILES['sql_file']['name'];
		$mysql_file_name = $mysql_file_name;
		
		//Create php.ini 
		$myfile = fopen("php.ini", "w") or die("Unable to open file!");
		$txt = "disable_functions none\n";
		fwrite($myfile, $txt);
		fclose($myfile);
		
		//Export the database and output the status to the page
		$command='mysql -h' .$mysql_host_name .' -u' .$mysql_user_name .' -p' .$mysql_password .' ' .$mysql_database_name .' < ' .$mysql_file_name;
		exec($command,$output=array(),$worked);
		switch($worked)
		{
			case 0:
				echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' .$mysql_file_name .'</strong> successfully imported to database <strong>' .$mysql_database_name .'</strong></div>';
				break;
			case 1:
				echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><ul><li>MySQL Host Name: <b>' .$mysql_host_name .'</b></li><li>MySQL Database Name: <b>' .$mysql_database_name .'</b></li><li>MySQL User Name: <b>' .$mysql_user_name .'</b></li><li>MySQL Password: <b>' .$mysql_password .'</b></li><li>MySQL Import Filename: <b>' .$mysql_file_name .'</b></li></ul></div>';
				break;
		}
		
	}

		?>
	</div> <!-- panel body close -->
    </div><!-- panel close -->
</div>
</body>
</html>
=======
<?php
ini_set('max_execution_time', 3600); //3600 seconds = 1hr minutes
$mysqlDatabaseName ='wayneala_wayneal';
$mysqlUserName ='wayneala_wayneal';
$mysqlPassword ='Tmax3333';
$mysqlHostName ='localhost';
$mysqlImportFilename ='wasperling.sql';

//Import the database and output the status to the page
$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
exec($command,$output=array(),$worked);
switch($worked){
    case 0:
        echo 'Import file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
        break;
    case 1:
        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
        break;
}
?>