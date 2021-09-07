<?php
	// external library
	// library for database and encription object
	include "../scripts/php/custom/mylib.php";
	include "../scripts/php/custom/adminPreviledge.php";
?>
<!doctype html>
<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="../libraries/style/bootstrap/css/bootstrap.min.css" />
		<title>Admin: Items</title>
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
			.items:hover{
				border: none;
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
		</style>
	</head>

	<body class="gray-back">
		<div class="tool-arrow brown-back orange-color">
			<span><span class="glyphicon glyphicon-menu-right"></span></span>
		</div>
		<div class="tools normal-shadow brown-back orange-color">
			<label id="num-item-selected">selected: 0</label><br />
			<span id="edit" data-target="#edit-items" data-toggle="modal"><span class="glyphicon glyphicon-edit"></span>Edit</span> 
			<span id="delete" data-target="#delete-items" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span>Delete</span> 
			<span data-target="#add-items" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Add</span>
		</div>
		<div class="container orange-back natural-form natural-border">
			<div class="raw">
				<div class="col-xs-12 nat-border-bot page-head lightbrown-color">
					<a class="lightbrown-color" href="collector.php"><span class="glyphicon glyphicon-shopping-cart"></span>Collector</a> | 
					<a class="current-used"><span class="glyphicon glyphicon-list-alt"></span>Items</a> | 
					<span class="" id="stat-btn"><span class="glyphicon glyphicon-stats"></span>Stat</span> |
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
							<li><a href="statOrders.php">Ordered</a></li>
							<li><a href="statItemOrders.php">Items Ordered</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 page-content brown-color">
					<div class="raw">
						<div class="col-xs-12 col-sm-6 item-pane food">
							<div class="raw">
								<?php
									// access the food and drink items
									$foodItems = $DB->read("SELECT * FROM items WHERE type='F' ORDER BY name");
									$drinkItems = $DB->read("SELECT * FROM items WHERE type='D' ORDER BY name");
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

						<div class="col-xs-12 col-sm-6 item-pane drinks">
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

		<!--_____________________________________________modal boxes____________________________________________________________-->

											<div class="modal fade" id="edit-items" role="dialog" aria-labelledby="editItems" aria-hidden="true">
												<div class="modal-dialog">
													<form enctype="multipart/form-data" method="post" action="../scripts/php/custom/editItem.php" class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="editItems">
																<span class="glyphicon glyphicon-edit"></span> Edit items
															</h4>
														</div>
														<div class="modal-body">
															<div class="container">
																<div class="raw">
																	<div class="col-xs-12 edit-modal-content">
																		
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="submit" id="edit-save-btn" class="button">
																Save
															</button>
														</div>
													</form><!-- /.modal-content -->
												</div>
											</div>
											<div class="modal fade" id="delete-items" role="dialog" aria-labelledby="deleteItems" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="deleteItems">
																<span class="glyphicon glyphicon-trash"></span> Delete items
															</h4>
														</div>
														<div class="center modal-body">
															
														</div>
														<div class="modal-footer">
															<button id="delete-items-btn" class="button">
																Confirm
															</button>
														</div>
													</div><!-- /.modal-content -->
												</div>
											</div>
											<div class="modal fade" id="add-items" role="dialog" aria-labelledby="addItems" aria-hidden="true">
												<div class="modal-dialog">
													<form enctype="multipart/form-data" method="post" action="../scripts/php/custom/addItem.php" class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="addItems">
																<span class="glyphicon glyphicon-plus"></span> Add item
															</h4>
														</div>
														<div class="modal-body">
															<div class="container">
																<div class="raw">
																	<div class="col-xs-12">
																		<div class="prompt-box hide"></div>
																		<input type="text" class="hide" name="data" id="add-form-data" />
																		<label>Name</label><br />
																		<input id="add-item-name" class="input-box" type="text" /><br />
																		<label>Price</label><br />
																		<input id="add-item-price" class="input-box" type="text" /><br /><br />
																		<label>Type</label><br /><br />
																		<span id="add-item-type" class="item-type button">Food</span><br /><br />
																		<label>Quantity</label><br /><br />
																		<span id="add-item-quantity" class="item-quantity button">Whole</span><br /><br />
																		<label>Photo</label><br /><br />
																		<span id="add-item-checked" class="glyphicon glyphicon-ok-sign checked"></span><label class="button">Pick photo<input name="photo" id="add-item-photo" type="file" class="hide" accept="image/*" /></label><br /><br />
																	</div>

																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="submit" id="add-save-btn" class="button">
																Save
															</button>
														</div>
													</form><!-- /.modal-content -->
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
<!--_____________________________________________Page heading settings modal boxes____________________________________________________________-->

		<script type="text/javascript" src="../libraries/js/jquery-2.2.1.min.js" ></script>
		<script type="text/javascript" src="../libraries/js/jquery-cookie.js" ></script>
		<script type="text/javascript" src="../libraries/style/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="../scripts/js/pageHead.js" ></script>
		<script type="text/javascript" src="../scripts/js/settings.js" ></script>
		<script type="text/javascript" src="../scripts/js/validation.js" ></script>
		<script type="text/javascript">
			function toggleModalEvent(){
				// sa modal box
				var itemType = $(".item-type");
				var itemQ = $(".item-quantity");

				//modal box buttons binding events
				itemType.bind("click", function(){
					if($(this).text()=="Food"){
						$(this).text("Drinks");
					}else{
						$(this).text("Food");
					}
				});
				itemQ.bind("click", function(){
					if($(this).text()=="Half"){
						$(this).text("Whole");
					}else{
						$(this).text("Half");
					}
				});

			}
			function toggleModalUnbind(){
				$(".item-type").unbind("click");
				$(".item-quantity").unbind("click");
			}
			function items(){
				// sa tools
				var items = $(".items");
				var tools = $(".tools");
				var toolArrow = $(".tool-arrow");

				//tools binding events
				items.bind("click", function(){
					$(this).toggleClass("selected");
					var selctd = $(".selected");
					$("#num-item-selected").text("selected: " + selctd.length);
					tools.slideUp();
					toolArrow.show();
				});
				toolArrow.bind("click", function(){
					tools.slideDown();
					toolArrow.hide();
				});

				//modalbox initiation button events
				$("#delete").bind("click", function(){
					if($(".selected").length == 0){
						$("#delete-items").find(".modal-body").html("<h2>No selected items</h2>");
					}else{
						$("#delete-items").find(".modal-body").html("<label>Enter CONFIRM to proceed.</label><br /><input id='delete-confirmation' type='text' class='input-box' />");
					}
				});
				$("#edit").bind("click", function(){
					var itemSelec = $(".selected");
					var modalBody = $("#edit-items").find(".edit-modal-content");
					if(itemSelec.length == 0){
						modalBody.html("<h2>No selected items</h2>");
					}else if(itemSelec.length == 1){
						var selectedItem = $(".selected div div span");
						var itemName = selectedItem.eq(0).text();
						var itemPrice = selectedItem.eq(1).text();
						var itemQuant = selectedItem.eq(2).text();
						var itemType = "Food";
						
						// condition for the quantity of item per order
						if(itemQuant == "1/order"){
							itemQuant = "Whole";
						}else{
							itemQuant = "Half";
						}

						// condition for the type of item
						if(itemSelec.parents(".item-pane").hasClass("food")){
							itemType = "Food";
						}else{
							itemType = "Drinks";
						}
						// html form for single item
						modalBody.html('<div class="prompt-box hide"></div><input id="edit-data" type="text" class="hide" name="data" /><label>Name</label><br /><span class="edit-item-checked glyphicon glyphicon-ok-sign checked"></span><input id="edit-item-name" class="input-box" value="'+itemName+'" type="text" /><br /><label>Price</label><br /><span class="edit-item-checked glyphicon glyphicon-ok-sign checked"></span><input id="edit-item-price" class="input-box" value="'+itemPrice+'"  type="text" /><br /><br /><label>Type</label><br /><br /><span class="edit-item-checked glyphicon glyphicon-ok-sign  checked"></span><span id="edit-item-type" class="item-type button">'+itemType+'</span><br /><br /><label>Quantity</label><br /><br /><span class="edit-item-checked glyphicon glyphicon-ok-sign  checked"></span><span id="edit-item-quantity" class="item-quantity button">'+itemQuant+'</span><br /><br /><label>Photo</label><br /><br /><span class="edit-item-checked glyphicon glyphicon-remove-sign  checked"></span><label class="button">Pick photo<input name="photo" type="file" class="hide" accept="image/*"  /></label><br /><br />');
						//alert(itemName+"\n"+itemType+"\n"+itemPrice+"\n"+itemQuant);
					}else{
						// for multiple item
						modalBody.html('<div class="prompt-box hide"></div><input id="editx-data" type="text" class="hide" name="data" /><label>Price</label><br /><span class="edit-xitem-checked glyphicon glyphicon-ok-sign checked"></span><input id="edit-xitem-price" class="input-box" type="text" /><br /><br /><label>Type</label><br /><br /><span class="edit-xitem-checked glyphicon glyphicon-ok-sign  checked"></span><span id="edit-xitem-type" class="item-type button">Food</span><br /><br /><label>Quantity</label><br /><br /><span class="edit-xitem-checked glyphicon glyphicon-ok-sign  checked"></span><span id="edit-xitem-quantity" class="item-quantity button">Whole</span><br /><br />');
					}

					$(".prompt-box").removeClass("hide").hide(); // para sa prompt box
					toggleModalUnbind();
					toggleModalEvent();
					checkUnbind();
					checkedEvent();
				});
				checkedEvent(); // initiate checkbox event for togglling
			}

			
			//-----------------input forms modal Object---------
			//-----add form
			var AddFormClass = function(){
				this.save = function(){
					var input = new Array();
					input["name"] = $("#add-item-name").val(); 
					input["price"] = $("#add-item-price").val(); 
					input["type"] = $("#add-item-type").text();
					input["quantity"] = $("#add-item-quantity").text();
					input["enable_photo"] = $("#add-item-checked").hasClass("glyphicon-ok-sign");
					//input["photo"] = $("#add-item-photo").attr("src");
					//alert(input["name"]+" "+input["enable_photo"]+" "+input["quantity"]+" "+input["type"]+" "+input["price"]+" ");

					inputFilter.clear();
					var nameStatus = inputFilter.name(input["name"], false);
					var priceStatus = inputFilter.price(input["price"], true);
					if(nameStatus || priceStatus){
						inputFilter.showWarning();
						return false;
					}else{
						//-------------- run if the no input is valid
						var out = {
							image: input["enable_photo"],
							name: input["name"],
							price: input["price"],
							type: input["type"],
							quantity: input["quantity"]
						}
					 	$("#add-form-data").val(JSON.stringify(out));
						inputFilter.hideWarning();
						return true;
					}

				};
			};
			var EditFormClass = function(){
				this.save = function(){
					var input = new Array();
					input["name"] = $("#edit-item-name").val(); 
					input["price"] = $("#edit-item-price").val(); 
					input["type"] = $("#edit-item-type").text();
					input["quantity"] = $("#edit-item-quantity").text();
					input["check"] = new Array();
					//---loop to access ckeckboxes
					$.each($(".edit-item-checked"), function(index, data){
						if($(this).hasClass("glyphicon-ok-sign")){
							input["check"][index] = true;
						}else{
							input["check"][index] = false;
						}
					});

					inputFilter.clear();
					var nameStatus = inputFilter.name(input["name"], false);
					var priceStatus = inputFilter.price(input["price"], true);
					if(nameStatus || priceStatus){
						inputFilter.showWarning();
					}else{
						inputFilter.hideWarning();
					}
					// object for datasend to server
					var out = {
						oldName : $(".selected.items").find(".col-xs-12").eq(1).find("span").eq(0).text(),
						newName : input["name"],
						price : input["price"],
						type : input["type"],
						quantity : input["quantity"],
						check : JSON.stringify(input["check"])
					}
					$("#edit-data").val(JSON.stringify(out));
					//alert(JSON.stringify(out));
					// true so that the form will redirect when clicked
					return true;
				};
			};
			var EditXFormClass = function(){
				this.save = function(){
					var input = new Array();
					input["price"] = $("#edit-xitem-price").val(); 
					input["type"] = $("#edit-xitem-type").text();
					input["quantity"] = $("#edit-xitem-quantity").text();
					input["items"] = new Array();
					input["check"] = new Array();
					//---loop to access ckeckboxes
					$.each($(".edit-xitem-checked"), function(index, data){
						if($(this).hasClass("glyphicon-ok-sign")){
							input["check"][index] = true;
						}else{
							input["check"][index] = false;
						}
					});
					$.each($(".selected.items"), function(index, data){
						input["items"][index] = $(this).find(".col-xs-12").eq(1).find("span").eq(0).text();
					});

					inputFilter.clear();
					var priceStatus = inputFilter.price(input["price"], true);
					if(input["check"][0]){
						if(priceStatus){
							inputFilter.showWarning();
							return false;
						}else{
							inputFilter.hideWarning();
						}
					}
					// ----- out via ajax object
					var out = {
						items: JSON.stringify(input["items"]),
						price: input["price"],
						type: input["type"],
						quantity: input["quantity"],
						check: JSON.stringify(input["check"]),
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/editItems.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							var newData = data.substr(1,data.length);
							//alert(newData);
							if(newData == "success"){
							    window.location.reload();
							}else{
							    alert("Error unable to edit items");
							}
						}
					});
					//alert(input["price"]+" "+input["type"]+" "+input["quantity"]+" "+input["check"]+" "+input["items"]);
					// false so the form will not redirect when clicked
					return false;
				};
			};
			var DeleteItemsClass = function(){
				this.delete = function(){
					var input = new Array();
					if($(".selected.items").length > 0){
						//---loop to items 
						$.each($(".selected.items"), function(index, data){
							input[index] = $(this).find(".col-xs-12").eq(1).find("span").eq(0).text();
						});
						//---------temporary for testing only
						//$("#delete-items").off("hidden");
						//---------temporary for testing only
						if($("#delete-confirmation").val() == "CONFIRM"){
							//alert(input);
							$.ajax({
							    type: "POST",
							    url: "../scripts/php/custom/deleteItems.php",
							    data: {"data": JSON.stringify(input)},
							    cache: false,
							    success: function(data){
							        	var newData = data.substr(1,data.length);
							        	if(newData == "success"){
							        		window.location.reload();
							        	}else{
							        		alert("Error unable to delete items");
							        	}
							    }
						    });	
						}
					//	alert("good");
					}else{
						return false;
					}
				};

			};
			var addForm = new AddFormClass();
			var editForm = new EditFormClass();
			var editXForm = new EditXFormClass();
			var deleteItems = new DeleteItemsClass();
			//-----------------submit events-------------------
			function formEvents(){
				$("#add-save-btn").bind("click", function(){
					inputFilter.init($(".prompt-box"));
					return addForm.save();
					//alert($("#add-item-inputname").value);
				});
				$("#edit-save-btn").bind("click", function(){
					var itemsChoosen  = $(".selected.items").length;
					// only one selected items
					if(itemsChoosen == 0){
						return false;
					}else if(itemsChoosen == 1){
						inputFilter.init($(".prompt-box"));
						return editForm.save();
					}else if(itemsChoosen > 1){ // multiple items selected
						inputFilter.init($(".prompt-box"));
						return editXForm.save();
					}
					//alert($("#add-item-inputname").value);
				});
				$("#delete-items-btn").bind("click", function(){
					deleteItems.delete();
				});
			}
			//--- processes to perform after loading the documents
			function otherProcess(){
				$(".prompt-box").removeClass("hide").hide();
			}
			$(document).ready(function(){
				toggleModalEvent();
				pageHead();
				items();
				formEvents();
				otherProcess();
				settingsEvent();
			});
		</script>
	</body>
</html>