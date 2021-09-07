<?php
	// external library
	// library for database and encription object
	include "../scripts/php/custom/mylib.php";
	include "../scripts/php/custom/clientPreviledge.php";
?>
<!doctype html>
<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="../libraries/style/bootstrap/css/bootstrap.min.css" />
		<title>Client: Items</title>
		<script type="text/javascript" src="../libraries/js/respond.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="../customStyles/all.css" />
		<style type="text/css" rel="stylesheet" >
			.items{
				margin: 10px;
				margin-top: 20px;
				padding: 20px;
				font-size: 14pt;
				border-radius: 5px;
				border: 1px solid black;
			}
			.items div div img{
				border-radius: 10px;
			}
			.selected{
				background-color: #b24905;
				color: #ff6c00;
			}
			.prompt-box{
				padding: 10px;
			}
			.page-head{
				font-size: 8px;
				word-spacing: 10px;
			}
		</style>
	</head>

	<body class="gray-back">
		<div class="container orange-back natural-form natural-border">
			<div class="raw">
				<div class="col-xs-12 nat-border-bot page-head lightbrown-color">
					<a class="lightbrown-color" href="clientCollector.php"><span class="glyphicon glyphicon-shopping-cart"></span>Collector</a> | 
					<a class="current-used"><span class="glyphicon glyphicon-list-alt"></span>Items</a> |
					<a id="temp_orders" title="" href="clientOrders.php" class="lightbrown-color">orders <span class="glyphicon glyphicon-option-horizontal"></span></a> |
					<span id="logout" title="sign out collector" class="lightbrown-color">logout <span class="glyphicon glyphicon-log-out"></span></span>
				</div>
				<div class="col-xs-12 page-content brown-color">
					<div class="raw">
						<div class="col-xs-12 col-md-6 item-pane food">
							<div class="raw">
								<?php
									// access the food and drink items
									$foodItems = $DB->read("SELECT * FROM items WHERE type='F'");
									$drinkItems = $DB->read("SELECT * FROM items WHERE type='D'");
									// looping throught the food items
									for($i=1; $i<$foodItems[0]["length"]; $i++){
										if($foodItems[$i]["quantity"]=="W"){
											$foodItems[$i]["quantity"]="1/order";
										}else{
											$foodItems[$i]["quantity"]="1/2 order";
										}
										echo '<div class="col-xs-12 items lightbrown-back">';
											echo '<div class="raw">';
												echo '<div class="col-xs-12 col-sm-6 col-md-4">';
													echo '<img class="img-responsive" src="../'.$foodItems[$i]["image"].'" />';
												echo '</div>';
												echo '<div class="col-xs-12 col-sm-6 col-md-8">';
													echo '<span>'.$foodItems[$i]["name"].'</span><br />';
													echo '<span>'.$foodItems[$i]["price"].'</span><br />';
													echo '<span>'.$foodItems[$i]["quantity"].'</span><br />';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									}
								?>
							</div>
						</div>

						<div class="col-xs-12 col-md-6 item-pane drinks">
							<div class="raw">
								<?php
									// looping throught the drink items
									for($i=1; $i<$drinkItems[0]["length"]; $i++){
										if($drinkItems[$i]["quantity"]=="W"){
											$drinkItems[$i]["quantity"]="1/order";
										}else{
											$drinkItems[$i]["quantity"]="1/2 order";
										}
										echo '<div class="col-xs-12 items lightbrown-back">';
											echo '<div class="raw">';
												echo '<div class="col-xs-12 col-sm-6 col-md-4">';
													echo '<img class="img-responsive" src="../'.$drinkItems[$i]["image"].'" />';
												echo '</div>';
												echo '<div class="col-xs-12 col-sm-6 col-md-8">';
													echo '<span>'.$drinkItems[$i]["name"].'</span><br />';
													echo '<span>'.$drinkItems[$i]["price"].'</span><br />';
													echo '<span>'.$drinkItems[$i]["quantity"].'</span><br />';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../libraries/js/jquery-2.2.1.min.js" ></script>
		<script type="text/javascript" src="../libraries/js/jquery-cookie.js" ></script>
		<script type="text/javascript" src="../libraries/style/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="../scripts/js/clientLogout.js" ></script>
		<script type="text/javascript" >
			$(document).ready(function(){
				logout();
			});
		</script>
	</body>
</html>