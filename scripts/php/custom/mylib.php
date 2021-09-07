<?php
	//_________________________________________________encription class_______________________________
	class encription{
		// the encription length is 60 characters
		// obj->encript(password)								encription
		// obj->compare_encripted(password, enc_password)		compare_encripted
		public function encript($password){
			$random = "qwertyuiopasdfghjk";
			$salt = sprintf('$2y$%02d$%s', 13, substr(strtr(base64_encode($random), '+', '.'), 0, 22));
			return crypt($password, $salt);
		}
		public function compare_encripted($given_password, $db_hash){
			function isEqual($str1, $str2){
			    $n1 = strlen($str1);
			    if (strlen($str2) != $n1) {
			        return false;
			    }
			    for ($i = 0, $diff = 0; $i != $n1; ++$i) {
			        $diff |= ord($str1[$i]) ^ ord($str2[$i]);
			    }
			    return !$diff;
			}
			$given_hash = crypt($given_password, $db_hash);

			if (isEqual($given_hash, $db_hash)) {
			    return true;
			}else{
				return false;
			}
		}
	}
	//______________________________________________SQL query class________________________________
	class sql{
		var $user="";
		var $pass="";
		var $host="";
		var $database="";
		public function sql($user, $pass, $host, $DB){
			$this->user=$user;
			$this->pass=$pass;
			$this->host=$host;
			$this->database=$DB;
		}
		public function set($query){
			$out = false;
			$mysqli = new mysqli($this->host, $this->user, $this->pass, $this->database);
			if(mysqli_query($mysqli, $query)){
				$out=true;
			}else{ //temporary else statements
				echo mysqli_error($mysqli);
			}
			mysqli_close($mysqli);
			return $out;
		}
		public function read($query){
			$mysqli = new mysqli($this->host, $this->user, $this->pass, $this->database);
			$out = false;
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}else{
				if(!$result = $mysqli->query($query)){
					die('There was an error running the query [' . $mysqli->error . ']');
				}else{
					$i=1;
					while($row = $result->fetch_assoc()){
						$out[$i] = $row;
						$i++;
					}
					$out[0]["length"]=$i;
				}
			}
			$result->free();
			$mysqli->close();
			return $out;
		}
	}
	//____________________________________Instantiating the classes___________________________________
	// the encription object
	// and the sql query class
	$encription= new encription();
	//# $encription->encript("text");
	//# $encription->compare_encripted("text","encripted_text");

	$DB = new sql("bolaloan","bolaloan", "127.0.0.1", "bolaloan");
	//# $DB->read("sql query");
		// the output is false if there is an error
		// the output[0]["length"]; is the number of raws
		// the output[$greater_than_0]["Column"]; is the data from database
	//# $DB->set("query");
		// return false if theirs an error
		// return true if successful

?>	