<?php
// db info
$hostname="localhost";
$mysql_login="root";
$mysql_password="";
$database="vue_db";

if (!($db = mysqli_connect($hostname, $mysql_login , $mysql_password))){
	  die("Can't connect to mysql.");    
	}else{
	  if (!(mysqli_select_db($db,$database)))  {
		die("Can't connect to db.");
	  }
	}
//error_reporting(E_ERROR | E_PARSE);

?> 