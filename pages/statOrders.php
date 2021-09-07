<?php
	include "../scripts/php/custom/mylib.php";
	include "../scripts/php/custom/adminPreviledge.php";
?>
<!doctype html>
<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="../libraries/style/bootstrap/css/bootstrap.min.css" />
		<title>Admin: Orders Statistics</title>
		<script type="text/javascript" src="../libraries/js/respond.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="../customStyles/all.css" />
		<style type="text/css" rel="stylesheet" >
			.temp-orders{
				padding: 20px;
				padding-bottom: 40px;
				margin: 20px;
				font-size: 13pt;
				border-top: 2px solid #C45B07;
			}
			.verified-orders{
				padding: 10px;
				padding-bottom: 20px;
				margin: 5px;
				margin-bottom: 20px;
				font-size: 9pt;
				border-top: 1px solid #C45B07;
			}
			.orders div span{
				padding: 10px;
				padding-right: 15px;
			}
			.small-button{
				color: #ff6c00;
				background-color: #300a02;
				padding: 5px;
				padding-left: 10px;
				padding-right: 5px;
				border: none;
				border-radius: 5px;
				font-size: 8pt;
				margin-right: 10px;
			}
			.small-button:hover {
				color: white;
			}
			.items-box{
				text-align: right;
			}
			.items-box div span{
				font-size: 14pt;
				margin: 20px;
			}
			.items-box div{
				padding: 20px;
			}
			.items-box div:nth-child(2n-1){
				background-color: #C45B07;
			}
			#calendar{
				padding: 5px;
				font-size: 12px;
				margin-bottom: 20px;
				margin-left: 50px;
			}
			#order-items-list{
				
			}
			.total-display{
				position: fixed;
				top: 85%;
				left: 50%;
				border-radius: 10px;
				box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.2);
				background-color: #ff6c00;
			}
		</style>
	</head>

	<body class="gray-back">
		<div class="container orange-back natural-form natural-border">
			<div class="raw">
				<div class="col-xs-12 nat-border-bot page-head lightbrown-color">
					<a class="lightbrown-color" href="collector.php"><span class="glyphicon glyphicon-shopping-cart"></span>Collector</a> | 
					<a class="lightbrown-color" href="items.php"><span class="glyphicon glyphicon-list-alt"></span>Items</a> | 
					<span class="current-used" id="stat-btn"><span class="glyphicon glyphicon-stats"></span>Stat</span> |
					<span class="" id="set-btn"><span class="glyphicon glyphicon-cog"></span>Settings</span>
					<div class="drop-down-list hide normal-shadow bot-right-border" id="settings">
						<ul class="">
							<li data-target="#security-key" data-toggle="modal"><a>Security keys</a></li>
							<li data-target="#client-key" data-toggle="modal"><a>Collector key</a></li>
							<li id="log-out-btn" class="admin"><a>Logout</a></li>
						</ul>
					</div>
					<div class="drop-down-list hide normal-shadow bot-right-border" id="stat">
						<ul>
							<li><a>Ordered <span class="glyphicon glyphicon-check"></span></a></li>
							<li><a href="statItemOrders.php">Items Ordered</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 page-content brown-color">
					<div class="raw">
						<div class="col-xs-12 col-md-6 natural-form orange-back">
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
						

						<div class="col-xs-12 col-md-6">
							<h3><span class="glyphicon glyphicon-certificate"></span> 
								<span id="date-display">
									<?php
										echo " <span>".date("M")."</span> <span>".date("d")."</span>, <span>".date("Y")."</span>.";
									?>
								</span> 
								<span class="button" id="calendar" data-target="#calendar-modal" data-toggle="modal" >Choose date <span class="glyphicon glyphicon-calendar"></span></span>
							</h3>

							<div id="order-items-list">
								<?php
									// fetch ordered items in the database
									$verifiedOrders = $DB->read("SELECT * FROM bolaloan.order WHERE date > CURDATE() ORDER BY id DESC");
									$total["meal"] = 0;
									$total["takeout"] = 0;
									$total["all"] = 0;
									if($verifiedOrders[0]["length"]>1){
										for($i=1; $i<$verifiedOrders[0]["length"]; $i++){
											echo '<div class="raw orders verified-orders">';
												echo '<div class="col-xs-12">';
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
													echo '<span class="hide items-id">'.$verifiedOrders[$i]["id"].'</span><span class="small-button view-verified" >view <span class="glyphicon glyphicon-eye-open"></span></span><span class="small-button delete-items" >delete <span class="glyphicon glyphicon-trash"></span></span><span>'.$itemsHour.':'.$itemsMinute.' '.$itemsDay.'</span><span><i>P </i>'.$verifiedOrders[$i]["total"].'</span>';
													// test if theres a order is takeout
													echo "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
													if($verifiedOrders[$i]["table_meal"] == "takeout"){
											//			$out->data .= "<span>takeout</span>";
														$total["takeout"] += $verifiedOrders[$i]["total"];
													}else{
											//			$out->data .= "<span>".$verifiedOrders[$i]["table_meal"]."</span>";
														$total["meal"] += $verifiedOrders[$i]["total"];
													}
												echo '</div>';
											echo '</div>';
										}
										$total["all"] = $total["meal"] + $total["takeout"];
									}
								?>
								<div class="raw orders verified-orders">
									<div class="col-xs-12 total-display">
										<?php
										 echo '<h4><span>takeout: P<i>'.$total["takeout"].'</i></span> <span>meal: P<i>'.$total["meal"].'</i></span><span><span class="glyphicon glyphicon-info-sign"></span> total: P<b>'.$total["all"].'</b></span></h4>';
										?>
									</div>
								</div>
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
																<span class="glyphicon glyphicon-edit"></span> Unapproved order
															</h4>
														</div>
														<div class="modal-body">
														</div>
														<div class="modal-footer">
															<button id="temp-order-decline" class="button">
																Decline
															</button>
															<button class="button" data-dismiss="modal">
																Cancel
															</button>
															<button id="temp-order-edit" class="button">
																<span class="glyphicon glyphicon-edit"></span> edit
															</button>
															<button id="temp-order-approve" class="button">
																Approve
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
											<div class="modal fade" id="view-order" role="dialog" aria-labelledby="viewOrder" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="viewOrder">
																<span class="glyphicon glyphicon-edit"></span> Order
															</h4>
														</div>
														<div class="modal-body">
															
														</div>
														<div class="modal-footer">
															<button class="button" data-dismiss="modal">
																Cancel
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
											<div class="modal fade" id="delete-order" role="dialog" aria-labelledby="deleteOrder" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="deleteOrder">
																<span class="glyphicon glyphicon-edit"></span> Delete order
															</h4>
														</div>
														<div class="modal-body">
															<div class="center">
																<label>Enter CONFIRM word to delete the item</label><br />
																<div class="prompt-box hide"></div>
																<input type="text" class="input-box" id="delete-item" />
															</div>
														</div>
														<div class="modal-footer">
															<button class="button" data-dismiss="modal">
																Cancel
															</button>
															<button id="delete-btn" class="button">
																Delete
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>

											<div class="modal fade" id="calendar-modal" role="dialog" aria-labelledby="calendarModal" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="calendarModal">
																<span class="glyphicon glyphicon-calendar"></span> Calendar
															</h4>
														</div>
														<div class="modal-body">
															<div class="center" >
																<p>Current date:
																	<?php
																		echo " ".date("M")." ".date("d").", ".date("Y").".";
																	?>
																</p>
																<p>Choose date tobe displayed.</p>
																<select class="button calendar-date" id="month-calendar">
																	<option>Jan</option>
																	<option>Feb</option>
																	<option>Mar</option>
																	<option>Apr</option>
																	<option>May</option>
																	<option>Jun</option>
																	<option>Jul</option>
																	<option>Aug</option>
																	<option>Sep</option>
																	<option>Oct</option>
																	<option>Nov</option>
																	<option>Dec</option>
																</select>
																<select class="button calendar-date" id="day-calendar">
																	<option>1</option>
																	<option>2</option>
																	<option>3</option>
																	<option>4</option>
																	<option>5</option>
																	<option>6</option>
																	<option>7</option>
																	<option>8</option>
																	<option>9</option>
																	<option>10</option>
																	<option>11</option>
																	<option>12</option>
																	<option>13</option>
																	<option>14</option>
																	<option>15</option>
																	<option>16</option>
																	<option>17</option>
																	<option>18</option>
																	<option>19</option>
																	<option>20</option>
																	<option>21</option>
																	<option>22</option>
																	<option>23</option>
																	<option>24</option>
																	<option>25</option>
																	<option>26</option>
																	<option>27</option>
																	<option>28</option>
																	<option>29</option>
																	<option>30</option>
																	<option>31</option>
																</select>
																<select class="button calendar-date" id="year-calendar">
																	<option>2025</option>
																	<option>2024</option>
																	<option>2023</option>
																	<option>2022</option>
																	<option>2021</option>
																	<option>2020</option>
																	<option>2019</option>
																	<option>2018</option>
																	<option>2017</option>
																	<option>2016</option>
																</select>
															</div>
														</div>
														<div class="modal-footer">
															<button class="button" data-dismiss="modal">
																Cancel
															</button>
															<button id="view-date" class="button">
																View <span class="glyphicon glyphicon-eye-open"></span>
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
		

		<!--_____________________________________________ settings modal boxes____________________________________________________________-->

											<div class="modal fade" id="security-key" role="dialog" aria-labelledby="securityKey" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="securityKey">
																<span class="glyphicon glyphicon-edit"></span> Change Security Key
															</h4>
														</div>
														<div class="modal-body">
															<div class="prompt-box hide"></div>
															<label>Current username</label><br /><br />
															<input id="currrent_username" type="text" class="input-box" /><br /><br />
															<label>Current password</label><br /><br />
															<input id="currrent_password" type="password" class="input-box" /><br /><br /><br />
															<label>New username</label><br /><br />
															<span class="glyphicon glyphicon-ok-sign checked security-checked"></span> <input id="new_username" type="text" class="input-box" /><br /><br />
															<label>New password</label><br /><br />
															<span class="glyphicon glyphicon-ok-sign checked security-checked"></span> <input id="new_password" type="password" class="input-box" /><br /><br />
														</div>
														<div class="modal-footer">
															<button id="security_key_save" class="button">
																Save
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>

											<div class="modal fade" id="prompt-modal" role="dialog" aria-labelledby="promptBox" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="promptBox">
																Prompt box
															</h4>
														</div>
														<div class="modal-body">
															
														</div>
														<div class="modal-footer">
											
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>

											<div class="modal fade" id="client-key" role="dialog" aria-labelledby="clientKey" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="clientKey">
																<span class="glyphicon glyphicon-edit"></span> Change Client Key
															</h4>
														</div>
														<div class="modal-body center">
															<div class="prompt-box hide"></div>
															<label><b>Current key:</b> <i>8317</i></label><br /><br />
															<label>New client key</label><br /><br />
															<input  id="new_client_key" type="text" class="input-box" /><br /><br />
														</div>
														<div class="modal-footer">
															<button id="save_client_key" class="button">
																Save
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
		<script type="text/javascript" src="../libraries/js/jquery-2.2.1.min.js" ></script>
		<script type="text/javascript" src="../libraries/js/jquery-cookie.js" ></script>
		<script type="text/javascript" src="../libraries/style/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="../scripts/js/pageHead.js" ></script>
		<script type="text/javascript" src="../scripts/js/settings.js" ></script>
		<script type="text/javascript" src="../scripts/js/validation.js" ></script>
		<script type="text/javascript" src="../scripts/js/calendar.js" ></script>
		<script type="text/javascript">
			var tempVals = new function(){
				this.urlData;
				this.id;
			};
			var OrderClass = function(){
				this.id;
				this.edit = function (nput){
					//alert(tempVals.urlData);
					var out = {
						command: "deleteTempOrder",
						id: tempVals.id,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);
							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "deleteTempOrder"){
								if(newData.status == "success"){
									window.location = "collector.php?command=edit&"+tempVals.urlData;
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
//____________________________button proccess______________________________
			// stat buttons object
			var StatButtons = function(){
				this.verifiedId;
				this.unverifiedId;
				this.init = function(){

				};
				this.refreshTempItems = function(){
					var out = {
						command: "refreshTempItems",
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "refreshTempItems"){
								if(newData.status == "success"){
									statButtonEvents.unverifiedUnbind();
									$("#temp-submitted-order").html(newData.data);
									statButtonEvents.viewUnverifiedItems();
									console.log("refresh display");
								}
							}
						}
					});
					statButtonEvents.refreshTempItems();
				};
				this.viewUnverifiedItems = function(nput){
					var id = nput.parents(".orders").find(".items-id").text();
					tempVals.id = id;
					this.unverifiedId = id;
					var tempItemsBox = $("#view-temp-order");
					var out = {
						command: "tempItems",
						data: id,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "tempItems"){
								if(newData.status == "success"){
									tempItemsBox.find(".modal-body").html(newData.data);
									tempVals.urlData = newData.urlData+"&id=" + id;
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
				this.viewVerifiedItems = function(nput){
					var id = nput.parents(".orders").find(".items-id").text();
					this.verifiedId = id;
					var tempItemsBox = $("#view-order");
					var out = {
						command: "verifiedItems",
						data: id,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "verifiedItems"){
								if(newData.status == "success"){
									tempItemsBox.find(".modal-body").html(newData.data);
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
				this.editTempOrder = function (){
					//alert(tempVals.urlData);
					orders.edit();
					//window.location = "collector.php?command=edit&"+tempVals.urlData;
				};
				this.deleteItems = function(nput){
					var id = nput.parents(".orders").find(".items-id").text();
					this.verifiedId = id;
					$("#delete-order").modal("toggle");
					//alert(id);
				};


				this.tempItemsDecline = function(){
					var tempItemsBox = $("#prompt-modal");
					var out = {
						command: "declineOrder",
						data: this.unverifiedId,
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "declineOrder"){
								if(newData.status == "success"){
									statButtonEvents.unverifiedUnbind();
									$("#temp-submitted-order").html(newData.data);
									statButtonEvents.viewUnverifiedItems();
									tempItemsBox.find(".modal-body").html("<h2>Action success</h2>");
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
					$("#view-temp-order").modal("toggle");
					tempItemsBox.modal("toggle");
					//alert("decline");
				};
				this.tempItemsApprove = function(){
					//alert("approve");
				};
				this.refreshOrders = function(nput){
					statButtonEvents.verifiedUnbind();
					statButtonEvents.deleteUnbind();
					$("#order-items-list").html(nput);
					statButtonEvents.viewVerifiedItems();
					statButtonEvents.deleteItems();
				};
			}
			// stat buttons instant
			var statbuttons = new StatButtons();
			
//__________________________________events__________________________________
			// statistics button events
			var StatButtonEvents = function(){
				this.init = function(){
					this.viewUnverifiedItems();
					this.viewVerifiedItems();
					this.deleteItems();
					this.tempItemsDecline();
					this.tempItemsApprove();
					this.refreshTempItems();
					this.deleteBtn();
					this.editTempOrder();
				};
				// refresh temp items every 5 seconds
				this.refreshTempItems = function(){
					setTimeout(function(){
						//alert("hello");
						statbuttons.refreshTempItems();
					}, 5000);
				};

				//______________items list buttons______________

				this.viewUnverifiedItems = function(){
					$(".view-temp-order").bind("click", function(){
						statbuttons.viewUnverifiedItems($(this));
					});
				};
				this.viewVerifiedItems = function(){
					$(".view-verified").bind("click", function(){
						statbuttons.viewVerifiedItems($(this));
					});
				};
				this.deleteItems = function(){
					$(".delete-items").bind("click", function(){
						statbuttons.deleteItems($(this));
					});
				};
				this.unverifiedUnbind = function(){
					$(".view-temp-order").unbind("click");
				};
				this.verifiedUnbind = function(){
					$(".view-verified").unbind("click");
				};
				this.deleteUnbind = function(){
					$(".delete-items").unbind("click");
				};
				this.unbindAll = function(){
					this.unverifiedUnbind();
					this.verifiedUnbind();
					this.deleteUnbind();
				};


		//______________temp modal box buttons events______________

				this.tempItemsDecline = function(){
					$("#temp-order-decline").bind("click", function(){
						statbuttons.tempItemsDecline();
					});
				};
				this.editTempOrder = function(){
					$("#temp-order-edit").bind("click", function(){
						statbuttons.editTempOrder();
					});
				};
				this.tempItemsApprove = function(){
					$("#temp-order-approve").bind("click", function(){
						statbuttons.tempItemsApprove();
						var tempItemsBox = $("#prompt-modal");
						var out = {
							command: "transferOrder",
							data: statbuttons.unverifiedId,
						};
						$.ajax({
							type: "POST",
							url: "../scripts/php/custom/statOrderFetch.php",
							data: {"data": JSON.stringify(out)},
							cache: false,
							success: function(data){
								//alert(data);

								var newData = JSON.parse(data.substr(1,data.length));
								if(newData.command == "transferOrder"){
									if(newData.status == "success"){
										//alert(newData.data);
										tempItemsBox.find(".modal-body").html("<h2>Success transfer</h2>");
										setTimeout(function(){
											window.location.reload();
										},1000);
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
						$("#view-temp-order").modal("toggle");
						tempItemsBox.modal("toggle");
						});
				};
				this.deleteBtn = function(){
					$("#delete-btn").bind("click", function(){
						var promptBox = $(".prompt-box");
						var tempItemsBox = $("#prompt-modal");
						if($("#delete-item").val() == "CONFIRM"){
							promptBox.slideUp();
							var out = {
								command: "deleteOrder",
								data: statbuttons.verifiedId,
								date: calendarProc.displayDate,
							};
						//	alert(JSON.stringify(out));
							$.ajax({
								type: "POST",
								url: "../scripts/php/custom/statOrderFetch.php",
								data: {"data": JSON.stringify(out)},
								cache: false,
								success: function(data){
									//alert(data);
									var newData = JSON.parse(data.substr(1,data.length));
									if(newData.command == "deleteOrder"){
										if(newData.status == "success"){
											$("#delete-order").modal("toggle");
											tempItemsBox.find(".modal-body").html("<h2>Success deletion</h2>");
											//alert(newData.data);
											statbuttons.refreshOrders(newData.data);
										}else{
											// error query
											tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
										}
									}else{
										// error query
										tempItemsBox.find(".modal-body").html("<h2>Error action</h2>");
									}
									tempItemsBox.modal("toggle");
								}
							});
						}else{
							promptBox.text("Wrong key! please enter CONFIRM");
							promptBox.slideDown();
							//alert("bad");
						}
					});
				};
			};
			// events instants
			var statButtonEvents = new StatButtonEvents();

			$(document).ready(function(){
				pageHead();
				settingsEvent();
				statButtonEvents.init();

				// initiate calendar proccess and events
				calendarProc.init($("#order-items-list"), $("#date-display"), $("#calendar"), $("#view-date"), $(".calendar-date"), $("#calendar-modal"));
			});
		</script>
	</body>
</html>