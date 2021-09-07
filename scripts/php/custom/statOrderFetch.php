<?php
	include "mylib.php";
	include "adminPreviledge.php";
	
	// check post data
    if(count($_POST)>0){
    	// decode input data from post
    	$data = json_decode($_POST["data"]);
    	// output data
    	$out;

    	// getting the temporary items for display
    	if($data->command == "tempItems"){
    		$out->command = "tempItems";
    		// fetch from the database
    		$names ="names";
    		$quantities ="quantities";
    		$tempItems = $DB->read("SELECT name, price, num_ordered FROM bolaloan.temp_items_ordered WHERE order_id=".$data->data);
    		$tempOrder = $DB->read("SELECT * FROM bolaloan.temp_order WHERE id=".$data->data);
    		if($tempItems[0]["length"] > 1){
	    		$total = 0;
	    		$subTotal=0;
	    		$out->data = '<div class="items-box table-responsive">';
	    		for($i=1; $i<$tempItems[0]["length"]; $i++){
	    			$subTotal = floatval($tempItems[$i]["price"]) * floatval($tempItems[$i]["num_ordered"]);
	    			$total += $subTotal;
	    			$out->data .= '<div><span><b>'.$tempItems[$i]["name"].'</b></span> <span><i>P </i>'.$tempItems[$i]["price"].'</span> <span><i>x </i>'.$tempItems[$i]["num_ordered"].'</span> <span><i>P </i>'.$subTotal.'</span></div>';
					$names .=":".$tempItems[$i]["name"];
					$quantities .=":".floatval($tempItems[$i]["num_ordered"]);
				}
				$out->data .= '<div><b>Total</span><span><i>P </i>'.$total.'</b></div>';
				$out->data .= '</div>';
				$out->urlData = "names=".$names."&quantities=".$quantities."&takeout=:";
			/*	if($tempOrder[1]["take_out"] == "T"){
					$out->urlData .= "true";
				}else{*/
					$out->urlData .= $tempOrder[1]["table_meal"];
			//	}
				$out->urlData = str_replace(" ", "#", $out->urlData);
	    		$out->status = "success";
	    	}
    	}

    	// get the final ordered items for display
    	if($data->command == "verifiedItems"){
    		$out->command = "verifiedItems";
    		// fetch from the database
    		$tempItems = $DB->read("SELECT name, price, num_ordered FROM bolaloan.items_ordered WHERE order_id=".$data->data);
    		if($tempItems[0]["length"] > 1){
	    		$total = 0;
	    		$subTotal=0;
	    		$out->data = '<div class="items-box table-responsive">';
	    		for($i=1; $i<$tempItems[0]["length"]; $i++){
	    			$subTotal = floatval($tempItems[$i]["price"]) * floatval($tempItems[$i]["num_ordered"]);
	    			$total += $subTotal;
	    			$out->data .= '<div><span><b>'.$tempItems[$i]["name"].'</b></span> <span><i>P </i>'.$tempItems[$i]["price"].'</span> <span><i>x </i>'.$tempItems[$i]["num_ordered"].'</span> <span><i>P </i>'.$subTotal.'</span></div>';
				}
				$out->data .= '<div><b>Total</span><span><i>P </i>'.$total.'</b></div>';
				$out->data .= '</div>';
	    		$out->status = "success";
	    	}
    	}

    	// decline order
    	// delete the specific order and items
    	if($data->command == "declineOrder"){
    		$out->command = "declineOrder";
    		// delete order and items
    		$DB->set("DELETE FROM temp_order WHERE id=".$data->data);
    		$DB->set("DELETE FROM temp_items_ordered WHERE order_id=".$data->data);
    		$out->data = '';
    		$tempOrders = $DB->read("SELECT * FROM bolaloan.temp_order ORDER BY id DESC");
								if($tempOrders[0]["length"]>1){
									for($i=1; $i<$tempOrders[0]["length"]; $i++){
										$out->data .= '<div class="raw temp-orders orders ">';
											$out->data .= '<div class="col-xs-12">';
												//$itemsHour = substr($tempOrders[$i]["date"], 11, 2);
												// format the time
												$itemsHour = intval(substr($tempOrders[$i]["date"], 11, 2));
												$itemsMinute = intval(substr($tempOrders[$i]["date"], 14, 2));
												$itemsDay = "am";
												if($itemsHour > 11){
													$itemsDay = "pm";
												}
												if($itemsHour == 0){
													$itemsHour = 12;
												}else if($itemsHour > 12){
													$itemsHour -= 12;
												}
												$out->data .= '<span class="hide items-id">'.$tempOrders[$i]["id"].'</span><span class="button view-temp-order" >view <span class="glyphicon glyphicon-eye-open"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$tempOrders[$i]["total"].'</span>';
												if($tempOrders[$i]["take_out"] == "T"){
													$out->data .= "<span>takeout</span>";
												}else{
													$out->data .= "<span>".$tempOrders[$i]["table_meal"]."</span>";
												}
												
											$out->data .= '</div>';
										$out->data .= '</div>';
									}
								}                                                                                                                                                                                                                                                                                                                  
	    	$out->status = "success";
    	}

    	// refresh the orders in the temporary display
    	if($data->command == "refreshTempItems"){
    		$out->command = "refreshTempItems";
    		$out->data = '';
    		$tempOrders = $DB->read("SELECT * FROM bolaloan.temp_order ORDER BY id DESC");
								if($tempOrders[0]["length"]>1){
									for($i=1; $i<$tempOrders[0]["length"]; $i++){
										$out->data .= '<div class="raw temp-orders orders ">';
											$out->data .= '<div class="col-xs-12">';
												//$itemsHour = substr($tempOrders[$i]["date"], 11, 2);
												// format the time
												$itemsHour = intval(substr($tempOrders[$i]["date"], 11, 2));
												$itemsMinute = intval(substr($tempOrders[$i]["date"], 14, 2));
												$itemsDay = "am";
												if($itemsHour > 11){
													$itemsDay = "pm";
												}
												if($itemsHour == 0){
													$itemsHour = 12;
												}else if($itemsHour > 12){
													$itemsHour -= 12;
												}
												$out->data .= '<span class="hide items-id">'.$tempOrders[$i]["id"].'</span><span class="button view-temp-order" >view <span class="glyphicon glyphicon-eye-open"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$tempOrders[$i]["total"].'</span>';
												if($tempOrders[$i]["take_out"] == "T"){
													$out->data .= "<span>takeout</span>";
												}else{
													$out->data .= "<span>".$tempOrders[$i]["table_meal"]."</span>";
												}
												
											$out->data .= '</div>';
										$out->data .= '</div>';
									}
								}                                                                                                                                                                                                                                                                                                                  
	    	$out->status = "success";
    	}
    	if($data->command == "deleteOrder"){
    		$out->command = "deleteOrder";
    		// delete order and items
    		$DB->set("DELETE FROM bolaloan.order WHERE id=".$data->data);
    		$DB->set("DELETE FROM bolaloan.items_ordered WHERE order_id=".$data->data);
    		$out->data = '';
									// fetch ordered items in the database
									$verifiedOrders = $DB->read("SELECT * FROM `bolaloan`.`order` WHERE cast(`order`.`date` as date)='".$data->date."' ORDER BY id DESC");
									$total["meal"] = 0;
									$total["takeout"] = 0;
									$total["all"] = 0;
									if($verifiedOrders[0]["length"]>1){
										for($i=1; $i<$verifiedOrders[0]["length"]; $i++){
											$out->data .= '<div class="raw orders verified-orders">';
												$out->data .= '<div class="col-xs-12">';
													$itemsHour = intval(substr($verifiedOrders[$i]["date"], 11, 2));
													$itemsMinute = intval(substr($verifiedOrders[$i]["date"], 14, 2));
													$itemsDay = "am";
													if($itemsHour > 11){
														$itemsDay = "pm";
													}
													if($itemsHour == 0){
														$itemsHour = 12;
													}else if($itemsHour > 12){
														$itemsHour -= 12;
													}
													$out->data .= '<span class="hide items-id">'.$verifiedOrders[$i]["id"].'</span><span class="small-button view-verified" >view <span class="glyphicon glyphicon-eye-open"></span></span><span class="small-button delete-items" >delete <span class="glyphicon glyphicon-trash"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$verifiedOrders[$i]["total"].'</span>';
													// test if theres a order is takeout
													$out->data .= "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
													if($verifiedOrders[$i]["table_meal"] == "takeout"){
											//			$out->data .= "<span>takeout</span>";
														$total["takeout"] += $verifiedOrders[$i]["total"];
													}else{
											//			$out->data .= "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
														$total["meal"] += $verifiedOrders[$i]["total"];
													}
												$out->data .= '</div>';
											$out->data .= '</div>';
										}
										$total["all"] = $total["meal"] + $total["takeout"];
									}
								$out->data .= '<div class="raw orders verified-orders">';
								$out->data .= '<div class="col-xs-12 total-display">';
								$out->data .= '<h4><span>takeout: P<i>'.$total["takeout"].'</i></span> <span>meal: P<i>'.$total["meal"].'</i></span><span><span class="glyphicon glyphicon-info-sign"></span> total: P<b>'.$total["all"].'</b></span></h4>';		
								$out->data .= '</div>';
								$out->data .= '</div>';
    		$out->status = "success";
    	}

    // transfer orders from temporary to final database
    	if($data->command == "transferOrder"){
    		$out->command = "transferOrder";
    		$out->status = "success";

    		// fetch order and items
    		$order = $DB->read("SELECT * FROM bolaloan.temp_order WHERE id=".$data->data);
    		$order_items = $DB->read("SELECT * FROM bolaloan.temp_items_ordered WHERE order_id=".$data->data);

    		// delete order and items in the temporary table
    		$DB->set("DELETE FROM temp_order WHERE id=".$data->data);
    		$DB->set("DELETE FROM temp_items_ordered WHERE order_id=".$data->data);

    		// check the order and items if there are data inside
    		// then add to the final record
    		if($order[0]["length"]>=1 && $order_items[0]["length"]>=1){
    			// add the order
    			$insertOrder = "INSERT INTO bolaloan.order(take_out, total, table_meal) VALUES ('".$order[1]["take_out"]."', ".$order[1]["total"].",'".$order[1]["table_meal"]."')";
    			$DB->set($insertOrder);

    			// get the last row in the table
				$last_row = $DB->read("SELECT id FROM bolaloan.order WHERE id=(SELECT MAX(id) FROM bolaloan.order)");
				$last_id = $last_row[1]["id"];

    			$insertItems = "INSERT INTO bolaloan.items_ordered(order_id, name, price, num_ordered, type) VALUES ";
    			$insertItems .="(".$last_id.", '".$order_items[1]['name']."', ".$order_items[1]['price'].", ".$order_items[1]['num_ordered'].", '".$order_items[1]['type']."')";
    			for($i=2; $i<$order_items[0]["length"]; $i++){
    				$insertItems .=", (".$last_id.", '".$order_items[$i]['name']."', ".$order_items[$i]['price'].", ".$order_items[$i]['num_ordered'].", '".$order_items[$i]['type']."')";
    			}
    			$out->data = $insertItems;
    			// transfer data from the temporary record to final record
    			//$DB->set($insertOrder);
    			$DB->set($insertItems);
    		}
    	}
    	if($data->command == "deleteTempOrder"){
    		$out->command = "deleteTempOrder";
    		$DB->set("DELETE FROM bolaloan.temp_items_ordered WHERE order_id=".$data->id);
    		$DB->set("DELETE FROM bolaloan.temp_order WHERE id=".$data->id);
    		$out->status = "success";
		}
		if($data->command == "ordersByDate"){
    		$out->command = "ordersByDate";
    		$out->data = "";
    		$verifiedOrders = $DB->read("SELECT * FROM bolaloan.order WHERE cast(date as date)='".$data->data."' ORDER BY id DESC");
									$total["meal"] = 0;
									$total["takeout"] = 0;
									$total["all"] = 0;
									if($verifiedOrders[0]["length"]>1){
										for($i=1; $i<$verifiedOrders[0]["length"]; $i++){
											$out->data .= '<div class="raw orders verified-orders">';
												$out->data .= '<div class="col-xs-12">';
													$itemsHour = intval(substr($verifiedOrders[$i]["date"], 11, 2));
													$itemsMinute = intval(substr($verifiedOrders[$i]["date"], 14, 2));
													$itemsDay = "am";
													if($itemsHour > 11){
														$itemsDay = "pm";
													}
													if($itemsHour == 0){
														$itemsHour = 12;
													}else if($itemsHour > 12){
														$itemsHour -= 12;
													}
													$out->data .= '<span class="hide items-id">'.$verifiedOrders[$i]["id"].'</span><span class="small-button view-verified" >view <span class="glyphicon glyphicon-eye-open"></span></span><span class="small-button delete-items" >delete <span class="glyphicon glyphicon-trash"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$verifiedOrders[$i]["total"].'</span>';
													// test if theres a order is takeout
													$out->data .= "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
													if($verifiedOrders[$i]["table_meal"] == "takeout"){
											//			$out->data .= "<span>takeout</span>";
														$total["takeout"] += $verifiedOrders[$i]["total"];
													}else{
											//			$out->data .= "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
														$total["meal"] += $verifiedOrders[$i]["total"];
													}
												$out->data .= '</div>';
											$out->data .= '</div>';
										}
										$total["all"] = $total["meal"] + $total["takeout"];
										$out->data .= '<div class="raw orders verified-orders">';
											$out->data .= '<div class="col-xs-12 total-display">';
												 $out->data .= '<h4><span>takeout: P<i>'.$total["takeout"].'</i></span> <span>meal: P<i>'.$total["meal"].'</i></span><span><span class="glyphicon glyphicon-info-sign"></span> total: P<b>'.$total["all"].'</b></span></h4>';
											$out->data .= '</div>';
										$out->data .= '</div>';
									}else{
										$out->data .= '<h4><span class="glyphicon glyphicon-exclamation-sign"></span> No data entry.</h4>';
									}
								
    		$out->status = "success";
    	}
    	echo json_encode($out);
    }
?>