<?php
	include "mylib.php";
	include "clientPreviledge.php";

	if(count($_POST)>0){// check if there are post data
		$data = json_decode($_POST["data"]);
    	// output data
    	$out;

    	// getting the temporary items for display
    	if($data->command == "tempItems"){
    		$out->command = "tempItems";
    		$names ="";
    		$quantities ="";
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
		/*		if($tempOrder[1]["take_out"] == "T"){
					$out->urlData .= "true";
				}else{*/
					$out->urlData .= $tempOrder[1]["table_meal"];
		//		}
				$out->urlData = str_replace(" ", "#", $out->urlData);
	    		$out->status = "success";
	    	}
		}
		if($data->command == "deleteOrder"){
    		$out->command = "deleteOrder";
    		$DB->set("DELETE FROM bolaloan.temp_items_ordered WHERE order_id=".$data->id);
    		$DB->set("DELETE FROM bolaloan.temp_order WHERE id=".$data->id);
    		$out->status = "success";
		}
		echo json_encode($out);
	}
?>