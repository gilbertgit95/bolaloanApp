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
		<title>Client: Orders</title>
		<script type="text/javascript" src="../libraries/js/respond.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="../customStyles/all.css" />
		<style type="text/css" rel="stylesheet" >
			.items{
				margin: 10px;
				margin-top: 10px;
				padding: 20px;
				font-size: 8pt;
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
			.temp-orders{
				padding: 5px;
				padding-bottom: 40px;
				margin: 10px;
				font-size: 8pt;
				border-top: 2px solid #C45B07;
			}
			.orders div span{
				padding: 5px;
			}
			.items-box{
				text-align: right;
			}
			.items-box div span{
				font-size: 8pt;
				margin: 5px;
			}
			.items-box div{
				padding: 5px;
			}
			.items-box div:nth-child(2n-1){
				background-color: #C45B07;
			}
			.button{
				font-size: 7px;
				padding: 5px;
			}
			.page-head{
				font-size: 8px;
				word-spacing: 10px;
			}
			.table-responsive{
				border:3px solid #ff6c00;
			}
		</style>
	</head>

	<body class="gray-back">
		<div class="container orange-back natural-form natural-border">
			<div class="raw">
				<div class="col-xs-12 nat-border-bot page-head lightbrown-color">
					<a class="lightbrown-color" href="clientCollector.php"><span class="glyphicon glyphicon-shopping-cart"></span>Collector</a> | 
					<a class="lightbrown-color" href="clientItems.php"><span class="glyphicon glyphicon-list-alt"></span>Items</a> |
					<a id="temp_orders" title="" class="current-used">orders <span class="glyphicon glyphicon-option-horizontal"></span></a> |
					<span id="logout" title="sign out collector" class="lightbrown-color">logout <span class="glyphicon glyphicon-log-out"></span></span>
				</div>
				<div class="col-xs-12 page-content brown-color">
					<div class="raw">
						<div class="col-xs-12">
							<h3><span class="glyphicon glyphicon-certificate"></span></span> Temporary orders</h3>
							<div id="temp-submitted-order">
							<?php
								// fetch data from temporary orders in the database
								$tempOrders = $DB->read("SELECT * FROM bolaloan.temp_order ORDER BY id DESC");
								if($tempOrders[0]["length"]>1){
									for($i=1; $i<$tempOrders[0]["length"]; $i++){
										echo '<div class="raw temp-orders orders ">';
											echo '<div class="col-xs-12">';
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
												echo '<span class="hide items-id">'.$tempOrders[$i]["id"].'</span><span class="button view-temp-order" >view <span class="glyphicon glyphicon-eye-open"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$tempOrders[$i]["total"].'</span>';
												if($tempOrders[$i]["take_out"] == "T"){
													echo "<span>takeout</span>";
												}else{
													echo "<span>".$tempOrders[$i]["table_meal"]."</span>";
												}
												
											echo '</div>';
										echo '</div>';
									}
								}
								//echo "now";
							?>
							</div>
						</div>
					
					</div>
				</div>
			</div>
		</div>
		<!--______________________________________ modal box for statistics______________________________________________-->
											<div class="modal fade" id="view-temp-order" role="dialog" aria-labelledby="viewTempOrder" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="viewTempOrder">
																<span class="glyphicon glyphicon-eye-open"></span> Order
															</h4>
														</div>
														<div class="modal-body">
														</div>
														<div class="modal-footer">
															<button class="button" data-dismiss="modal">
																Cancel
															</button>
															<button id="temp-order-edit" class="button">
																<span class="glyphicon glyphicon-edit"></span> edit
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
		<script type="text/javascript" src="../libraries/js/jquery-2.2.1.min.js" ></script>
		<script type="text/javascript" src="../libraries/js/jquery-cookie.js" ></script>
		<script type="text/javascript" src="../libraries/style/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="../scripts/js/clientLogout.js" ></script>
		<script type="text/javascript" >
			var tempVals = new function(){
				this.urlData;
				this.id;
			};
			var OrderClass = function(){
				this.id;
				this.view = function(nput){
					var id = nput.parents(".orders").find(".items-id").text();
					this.id = id;
					tempVals.id = id;
					var tempItemsBox = $("#view-temp-order");
					var out = {
						command: "tempItems",
						data: id,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/clientOrders.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "tempItems"){
								if(newData.status == "success"){
									tempItemsBox.find(".modal-body").html(newData.data);
									tempVals.urlData = newData.urlData+"&id=:" + id;
								}else{
									// error query
									tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
								}
							}else{
								// error query
								tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
							}
						}
					});
					tempItemsBox.modal("toggle");
					//alert(id);
				};
				this.edit = function (nput){
					//alert(tempVals.urlData);
					var out = {
						command: "deleteOrder",
						id: tempVals.id,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/clientOrders.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);
							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "deleteOrder"){
								if(newData.status == "success"){
									window.location = "clientCollector.php?command=edit&"+tempVals.urlData;
								}else{
									// error query
									tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
								}
							}else{
								// error query
								tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
							}
						}
					});
				};
			};
			var orders = new OrderClass();

			// _______________________temp orders events______________________
			var OrderEventsClass = function(){
				this.init = function(){
					this.view();
					this.edit();
				};
				this.view = function(){
					$(".view-temp-order").bind("click", function(){
						orders.view($(this));
					});
				};
				this.edit = function(){
					$("#temp-order-edit").bind("click", function(){
						orders.edit($(this));
					});
				};
			};
			var orderEvents = new OrderEventsClass();
			$(document).ready(function(){
				logout();
				orderEvents.init();
			});
		</script>
	</body>
</html>