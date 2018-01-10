 
 // jQuery event handler for click event on element with id-requestGreeting
$(document).on("click","#requestGreeting",function(){
	var name = $("#nameTxt").val().trim(); //we get trimmed data from input.
	if(name.length == 0){ //check if inserted data is of length 0.
		alert("Please, insert name!");
		return; //finish function after wrong insert 
	}
	
	//ajax call, for calling greeting api.
	$.ajax({
		url: "/backend_tests/rate_limiting/greet.php", //we go to greet.php page
		method: "GET", // GET request
		data: { //data sent to api
			"name" : name 
		},
		dataType: "text", //type of data that we expect as am answer from server.
		success: function(data){ //function that is going to be executed if comunication with api is ok.
			console.log(data);
			var str = data;
			
			$('#respondDiv').html(str);	// set respond to div.		
		},
		error: function(arg0, arg1, arg2){ //function that is going to be executed if comunication with api fails.
			alert(arg2);
			console.log("Error communication: arg1:"+arg1+" arg2:"+arg2);
			//console.log(arg0);
		}
	});
});

