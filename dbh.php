<?php

	$conn = mysqli_connect('localhost','root','','grrats');
	
	if (!$conn){
			die("Connection failed: " . mysqli_connect_error());
		}