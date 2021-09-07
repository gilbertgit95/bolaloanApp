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
		<title>Admin: Item Order Statistics</title>
		<script type="text/javascript" src="../libraries/js/respond.min.js" ></script>
		<link rel="stylesheet" type="text/css" href="../customStyles/all.css" />
		<style type="text/css" rel="stylesheet" >
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
							<li><a href="statOrders.php">Ordered</a></li>
							<li><a>Items Ordered <span class="glyphicon glyphicon-check"></span></a></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 page-content brown-color">
					<div class="raw">
						<div class="col-xs-12 col-md-6">
							<h1>Items Ordered</h1>
						</div>
						<div class="col-xs-12 col-md-6">
							<h1>On development</h1>
						</div>
					</div>
				</div>
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
												
											</div><div class="modal fade" id="prompt-modal" role="dialog" aria-labelledby="promptBox" aria-hidden="true">
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
		<script type="text/javascript">
			$(document).ready(function(){
				pageHead();
				settingsEvent();
			});
		</script>
	</body>
</html>