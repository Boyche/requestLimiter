<?php
	
	//function that connects to database and returns connection or null if it fails.
	function connectToDatabase(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$database = "limitedrequester";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($conn->connect_error) {
			//die("Connection failed: " . $conn->connect_error);
			return null;
		} 
		else return  $conn;
	}

	
?>