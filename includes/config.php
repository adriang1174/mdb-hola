<?php
	$servername='localhost';   
    $database_username='uv9032_formus'; 
    $database_password='passform';  
    $database_name='uv9032_form';

mysql_connect($servername,$database_username,$database_password) or mysql_error();
mysql_select_db($database_name) or mysql_error();	
?>