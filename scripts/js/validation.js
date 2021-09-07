//----------------- filter -------------------------

			var inputFilterClass = function(){
				var outputElement; 
				this.init = function(nput){
					outputElement = nput;
				};
				this.name = function(nput, addWarning){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					var max = 15;
					var min = 3;
					var regex = /[^a-zA-Z0-9 _]/;
					var outText = "";
					var out = false;
					// test if size is valid
					var testString = new String(nput);
					if(min < testString.length && max > testString.length){
						out = false;
					}else{
						out = true;
						outText += "<i>Name size maximum of "+max+" and minimum of "+min+".</i><br />";

					}
					// test if text is valid
					if(regex.test(nput)){
						outText += "<i>Name should only be aphanumeric underscore and space.</i><br />";
						out = true;
					}
					if(out){
						if(addWarning){
							outputElement.append(outText);
						}else{
							outputElement.html(outText);
						}
					}
					return out;
				};
				this.price = function(nput, addWarning) {
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					//var regex = /[^0-9]\./;
					var outText = "";
					var out = false;

					// test for price length
					if(nput > 0){
						out = false;
					}else{
						outText += "<i>Price input is invalid</i><br />";
						out = true;
					}
					
					if(out){
						if(addWarning){
							outputElement.append(outText);
						}else{
							outputElement.html(outText);
						}
					}
					return out;
					//alert("ok");
				};
				this.password = function(nput, addWarning){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					var max = 20;
					var min = 6;
					var regex = /[^a-zA-Z0-9]/;
					var outText = "";
					var out = false;
					// test if size is valid
					var testString = new String(nput);
					if(min < testString.length && max > testString.length){
						out = false;
					}else{
						out = true;
						outText += "<i>password size maximum of "+max+" and minimum of "+min+".</i><br />";

					}
					// test if text is valid
					if(regex.test(nput)){
						outText += "<i>password should only be aphanumeric</i><br />";
						out = true;
					}
					if(out){
						if(addWarning){
							outputElement.append(outText);
						}else{
							outputElement.html(outText);
						}
					}
					return out;
				};
				this.username = function(nput, addWarning){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					var max = 15;
					var min = 6;
					var regex = /[^a-zA-Z0-9_@]/;
					var outText = "";
					var out = false;
					// test if size is valid
					var testString = new String(nput);
					if(min < testString.length && max > testString.length){
						out = false;
					}else{
						out = true;
						outText += "<i>username size maximum of "+max+" and minimum of "+min+".</i><br />";

					}
					// test if text is valid
					if(regex.test(nput)){
						outText += "<i>username should only be aphanumeric underscore and @.</i><br />";
						out = true;
					}
					if(out){
						if(addWarning){
							outputElement.append(outText);
						}else{
							outputElement.html(outText);
						}
					}
					return out;
				};
				this.key = function(nput, addWarning){
					var max = 10;
					var min = 5;
					var regex = /[^a-zA-Z0-9]/;
					var outText = "";
					var out = false;
					// test if size is valid
					var testString = new String(nput);
					if(min < testString.length && max > testString.length){
						out = false;
					}else{
						out = true;
						outText += "<i>client key size maximum of "+max+" and minimum of "+min+".</i><br />";

					}
					// test if text is valid
					if(regex.test(nput)){
						outText += "<i>client key should only be aphanumeric</i><br />";
						out = true;
					}
					if(out){
						if(addWarning){
							outputElement.append(outText);
						}else{
							outputElement.html(outText);
						}
					}
					return out;
				};
				this.hideWarning = function(){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					outputElement.slideUp();
				};
				this.showWarning = function(){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					outputElement.slideDown();
				};
				this.clear = function(){
					//--- warning prompt
					//var outputElement = $(".prompt-box");
					outputElement.html("");
				};
			};
			var inputFilter = new inputFilterClass();