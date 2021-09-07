<?php
	include "mylib.php";
	include "adminPreviledge.php";
	//-- check for data in the post
	if($_POST){
	//	echo $_POST["data"];
		$data = json_decode($_POST["data"]);
		$check = json_decode($data->check);
		$items = json_decode($data->items);
		$query = "UPDATE items SET ";

		//-- for price setting
		if($check[0]){ // check if price is enabled
			$query .= " price=".$data->price;
			if($check[1] || $check[2]){
				$query .= ", ";
			}
		}

		//-- for type setting
		if($check[1]){ // check if type is enabled
			if($data->type == "Food"){
				$data->type = "F";
			}else{
				$data->type = "D";
			}
			$query .= " type='".$data->type."'";
			if($check[2]){
				$query .= ", ";
			}
		}
		// -- for quantity setting
		if($check[2]){ // check if quantity is enabled
			if($data->quantity == "Whole"){
				$data->quantity = "W";
			}else{
				$data->quantity = "H";
			}
			$query .= " quantity='".$data->quantity."'";
		}
		$query .= " WHERE name IN(";
		// name of items that will be updated
		if(count($items) >= 1){
			$query .= "'".$items[0]."'";
			for($i=1; $i<count($items); $i++){
				$query .= ", '".$items[$i]."'";
			}
			$query .= ")";
		}
		$DB->set($query);
		echo "success";
	}
?>