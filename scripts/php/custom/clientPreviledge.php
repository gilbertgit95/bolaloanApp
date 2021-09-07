<?php
	//----- test user previledge
			$key = $_COOKIE["collectorKey"];
			$clientRandKeys = $DB->read("SELECT * FROM `temp_keys` WHERE admin='F'");
			// check the length of the keys
			if($clientRandKeys[0]["length"]>1){

				$tempStatus = false;
				for($i=1; $i<$clientRandKeys[0]["length"]; $i++){
					if($clientRandKeys[$i]["key"] == $key){
						// no action
						$tempStatus = true;
						break;
					}else{
						$tempStatus = false;
					}
				}
				if(!$tempStatus){
					header("Location: ../index.html");
					exit();
				}
			}else{
				header("Location: ../index.html");
				exit();
			}		

	//------- end of test previledge
?>