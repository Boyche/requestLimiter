 <?php
	
	//Seting up these two variables will determine how much requests in how much minutes will server allow. 
	//this data can be read from some database or file. 
	//for example, every ip/username/mac/apikey can have saved certain number of allowed requests per certain number of minutes. 
	//thats how data can be used/manipulated by admin side, or someone other.
	$n = 10;
	$min = 1;
	
	
	if(isset($_GET['name'])){
		$name = $_GET['name']; //Take name from GET request header
		
		//if there is proxi ip, take it, or take original ip
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		//$ip = $_SERVER['REMOTE_ADDR'];
		
		//import functions.php
		require_once('functions.php');
		
		$conn = connectToDatabase();
		
		//This is code will allow max $n request in every $n (in this case 1) minute in time
		//*Begin
		
		//eg.: 12:55-12:56, 17:34-17:35, etc.
		/*
		
		$sec = time(); //gets time in this moment of time.
	
		$rem = $sec % (60*$min); //gets module of seconds 
		$secBot = $sec - $rem; //get starting time moment in secs
		$secTop = $secBot  + (60*$min); //get ending time moment in secs
		
		$botTime = date("Y-m-d H:i:s", $secBot); //get string from bottom time
		
		$topTime = date("Y-m-d H:i:s", $secTop); //get string from top time 
		
		//echo "$botTime $topTime";
		//query asks for count of rows from this ipAddres in time segment [$botTime, $topTime)
		if(!($stmt = $conn->prepare("SELECT count(IDREQ) as noReqs
													FROM requests
													WHERE IPREQ = ? AND TIMEREQ >= ? AND  TIMEREQ < ?") ) )
													{
															echo 'Error in query: '.$conn->error;
													}	
													
		if(!$stmt->bind_param('sss', $ip, $botTime, $topTime )){
			echo 'Error in query: '.$conn->error;
		}
		*/
		//this is the way of protecting my app from any possible sql injection attack.
		//*End Of Code
		
		
		//This is code will allow max $n request in last $n(in this case 1) minutes
		//**Begin
		//geting string of time interval that we will look for requests in. eg. 00:01:00 or 00:05:00, etc
		$interval = date("H:i:s", mktime( 0, 0, 60*$min, 0, 0, 0 ));
		
		//query counts requests with this IPADDR that happened within $n miuntes.
		if(!($stmt = $conn->prepare("SELECT count(IDREQ) as noReqs
													FROM requests
													WHERE IPREQ = ? AND TIMEDIFF(CURRENT_TIMESTAMP,  TIMEREQ) < ? ") ) )
													{
															echo 'Error in query: '.$conn->error;
													}
				
		if(!$stmt->bind_param('ss', $ip, $interval)){
			header("404 Not Found", true, 404);
			die( 'Error in query: '.$conn->error);
		}
		//this is the way of protecting my app from any possible sql injection attack.
		//**End Of Code.
			
		if(!$stmt->execute()){ //execution of the query on the database
			header("404 Not Found", true, 404);
			die( 'Error in query: '.$conn->error);
		}
		
		$result = $stmt->get_result(); // getting an resulting table 
		if ( ($row = $result->fetch_assoc()) ){ //fetching the first row from table to association array. and if it works as intended
			
			$numOfReqs = $row['noReqs']; // we get noReqs from the table. 
			if($numOfReqs < $n){//if number of requests is less than $n
				
				//we insert request by this IDADDR into db.
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
				
				//caluculate number of remaining requests
				$remaining = $n - $numOfReqs - 1;
				
				//now we add headers.
				header("X-RateLimit-Limit: $n",false);
				header("X-RateLimit-Remaining: $remaining",false);
				header("200 OK", false, 200);
				die ("Hi, ".htmlentities($name));
				//using htmletities function we protect us from any cross site scripting attack.
			}else{
				//number of requests is $n
				//now we add headers.
				header("429 Too Many Requests", false, 429);
				die ("Too Many Requests!");
			}
			
		}else{
			header("404 Not Found", true, 404);
			die( 'Error in query. No rows in result table.');
		}
	
	}

?>