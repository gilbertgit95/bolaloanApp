<?php
	include "mylib.php";
	include "adminPreviledge.php";
	// reset security keys
	//$DB->set("UPDATE admin SET password='".$encription->encript("administrator")."', username='administrator' WHERE id=1");

	// test for post data
	if(count($_POST)>0){
		// parse the data from ajax
		$data = json_decode($_POST["data"]);
		// initiate the out put object
		$out;
		// run if the command from the page is to get the client key
		if($data->command == "getClientKey"){
			// getting the client key on admin
			$getClientKey_query = $DB->read("SELECT client_key FROM admin WHERE id=1");
			// setting the output
			$out->command = "getClientKey";
			$out->data = $getClientKey_query[1]["client_key"];
		}

		// if the query is for setting the admin
		if($data->command == "setAdmin"){
			$out->command = "setAdmin";
			// get the security keys from daatabase
			//$out->data = $encription->encript("administrator");
			$DBkeys = $DB->read("SELECT password, username FROM admin WHERE id=1");
			if($DBkeys[0]["length"]>1){
				//check if the check the two check box atleast has one check
				if($data->passcheck || $data->usercheck){
				// check the keys if the same as the input keys
					if($encription->compare_encripted($data->password, $DBkeys[1]["password"]) && $DBkeys[1]["username"] == $data->username){
						//update the keys and return success
						$update_query = "UPDATE admin SET ";
						if($data->passcheck){
							$update_query .= "password='".$encription->encript($data->newpassword)."' ";
						}
						if($data->passcheck && $data->usercheck){
							$update_query .= ", ";
						}
						if($data->usercheck){
							$update_query .= "username='".$data->newusername."' ";
						}
						$update_query .= "WHERE id=1";
						$DB->set($update_query);
						//$out->data = $update_query;
						$out->data = "success";
					}else{
						$out->data = "error";
					}
				}else{
					$out->data = "error";
				}
			}else{
				$out->data = "error";
			}
		}

		// if the query is to set the client key
		if($data->command == "setClientKey"){
			$out->command = "setClientKey";
			$client_query = "UPDATE admin SET client_key='".$data->clientKey."' WHERE id=1";
			$DB->set($client_query);
			$out->data = "success";
			$out->clientKey = $data->clientKey;
		}
		// return the output
		echo json_encode($out);
		//echo "good";
	}
?>