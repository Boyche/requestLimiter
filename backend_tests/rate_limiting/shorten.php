 <?php
	
	$n = 10;
	
	if(isset($_GET['name'])){
	
		$name = $_GET['name'];
		
		$ip= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		
		require_once('functions.php');
		
		$conn = connectToDatabase();
		
		
		
		$stmt = $conn->prepare("SELECT count(IDREQ) as noReqs
												FROM requests
												WHERE IPREQ = ? AND TIMEDIFF(CURRENT_TIMESTAMP,  TIMEREQ) < '00:01:00'");
		
		if(!$stmt->bind_param('s', $ip)){
			echo 'Error in query: '.$sql->error;
		}
		
		$stmt->execute();

		$result = $stmt->get_result();
		if ( !($row = $result->fetch_assoc()) ){
			$numOfReqs = $row['noReqs'] ;
			if($numOfReqs < $n){
				$stmt = $conn->prepare("INSERT INTO `requests`
													( `NAMEREQ`, `IPREQ`, `TIMEREQ`) 
													VALUES 
													(?, ?, CURRENT_TIMESTAMP)");
			
				if(!$stmt->bind_param('ss', $name, $ip)){
					echo 'Error in query: '.$sql->error;
				}
					
				if(!$stmt->execute()){
					echo 'Error in query: '.$sql->error;
				}
				
				echo "Hi, ".$row['NAMEREQ'];
				header("Location: ".$row['FULLURL'],TRUE,301);
			}
			
		}else{
		//	header("HTTP/1.0 404 Not Found", TRUE, 404);
		}
		
		header("200 OK", true, 200);
		die(json_encode($obj));
	}

?>