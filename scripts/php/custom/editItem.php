<?php
	include "mylib.php";
	include "adminPreviledge.php";
	
	$warning = "none";
	$prompt = "none";
	$default_photo = "files/images/items/";

	if(count($_POST)){
		$data = json_decode($_POST["data"]);
		$check = json_decode($data->check);
		$set_query = "UPDATE items SET";

		//-- for name setting
		if($check[0]){ // check if name is enabled
			if($data->newName === $data->oldName){
				$prompt = "name_unchanged";
			}else{
				$sameName = $DB->read("SELECT id FROM items WHERE name='".$data->newName."'");
				if($sameName[0]["length"] <= 1){ // new name has the same name in the list
					$set_query .= " name='".$data->newName."'";
					if($check[1] || $check[2] || $check[3] || $check[4]){
						$set_query .= ", ";
					}
				}else{
					$warning = "item_has_same_name";
					header("Location: ../../../pages/items.php?prompt=".$prompt."&warning=".$warning);
					exit();
				}
			}
		}

		//-- for price setting
		if($check[1]){ // check if price is enabled
			$set_query .= " price=".$data->price;
			if($check[2] || $check[3] || $check[4]){
				$set_query .= ", ";
			}
		}

		//-- for type setting
		if($check[2]){ // check if type is enabled
			if($data->type === "Food"){
				$data->type = "F";
				$default_photo .="food/";
			}else{
				$data->type = "D";
				$default_photo .="drinks/";
			}
			$set_query .= " type='".$data->type."'";
			if($check[3] || $check[4]){
				$set_query .= ", ";
			}
		}else{// if type is disabled the type from items db will be used
			$getType = $DB->read("SELECT type FROM items WHERE name='".$data->oldName."'");
			if($getType[0]["length"] > 1){
				if($getType[1]["type"] === "F"){
					$default_photo .="food/";
				}else{
					$default_photo .="drinks/";
				}
			}
		}

		//-- for quantity setting
		if($check[3]){ // check if type is enabled
			if($data->quantity === "Whole"){
				$data->quantity = "W";
			}else{
				$data->quantity = "H";
			}
			$set_query .= " quantity='".$data->quantity."'";
			if($check[4]){
				$set_query .= ", ";
			}
		}

		// for image settings
		if($check[4]){
			if(count($_FILES)>0){ // if there is a files uploaded
					// check the length of the image file
					if(count($_FILES["photo"]["name"]) <= 20){
						if($_FILES["photo"]["size"]==0){// if empty
				        	$warning = "image_is_empty";
				        }else{
				        	if($_FILES["photo"]["size"]<5000000){
				        		$allowedFileTypes  =  array("image/gif",  "image/jpeg",  "image/pjpeg", "image/png", "image/jpg", "image/JPEG");
					        	if(in_array($_FILES["photo"]["type"],  $allowedFileTypes)) {//allowed types
					        		$default_photo .= rand().time().$_FILES["photo"]["name"];
							        move_uploaded_file($_FILES["photo"]["tmp_name"], "../../../".$default_photo);
								}else{
									$warning = "error_file_type";
								}
					    	}else{
					    		$warning = "image_is_big";
					    	}
				        }
					}else{
						$warning = "image_name_is_big";
					}
			}
			$set_query .= "image='".$default_photo."'";
		}

		// last command in sql for updating an item
		$set_query .= " WHERE name='".$data->oldName."'";

		// executing the query on the database
		//if(!$warning == "item_has_same_name"){
		$DB->set($set_query);
		//}
		//echo $set_query;
		$prompt = "success";

		//--- redirecting to other webpage
		header("Location: ../../../pages/items.php?prompt=".$prompt."&warning=".$warning);
		exit();
	}

?>