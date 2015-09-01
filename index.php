<?
//include("connect.php");
include("class_lib.php");
$FX = new Check;
if (isset($tag) && $tag != '') {
    // get tag
	// response Array
    $response = array("tag" => $tag, "error" => FALSE);
	
	switch($tag){
		
		
	case "login":
		// Request type is check Login
        // $name = $_POST['name'];
        // $password = $_POST['password'];
 
        // check for user
		
        $user = $FX->getUserByNameAndPassword($name, $password);
        if ($user != false) {
            // user found
            $response["error"] = FALSE;
            $response["uid"] = $user["user_id"];
            $response["user_name"] = $user["user_name"];
            $response["email"] = $user["email"];
            $response["date_c"] = $user["date_c"];
            $response["data_u"] = $user["date_u"];
		    echo json_encode($response);
			//echo "Hello";
        }//if
		 else {
            // user not found
            // echo json with error = 1
            $response["error"] = TRUE;
            $response["error_msg"] = "Incorrect username or password!";
			echo json_encode($response);
            //echo json_encode($response);
        }//else
		break; //login
		
		
	case "register":
		// Request type is Register new user
        //$name = $_POST['name'];
		//$password = $_POST['password'];
        //$email = $_POST['email'];
		//$gender = $_POST['gender'];
        //$age = $_POST['age'];
 		//$province = $_POST['province'];
		//$language = $_POST['language'];
		//$interest = $_POST['interest'];

        // check if user is already existed
        if ($FX->isUserExisted($name)) {
            // user is already existed - error response
            $response["error"] = TRUE;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
			
        } //if
		else {
            // store user
            $user = $FX->storeUser($name, $password, $email, $gender, $age, $province, $language, $interest);
            if ($user) {
                // user stored successfully
                $response["error"] = FALSE;
                $response["uid"] = $user["user_id"];
                $response["user"]["user_name"] = $user["user_name"];
				$response["user"]["password"] = $user["encrypted_password"];
                $response["user"]["email"] = $user["email"];
				$response["user"]["gender"] = $user["gender"];
				$response["user"]["age"] = $user["age"];
				$response["user"]["province"] = $user["province"];
				$response["user"]["language"] = $user["language"];
				$response["user"]["interest"] = $user["interest"];
                $response["user"]["date_c"] = $user["date_c"];
            	$response["user"]["data_u"] = $user["date_u"];
                echo json_encode($response);
            } //if
			else {
                // user failed to store
                $response["error"] = TRUE;
                $response["error_msg"] = "Error occured in Registartion";
                echo json_encode($response);
            }//else
		}//else
		break; //register
		
		
	
	/////////////////////////////////////////////////
	//////////// INSERT CODE HERE ///////////////////
	/////////////////////////////////////////////////
	
	case "place_check":
	
		if($FX->isPlaceExisted($place_name,$place_lat,$place_long))
		echo "1";
		else
		echo "2";
		break;
	
	
	case "default":
		 // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknow 'tag' value.";
        echo json_encode($response);
		
		break; //default
		
		
	
		
		
	case "checkmail":
		if($FX->isMailExisted($u_mail))
		echo "1";
		else
		echo "2";
		break;
		
	case "checkitem":
		if($FX->isItemExisted($i_name))
		echo "1";
		else
		echo "2";
		break;
		
	case "addlog":
		if($FX->logAdd($id_item))
		echo "1";
		else
		echo "2";
		break;	
		
	case "edituser":
		if($FX->editUser($id_user))
		echo "1";
		else
		echo "2";
		break;
		
	case "checklevel":
		
		echo $FX->Level($username);
		
		break;
		
	case "itemlevel":
		
		echo $FX->Levelitem($id_item);
		
		break;
		
	case "itemselect":

		if($FX->S_item($username,$id_item))
		echo "1";
		else
		echo "2";
		break;
	
	
	
	}// switch				
}// if
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Required parameter 'tag' is missing!";
    echo json_encode($response);
}// else tag

?>