			function pageHead(){
				var statList = $("#stat");
				var setList = $("#settings");
				var statbtn = $("#stat-btn");
				var setbtn = $("#set-btn");

				statList.removeClass("hide");
				setList.removeClass("hide");

				statList.toggle();
				setList.toggle();

				var pageHeadH = $(".page-head").outerHeight();
				var statbtnX = statbtn.position().left;
				var setbtnX = setbtn.position().left;

				statList.css("top", pageHeadH+"px");
				statList.css("left", statbtnX+"px");
				setList.css("top", pageHeadH+"px");
				setList.css("left", setbtnX+"px");

				statbtn.bind("click", function(){ //event binding
					statList.slideToggle("slow");
					setList.slideUp("slow");
				});

				setbtn.bind("click", function(){
					setList.slideToggle("slow");
					statList.slideUp("slow");
				});
			}
			function checkedEvent(){
				var checkedBox = $(".checked");
				checkedBox.attr("title", "disable or enable");
				checkedBox.bind("click", function(){
					if($(this).hasClass("glyphicon-ok-sign")){
						$(this).removeClass("glyphicon-ok-sign");
						$(this).addClass("glyphicon-remove-sign");
					}else{
						$(this).removeClass("glyphicon-remove-sign");
						$(this).addClass("glyphicon-ok-sign");
					}
				});
			}
			function checkUnbind(){
				$(".checked").unbind("click");
			}