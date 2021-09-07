			var SettingsClass = function(){
				var promptModal;
				var settingsModal;
				var clientModal;
				this.init = function(){
					promptModal = $("#prompt-modal");
					settingsModal = $("#security-key");
					clientModal = $("#client-key");
					// getting the client key from the database
					var out = {
						command: "getClientKey",
					};
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/settings.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							var newData = JSON.parse(data.substr(1,data.length));
							//alert(newData);
							if(newData.command == "getClientKey"){
								// set the client key in the client modal box
							    $("#client-key").find(".modal-body").find("label").eq(0).find("i").text(newData.data);
							    //alert(newData.data);
							}
						}
					});
					// unhiding the prompt box
					$(".prompt-box").removeClass("hide").hide();
					// filter initiation
					inputFilter.init($(".prompt-box"));
				};
				this.saveSecurity = function(){
					var input = new Array();
					input["username"] = $("#currrent_username").val();
					input["password"] = $("#currrent_password").val();
					input["newusername"] = $("#new_username").val();
					input["newpassword"] = $("#new_password").val();
					input["check"] = new Array();
					$.each($(".security-checked"), function(index, data){
						if($(this).hasClass("glyphicon-ok-sign")){
							input["check"][index] = true;
						}else{
							input["check"][index] = false;
						}
					});
					inputFilter.clear();
					var userFilter = false;
					var passFilter = false;
					userFilter = inputFilter.username(input["username"], false);
					passFilter = inputFilter.password(input["password"], true);

					if(userFilter || passFilter){
						$(".prompt-box").append("<b>old keys</b><br /><br />");
					}

					var newuserFilter = false;
					var newpassFilter = false;
					if(input["check"][0]){
						newuserFilter = inputFilter.username(input["newusername"], true);
					}
					if(input["check"][1]){
						newpassFilter = inputFilter.password(input["newpassword"], true);
					}

					if(newuserFilter || newpassFilter){
						$(".prompt-box").append("<b>new keys</b><br /><br />");
					}

					if(userFilter || passFilter || newuserFilter || newpassFilter){
						inputFilter.showWarning();
					}else{
						inputFilter.hideWarning();
						
						var out = {
							command: "setAdmin",
							username: input["username"],
							password: input["password"],
							newusername: input["newusername"],
							newpassword: input["newpassword"],
							usercheck: input["check"][0],
							passcheck: input["check"][1]
						};
						$.ajax({
							type: "POST",
							url: "../scripts/php/custom/settings.php",
							data: {"data": JSON.stringify(out)},
							cache: false,
							success: function(data){
								var newData = JSON.parse(data.substr(1,data.length));
								//alert(data); 
								//alert(newData);
								settingsModal.modal("toggle");
								if(newData.command == "setAdmin"){
									if(newData.data == "success"){
										promptModal.find(".modal-body").html("<h1>Success action</h1>");
										promptModal.modal("toggle");
									}else{
										promptModal.find(".modal-body").html("<h1>error action</h1>");
										promptModal.modal("toggle");
									}
									// clears the values in the security input box
									$("#currrent_username").val("");
									$("#currrent_password").val("");
									$("#new_username").val("");
									$("#new_password").val("");
								}
							}
						});
					}
					//alert(input["username"]+" "+input["password"]+" "+input["newusername"]+" "+input["newpassword"]+" "+input["check"]);
				};
				this.saveClientKey = function(){
					inputFilter.clear();
					var keyInput = $("#new_client_key").val();
					var invalid = false;
					invalid = inputFilter.key(keyInput, false);
					if(invalid){
						inputFilter.showWarning();
					}else{
						inputFilter.hideWarning();
						var out = {
							command: "setClientKey",
							clientKey: keyInput
						};
						$.ajax({
							type: "POST",
							url: "../scripts/php/custom/settings.php",
							data: {"data": JSON.stringify(out)},
							cache: false,
							success: function(data){
								var newData = JSON.parse(data.substr(1,data.length));
								//alert(data); 
								//alert(newData);
								clientModal.modal("toggle");
								if(newData.command == "setClientKey"){
									if(newData.data == "success"){
										$("#client-key").find(".modal-body").find("label").eq(0).find("i").text(newData.clientKey);
										promptModal.find(".modal-body").html("<h1>Success action</h1>");
										promptModal.modal("toggle");
									}else{
										promptModal.find(".modal-body").html("<h1>error action</h1>");
										promptModal.modal("toggle");
									}
									// clears the values in the security input box
									 $("#new_client_key").val("");
								}
							}
						});

					}
				};
				this.logout = function(){
					if($("#log-out-btn").hasClass("admin")){
						//alert("admin out");
							var out = {
								command: "logout",
							};
							$.ajax({
								type: "POST",
								url: "../scripts/php/custom/login.php",
								data: {"data": JSON.stringify(out)},
								cache: false,
								success: function(data){
									//alert(data);
									var newData = JSON.parse(data.substr(1,data.length));
									if(newData.command == "logout"){
										if(newData.data == "success"){
											window.location="../index.html";
										}
									}
								}
							});
					}else{
						alert("collector out");
					}
				};

			};

			var settings = new SettingsClass();

			function settingsEvent() {
				settings.init();
				// security save button event
				$("#security_key_save").bind("click", function(){
					settings.saveSecurity();
				});

				// client save button event
				$("#save_client_key").bind("click", function(){
					settings.saveClientKey();
				});

				$("#log-out-btn").bind("click", function(){
					settings.logout();
				});
			};