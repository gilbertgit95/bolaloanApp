// log out the client pages
function logout(){
	$("#logout").bind("click", function(){
		var out = {
			command: "clientLogout",
		};
		$.ajax({
			type: "POST",
			url: "../scripts/php/custom/login.php",
			data: {"data": JSON.stringify(out)},
			cache: false,
			success: function(data){
				var newData = JSON.parse(data.substr(1,data.length));
									//alert(newData);
				if(newData.command == "clientLogout"){
					if(newData.data == "success"){
						window.location="../index.html";
					}
				}
			}
		});
		//alert("logout");
	});
}