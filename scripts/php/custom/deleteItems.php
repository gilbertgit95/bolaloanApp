<?php
	include "mylib.php";
	include "adminPreviledge.php";
	
	// check for the post request
	$prompt = "none";
	if(count($_POST)>0){
		$data = json_decode($_POST["data"]);
	//echo json_encode($data[$i]);
	// delete query
		$delete_query = "DELETE FROM items WHERE name IN(";
		$query = "";
		if(count($data)>0){
			$query .= "'".$data[0]."'";
			for($i=1; $i<count($data); $i++){
				$query .= ", '".$data[$i]."'";
			}
		}
		$query .= ")";

	// select query
	/*	$delete_file = "SELECT image FROM items WHERE name IN(";
		$delete_file .= $query;
		$files = $DB->read($delete_file);
		for($i=0; $i<$files[0]["length"]; $i++){
			unlink("../../../".$files[i]);
		}
		$delete_file .= $query; */

	//delete data
		$delete_query .= $query;
		$DB->set($delete_query);
		$prompt = "success";
		echo $prompt;
	}

	//--- redirecting to other webpage
?>