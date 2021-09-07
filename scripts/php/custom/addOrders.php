<?php
	include "mylib.php";
	include "adminPreviledge.php";

	if(count($_POST)>0){// check if there are post data
		//-- parsing the post data
		$data = json_decode($_POST["data"]);
		//-- parsing items data into array variables
		$names = json_decode($data->name);
		$price = json_decode($data->price);
		$numOrder = json_decode($data->numOrder);
		$type = json_decode($data->type);
		$total = $data->total;
		$takeout = $data->takeout;
		$table = $data->tableMeal;

		if($takeout){ // check the if takeout or not
			$takeout = "T";
		}else{
			$takeout = "F";
		}

		// query for order table
		$order_query = "INSERT INTO bolaloan.temp_order(take_out, total, table_meal) VALUES('".$takeout."',".$total." ,'".$table."');";
		$DB->set($order_query);
		//echo $order_query;

		// get the last row in the table
		$last_row = $DB->read("SELECT id FROM bolaloan.temp_order WHERE id=(SELECT MAX(id) FROM bolaloan.temp_order)");
		$last_id = $last_row[1]["id"];
	//	$last_id = 100;

		// query for adding to items order table
		$order_items_query = "INSERT INTO bolaloan.temp_items_ordered(order_id, name, price, num_ordered, type) VALUES ";
		
		// -- loop for the values
		$values[0] ="(".$last_id.", '".$names[0]."', ".$price[0].", ".$numOrder[0].", '".$type[0]."')";
		for($i=1; $i<count($names); $i++){
			$values[$i] =", (".$last_id.", '".$names[$i]."', ".$price[$i].", ".$numOrder[$i].", '".$type[$i]."')";
		}
		
		//attaching the values to the query
		for($i=0; $i<count($names); $i++){
			$order_items_query .= $values[$i];
		}

	//	echo $last_id;
		$DB->set($order_items_query);
		echo "success";
	}
?>