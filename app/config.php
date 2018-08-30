<?php
	ob_start();
	session_start();


	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','123456');
	define('DB_NAME','');



	#set the default timezone
	date_default_timezone_set("Asia/Dhaka");

	#Give your website url here and Uncomment it and comment line 14.......

	define('BASEURL', 'http://localhost/');

	#**********    OR      *******************************************

	#if you are in localhost then give the absolute folder name here

	#define('BASEURL', 'http://localhost/my-default-template/');


?>
