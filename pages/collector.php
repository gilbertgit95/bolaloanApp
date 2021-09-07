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
		<title>Admin: Collector</title>
		<script type="text/javascript" src="../libraries/js/respond.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="../customStyles/all.css" />
		<style type="text/css" rel="stylesheet" >
			.collect-items{
				font-size: 12pt;
				padding: 20px;
				padding-top: 30px;
				padding-bottom: 30px;
				border-radius: 20px;
				border: 1px solid black;
				margin-top: 10px;
				margin-bottom: 10px;
				background-color: #C45B07;
			}
			.collect-items:hover{
				border: none;
			}
			.collect-items div div sup{
				padding: 5px;
				border-radius: 15px;
				background-color: #300a02;
				margin: 10px;
				color: #ff6c00;
			}
			.selected{
				border: none;
				background-color: #b24905;
				color: #ff6c00;
			}
			.scroll-whole{
				z-index: 10;
				position: absolute;
				top: 0px;
				left: 0px;
				border: 1px solid black;
				border-top: none;
				border-left: 1px solid #ff6c00;
				max-width: 200px;
				max-height: 300px;
				overflow-x: hidden;
				overflow-y: scroll;
				border-bottom-left-radius: 10px;
				border-bottom-right-radius: 10px;
			}
			.scroll-whole ul li{
				list-style: none;
				padding: 20px;
				padding-right: 40px;
				font-size: 20pt;
			}
			.scroll-whole ul li:hover{
				color: #ff6c00;
			}
			.scroll-selected{
				color: #ff6c00;
			}
			.half-btn-active{
				color: white;
			}
			#order-table{
				padding: 10px;
			}
			#order-table tr:nth-child(2n-1){
				background-color: #C45B07;
			}
			#order-table tr td{
				padding: 10px;
				padding-right: 30px;
				font-size: 16pt;
			}
			#order-type{
				margin-right: 20px;
			}
			.btn-active{
				color: white;
			}
		</style>
	</head>

	<body class="gray-back">
		<div class="tool-arrow brown-back orange-color">
			<span id="total-btn" data-target="#total-box" data-toggle="modal">Total <span class="glyphicon glyphicon-menu-right"></span></span>
		</div>
		<div class="container orange-back natural-form natural-border">
			<div class="raw">
				<div class="col-xs-12 nat-border-bot page-head lightbrown-color">
					<a class="current-used"><span class="glyphicon glyphicon-shopping-cart"></span>Collector</a> | 
					<a class="lightbrown-color" href="items.php"><span class="glyphicon glyphicon-list-alt"></span>Items</a> | 
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
						<div class="col-xs-12 col-sm-6 item-container food">
							<div class="raw">
								<!--__________________________________whole scroll_________________________________________-->
								<div class="scroll-whole hide lightbrown-back brown-color normal-shadow">
									<span class="half-button button">+ half</span>
									<ul>
										<li>0</li>
										<li>1</li>
										<li>2</li>
										<li>3</li>
										<li>4</li>
										<li>5</li>
										<li>6</li>
										<li>7</li>
										<li>8</li>
										<li>9</li>
										<li>10</li>
										<li>11</li>
										<li>12</li>
										<li>13</li>
										<li>14</li>
										<li>15</li>
										<li>16</li>
										<li>17</li>
										<li>18</li>
										<li>19</li>
										<li>20</li>
										<li>21</li>
										<li>22</li>
										<li>23</li>
										<li>24</li>
										<li>25</li>
										<li>26</li>
										<li>27</li>
										<li>28</li>
										<li>29</li>
										<li>30</li>
										<li>31</li>
										<li>32</li>
										<li>33</li>
										<li>34</li>
										<li>35</li>
										<li>36</li>
										<li>37</li>
										<li>38</li>
										<li>39</li>
										<li>40</li>
										<li>41</li>
										<li>42</li>
										<li>43</li>
										<li>44</li>
										<li>45</li>
										<li>46</li>
										<li>47</li>
										<li>48</li>
										<li>49</li>
										<li>50</li>
									</ul>
								</div>
								<?php
									// access the food and drink items
									$foodItems = $DB->read("SELECT * FROM items WHERE type='F' ORDER BY name");
									$drinkItems = $DB->read("SELECT * FROM items WHERE type='D' ORDER BY name");
									// looping throught the food items
									for($i=1; $i<$foodItems[0]["length"]; $i++){
										echo '<div class="col-xs-12 collect-items ';
										if($foodItems[$i]["quantity"]=="H"){
											echo 'half">';
										}else{
											echo '">';
										}
											echo '<div class="raw">';
												echo '<div class="col-xs-10 col-sm-6">';
													echo '<span>'.$foodItems[$i]["name"].'</span><sup>'.$foodItems[$i]["price"].'</sup>';
													if($foodItems[$i]["quantity"]=="H"){
														echo '<sub><span class="glyphicon glyphicon-flag"></span></sub>';
													}
												echo '</div>';
												echo '<div class="col-xs-2 col-sm-6">';
													echo '<span>0</span>';
													echo '<i> pcs</i>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									}
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 item-container drinks">
							<div class="raw">
								<!--__________________________________whole scroll_________________________________________-->
								<div class="scroll-whole hide lightbrown-back brown-color normal-shadow">
									<span class="half-button button">+ half</span>
									<ul>
										<li>0</li>
										<li>1</li>
										<li>2</li>
										<li>3</li>
										<li>4</li>
										<li>5</li>
										<li>6</li>
										<li>7</li>
										<li>8</li>
										<li>9</li>
										<li>10</li>
										<li>11</li>
										<li>12</li>
										<li>13</li>
										<li>14</li>
										<li>15</li>
										<li>16</li>
										<li>17</li>
										<li>18</li>
										<li>19</li>
										<li>20</li>
										<li>21</li>
										<li>22</li>
										<li>23</li>
										<li>24</li>
										<li>25</li>
										<li>26</li>
										<li>27</li>
										<li>28</li>
										<li>29</li>
										<li>30</li>
										<li>31</li>
										<li>32</li>
										<li>33</li>
										<li>34</li>
										<li>35</li>
										<li>36</li>
										<li>37</li>
										<li>38</li>
										<li>39</li>
										<li>40</li>
										<li>41</li>
										<li>42</li>
										<li>43</li>
										<li>44</li>
										<li>45</li>
										<li>46</li>
										<li>47</li>
										<li>48</li>
										<li>49</li>
										<li>50</li>
									</ul>
								</div>
								<?php
									// looping throught the food items
									for($i=1; $i<$drinkItems[0]["length"]; $i++){
										echo '<div class="col-xs-12 collect-items ';
										if($drinkItems[$i]["quantity"]=="H"){
											echo 'half">';
										}else{
											echo '">';
										}
											echo '<div class="raw">';
												echo '<div class="col-xs-10 col-sm-6">';
													echo '<span>'.$drinkItems[$i]["name"].'</span><sup>'.$drinkItems[$i]["price"].'</sup>';
													if($drinkItems[$i]["quantity"]=="H"){
														echo '<sub><span class="glyphicon glyphicon-flag"></span></sub>';
													}
												echo '</div>';
												echo '<div class="col-xs-2 col-sm-6">';
													echo '<span>0</span>';
													echo '<i> pcs</i>';
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


		<!--________________________________modal box__________________________________-->
											<div class="modal fade" id="total-box" role="dialog" aria-labelledby="totalBox" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
																&times;
															</button>
															<h4 class="modal-title" id="totalBox">
																Items Ordered
															</h4>
														</div>
														<div class="modal-body">
															<h1>No selected Items</h1>
														</div>
														<div class="modal-footer">
															<select id="table-meal" class="button">
																<option>takeout</option>
																<option>Table 1</option>
																<option>Table 2</option>
																<option>Table 3</option>
																<option>Table 4</option>
																<option>Table 5</option>
																<option>Table 6</option>
																<option>Table 7</option>
																<option>Table 8</option>
																<option>Table 9</option>
																<option>Table 10</option>
																<option>Table 11</option>
																<option>Table 12</option>
																<option>Table 13</option>
																<option>Table 14</option>
																<option>Table 15</option>
																<option>Table 16</option>
																<option>Table 17</option>
																<option>Table 18</option>
																<option>Table 19</option>
																<option>Table 20</option>
																<option>Table 21</option>
																<option>Table 22</option>
																<option>Table 23</option>
																<option>Table 24</option>
																<option>Table 25</option>
																<option>Table 26</option>													
															</select>
															<!--span id="order-type" class="button"><span class="glyphicon glyphicon-remove-sign"></span> Take-out</span-->
															<button id="total-send-btn" class="button">
																Submit
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
															<span class="glyphicon glyphicon-ok-sign security-checked checked"></span> <input id="new_username" type="text" class="input-box" /><br /><br />
															<label>New password</label><br /><br />
															<span class="glyphicon glyphicon-ok-sign security-checked checked"></span> <input id="new_password" type="password" class="input-box" /><br /><br />
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
		<script type="text/javascript" src="../libraries/js/jquery-2.2.1.min.js" ></script>
		<script type="text/javascript" src="../libraries/js/jquery-cookie.js" ></script>
		<script type="text/javascript" src="../libraries/style/bootstrap/js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="../scripts/js/pageHead.js" ></script>
		<script type="text/javascript" src="../scripts/js/settings.js" ></script>
		<script type="text/javascript" src="../scripts/js/validation.js" ></script>
		<script type="text/javascript">
			// the collect Class
			var tempStorage = {
				editItemsData: null,
			}
			var TestURL = function(){
				this.status=false;
				this.init = function(){
					// test for data in the url
					//alert(this.getURL().length);
					if(this.getURL().length > 30){
						tempStorage.editItemsData = this.getValues(this.getURL());
						this.assignValues();
					}
					
				};
				this.getURL = function(){
					var url = new String(window.location);
					url = url.replace(/#/g," ");
					return url.substring(url.indexOf("?")+1,url.length);
				};
				this.getValues = function(nput){
					var out = new Array();
					out["names"];
					out["num_order"];
					out["id"];
					out["command"];
					out["takeout"];
					out["table"];
					// test for url data minimum of 30 characters
					if(nput.length > 30){
						try {
							var temp = nput.split("&");
							out["id"] = temp[4] || false;
							out["command"] = temp[0] || false;
							out["names"] = temp[1].split(":") || false;
							out["num_order"] = temp[2].split(":") || false;
							out["takeout"] = temp[3].split(":");
						} catch(error){
							console.log(error);
						}
					}
					//alert(out["takeout"][1]);
					//alert(out["num_order"]);
					return out;
				};
				this.assignValues = function(nput){
					//alert(nput["names"]);
					$(".collect-items").each(function(){
						var data = tempStorage.editItemsData;
						try{
							for(i=1; i<data["names"].length; i++){
								//alert($(this).find(".col-xs-10").find("span").eq(0).text()+ "=="+ data["names"][i]);
								if($(this).find(".col-xs-10").find("span").eq(0).text() == data["names"][i]){
									$(this).addClass("selected");
									$(this).find(".col-xs-2").find("span").eq(0).text(data["num_order"][i]);
									//alert($(this).find(".col-xs-10").find("span").eq(0).text());
									//alert($(this).find(".col-xs-2").find("span").eq(0).text());
									break;
								}
							}
							// test for takeout or table meals
					/*		if(data["takeout"][1] == "true"){
								//alert("good");
								$("#order-type").find("span").removeClass("glyphicon-remove-sign").addClass("glyphicon-ok-sign");
							}else{*/
								$("#table-meal").val(data["takeout"][1]);
					//		}
							//alert(data["takeout"][1]);
						} catch(error){
							console.log(error);
						}
					});
					//$("#total-btn").click();
				};
			};
			var URL = new TestURL();
			// the collect Class
			var scrollItemCon = new function() {
				var boxBody = $("#total-box").find(".modal-body");
				this.item;
				this.numOrder = 0;
				this.totalItem;
				this.writeToItem = function() {
					this.item.find(".col-sm-6").eq(1).find("span").text(this.numOrder);
					if(this.numOrder==0){
						this.item.removeClass("selected");
					}else{
						this.item.addClass("selected");
					}
				}
				this.totalBox = function(){
					var tempArray = new Array();
					tempArray["name"] = new Array();
					tempArray["price"] = new Array();
					tempArray["numOrder"] = new Array();
					tempArray["subTotal"] = new Array();
					tempArray["type"] = new Array();
					tempArray["total"] = 0;

					var orderedItem = $(".selected.collect-items");
					$.each(orderedItem, function(index, data){
						//$(this).find(".col-xs-6").eq(0).find("span").eq(0).css("background-color", "black");
						tempArray["name"][index] = $(this).find(".col-sm-6").eq(0).find("span").eq(0).text();
						tempArray["price"][index] = parseFloat($(this).find(".col-sm-6").eq(0).find("sup").eq(0).text());
						tempArray["numOrder"][index] = parseFloat($(this).find(".col-sm-6").eq(1).find("span").text());
						tempArray["subTotal"][index] = tempArray["price"][index] * tempArray["numOrder"][index];
						if($(this).parents(".item-container").hasClass("food")){
							tempArray["type"][index] = "F";
						}else{
							tempArray["type"][index] = "D";
						}
						tempArray["total"] += tempArray["subTotal"][index];
					});
					scrollItemCon.totalItem = tempArray;
					if(orderedItem.length == 0){
						boxBody.html("<h2>No items ordered</h2>");
					}else{
						// mag-generate table
						var textTable = "<div class='table-responsive'><table id='order-table'>";
						textTable +="<div class='table-responsive'><table id='order-table'>";
						for(var i=0; i<orderedItem.length; i++){
							textTable += "<tr><td>"+tempArray["name"][i]+"</td> <td>P "+tempArray["price"][i]+"</td> <td> x "+tempArray["numOrder"][i]+"</td> <td>P "+tempArray["subTotal"][i]+"</td></tr>";
						}
						textTable += "<tr><td colspan='3'>Total</td> <td>P "+tempArray["total"]+"</td> <tr>";
						textTable += "</table></div>";
						boxBody.html(textTable);
					}
					// toggle sign sa type button
				//	$("#order-type").find("span").removeClass("glyphicon-ok-sign").addClass("glyphicon-remove-sign");
					//alert(tempArray["name"]+"\n"+tempArray["price"]+"\n"+tempArray["numOrder"]+"\n"+tempArray["subTotal"]+"\n"+tempArray["total"]);
				};
				//--- para sa pag reset sa item
				this.resetItems = function(){
					$.each($(".selected.collect-items"), function(index, data){
						$(this).find(".col-sm-6").eq(1).find("span").text("0");
						$(this).removeClass("selected");
					});
				};
			}
			var CollectClass = function(){
				var scrollNums = $(".scroll-whole ul li");
				var items = $(".collect-items");
				var food = $(".food .raw .scroll-whole");
				var drinks = $(".drinks .raw .scroll-whole");
				this.init = function(){
					$(".scroll-whole").removeClass("hide").hide();
					this.itemEvents();
					this.scrollNumEvents();
					this.halfBtnEvent();
					this.totalEvent();
					this.orderTypeEvent();
				}
				//------------------para sa order type sa order box
				this.orderTypeEvent = function(){
					$("#order-type").bind("click", function(){
						if($(this).find("span").hasClass("glyphicon-ok-sign")){
							$(this).find("span").removeClass("glyphicon-ok-sign");
							$(this).find("span").addClass("glyphicon-remove-sign");
						}else{
							$(this).find("span").addClass("glyphicon-ok-sign");
							$(this).find("span").removeClass("glyphicon-remove-sign");
						}
					});
				}
				//---------- para sa dropdown half button
				this.halfBtnEvent = function(){
					$(".half-button").bind("click", function(){
						$(this).toggleClass("half-btn-active");
					});
				}
				//----------para sa mga number ng dropdown box
				this.scrollNumEvents = function(){
					scrollNums.bind("click", function(){
						$(this).addClass("scroll-selected");
						$(this).parents(".scroll-whole").slideUp();
						scrollItemCon.numOrder = $(this).text();
						if($(this).parents(".scroll-whole").find("span").hasClass("half-btn-active")){
							scrollItemCon.numOrder += ".5";
						}
						scrollItemCon.writeToItem();
						$(this).removeClass("scroll-selected");
					});
				}


				//-------------sa mga items na pag click
				this.itemEvents = function(){
					items.bind("click", function(){
						var scroll;
						scrollItemCon.item = $(this);
						if($(this).parents(".item-container").hasClass("food")){
							scroll = food;
							food.slideDown();
							drinks.slideUp();
						}else{
							scroll = drinks;
							food.slideUp();
							drinks.slideDown();
						}
						// test for items with flag
						if($(this).hasClass("half")){
							$(".half-button").show();
						}else{
							$(".half-button").hide();
						}
						var scrollWidth = scroll.width();
						var posx = $(this).position().left;
						var posy = $(this).position().top;
						var itemWidth = $(this).width();
						var itemHeight = $(this).height();
						posx = posx + itemWidth - scrollWidth;
						posy = posy + itemHeight;	
						scroll.css({"left": posx+"px", "top": posy+"px"});
						scroll.find("span").removeClass("half-btn-active");
					});
				}
				//------------para sa total na button
				this.totalEvent = function(){
					$("#total-btn").bind("click", function(){
						scrollItemCon.totalBox();
					});
				}
			}
			function collectInit(){
				var collect = new CollectClass();
				collect.init();
				checkedEvent();
			}
			function events(){
				// send button preproceesor adeser e send
				$("#total-send-btn").bind("click", function(){
					var out = {
						name : JSON.stringify(scrollItemCon.totalItem["name"]),
						price: JSON.stringify(scrollItemCon.totalItem["price"]),
						numOrder: JSON.stringify(scrollItemCon.totalItem["numOrder"]),
						type: JSON.stringify(scrollItemCon.totalItem["type"]),
						total: scrollItemCon.totalItem["total"],
						takeout: false,
						tableMeal: $("#table-meal").val()
					};
			/*		if($("#order-type").find("span").hasClass("glyphicon-ok-sign")){
						out.takeout = true;
					}else{
						out.takeout = false;
					}*/

				// send throught ajax
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/addOrders.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);
							var newData = data.substr(1,data.length);
							$("#total-box").modal("toggle");
							var promptModal = $("#prompt-modal");
							if(newData == "success"){
								scrollItemCon.resetItems();
								promptModal.find(".modal-body").html("<h1>Order has been submitted</h1>");
								promptModal.modal("toggle");
							}else{
								promptModal.find(".modal-body").html("<h1>Error action!</h1>");
								promptModal.modal("toggle");
							}
						} 
					});
					//alert(JSON.stringify(out));
				});
			}
			$(document).ready(function(){
				URL.init();
				pageHead();
				collectInit();
				events();
				settingsEvent();
			});
		</script>
	</body>
</html>