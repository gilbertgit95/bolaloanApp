<?php
	include "mylib.php";
	// check post request
	$out;
	if(count($_POST)>0){
		//parsing the data from post request
		$data = json_decode($_POST["data"]);
		
		// login administrator
		if($data->command == "loginAdmin"){
			$out->command = "loginAdmin";
			//$out->data = "puta";

			//get the admin keys from database
			$adminKeys = $DB->read("SELECT password, username FROM admin WHERE id=1");
			// check the length of the keys
			if($adminKeys[0]["length"]>1){
				// check the keys
				if($encription->compare_encripted($data->password, $adminKeys[1]["password"]) && $data->username == $adminKeys[1]["username"]){
					// generate random key
					$randomKey = rand()."".rand().time();
					// setting random key to output data and admin in database
					$out->key = $randomKey;
					$out->data = "success";
					$DB->set("UPDATE admin SET rand_key='".$randomKey."' WHERE id=1");
					$DB->set("INSERT INTO `bolaloan`.`temp_keys` (`id`, `key`, `admin`, `date`) VALUES (NULL, '".$randomKey."', 'T', CURRENT_TIMESTAMP)");
				}else{
					$out->data = "error";
				}
			}		
		}

		// check administrator key if existed on database
		if($data->command == "checkAdminKey"){
			$out->command = "checkAdminKey";
			//$out->data = "puta";

			//get the admin keys from database
			$adminRandKeys = $DB->read("SELECT * FROM `temp_keys` WHERE admin='T'");
			// check the length of the keys
			if($adminRandKeys[0]["length"]>1){
				// check for key in temporary keys
				$out->data = "error";
				for($i=1; $i<$adminRandKeys[0]["length"]; $i++){
					if($adminRandKeys[$i]["key"] == $data->cookie){
						$out->data = "success";
						break;
					}else{
						$out->data = "error";
					}
				}
		
			}		
		}

		// logout page
		if($data->command == "logout"){
			$out->command = "logout";
			//$out->data = "puta";
			$key = $_COOKIE["adminKey"];
			$DB->set("DELETE FROM `bolaloan`.`temp_keys` WHERE `temp_keys`.`admin`='T' AND `temp_keys`.`key`='".$key."'");
			$out->data = "success";
		}

		// logout page
		if($data->command == "clientLogout"){
			$out->command = "clientLogout";
			//$out->data = "puta";
			$key = $_COOKIE["collectorKey"];
			$DB->set("DELETE FROM `bolaloan`.`temp_keys` WHERE `temp_keys`.`admin`='F' AND `temp_keys`.`key`='".$key."'");
			$out->data = "success";
		}

		// login Collector
		if($data->command == "loginCollector"){
			$out->command = "loginCollector";
			//$out->data = "puta";

			//get the admin keys from database
			$collectorKeys = $DB->read("SELECT client_key FROM admin WHERE id=1");
			// check the length of the keys
			if($collectorKeys[0]["length"]>1){
				// check the client key in adatabase and input if the same
				if($collectorKeys[1]["client_key"] == $data->key){
					// generate random key
					$randomCollectorKey = rand()."".rand().time();
					// setting random key to output data and admin in database
					$DB->set("UPDATE admin SET rand_client_key='".$randomCollectorKey."' WHERE id=1");
					$DB->set("INSERT INTO `bolaloan`.`temp_keys` (`id`, `key`, `admin`, `date`) VALUES (NULL, '".$randomCollectorKey."', 'F', CURRENT_TIMESTAMP)");
					$out->key = $randomCollectorKey;
					$out->data = "success";
				}else{
					$out->data ="error";
				}
			}		
		}

		// check client key if existed on database
		if($data->command == "checkClientKey"){
			$out->command = "checkClientKey";
			//$out->data = "puta";

			//get the admin keys from database
			$clientRandKeys = $DB->read("SELECT * FROM `temp_keys` WHERE admin='F'");
			// check the length of the keys
			if($clientRandKeys[0]["length"]>1){

				$out->data = "error";
				for($i=1; $i<$clientRandKeys[0]["length"]; $i++){
					if($clientRandKeys[$i]["key"] == $data->cookie){
						$out->data = "success";
						break;
					}else{
						$out->data = "error";
					}
				}
			}		
		}
	}
	// return the stringified object
	echo json_encode($out);
?>