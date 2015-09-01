<?
session_start();
class Check {

	// constructor
    function __construct() {
        include("connect.php");
        // connecting to database
        }
    // destructor
    function __destruct() {
    }
	
	public function isUserExisted2($name) {
        $result = mysql_query("SELECT username from member WHERE username = '$name'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	public function isMailExisted2($email) {
        $result = mysql_query("SELECT email from member WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	

	
	
	 /**
     * Storing new user
     * returns user details
     */
	 //
	 public function isPlaceExisted($place_name,$place_lat,$place_long) {
        $result = mysql_query("SELECT * from place_list WHERE name_place = '$place_name' and lat_place = '$place_lat' and long_place = '$place_long' ");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // place existed 
            return true;
        } else {
            // place not existed
            return false;
        }
    }
	 
	 
	 
	 
    public function storeUser($name, $password, $email, $gender, $age, $province, $language, $interest) {
        //$uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $tho = $hash["tho"]; // tho
        $result = mysql_query("INSERT INTO user_profile VALUES(NULL, '$name', '$encrypted_password', '$tho', '$email', '$gender', $age, '$province', '$language', '$interest', NOW(),NULL)");
        // check for successful store
		//echo "XXX";
        if ($result) {
            // get user details 
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM user_profile WHERE user_id = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
 
    /**
     * Get user by username and password
     */
    public function getUserByNameAndPassword($name, $password) {
        $result = mysql_query("SELECT * FROM user_profile WHERE user_name = '$name'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $tho = $result['tho'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($tho, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
				
				return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($name) {
        $result = mysql_query("SELECT user_name from user_profile WHERE user_name = '$name'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns tho and encrypted password
     */
    public function hashSSHA($password) {
 
        $tho = sha1(rand());
        $tho = substr($tho, 0, 10);
        $encrypted = base64_encode(sha1($password . $tho, true) . $tho);
        $hash = array("tho" => $tho, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param tho, password
     * returns hash string
     */
    public function checkhashSSHA($tho, $password) {
 
        $hash = base64_encode(sha1($password . $tho, true) . $tho);
 
        return $hash;
    }
	
	
	
	
}
?>