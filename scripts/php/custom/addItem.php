<?php
	include "mylib.php";
	include "adminPreviledge.php";
	
	// check post data
    if(count($_POST)<2){
		// decode jason from being a string
		$data =  json_decode($_POST["data"]);
		$default_photo = "files/images/items/";
		$prompt = "none";
		$warning = "none";

		//--- check the item if existed on the table
		$test_query = "SELECT id FROM items WHERE name='".$data->name."'";
		$test_item = $DB->read($test_query);
		//--- test the if have the same name then execute some functions
		if($test_item[0]["length"] <= 1){
			//--- check the type of item
			if($data->type==="Food"){
				$data->type="F";
				$default_photo .="food/";
			}else{
				$data->type="D";
				$default_photo .="drinks/";
			}
			// check the quantity
			if($data->quantity==="Whole"){
				$data->quantity="W";
			}else{
				$data->quantity="H";
			}
			//--- check if the image is checked or enabled
			if($data->image){
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
			}

			//--- insert query
			$add_query = "INSERT INTO items(name, price, type, quantity, image) VALUES(";
			$add_query .="'".$data->name."', ";
			$add_query .=	$data->price.", ";
			$add_query .="'".$data->type."', ";
			$add_query .="'".$data->quantity."', ";
			$add_query .="'".$default_photo."'";
			$add_query .=")";
			
			// for testing query
			//echo $add_query;
			//-- executing query to database
			$DB->set($add_query);

			//$prompt = $add_query;
			$prompt = "item_successful_added";
		}else{
			$warning = "has_same_name";
		}

		//--- redirecting to other webpage
		header("Location: ../../../pages/items.php?prompt=".$prompt."&warning=".$warning);
		exit();
	}
?>