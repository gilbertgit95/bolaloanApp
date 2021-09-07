//_____________________________ calendar proccess class______________________________
var CalendarClass = function(){
	this.displayDate;
	this.modalId;
	this.display;
	this.heading;
	this.calendarBtn;
	this.viewBtn;
	this.dateArray;
	this.init = function(displayId , headingId, calendarBtnId, viewBtnId, calendarDateArray, modalId){

		// assign id to variables
		this.display = displayId;
		this.heading = headingId;
		this.calendarBtn = calendarBtnId;
		this.viewBtn = viewBtnId;
		this.dateArray = calendarDateArray;
		this.modalId = modalId;

		// initiate calendar events
		calendarEvents.init();
	};

};

// calendar proccess object
var calendarProc = new CalendarClass();

//_____________________________ calendar events class______________________________
var CalendarEventsClass = function(){
	this.init = function(){
		this.getDate();
		// event and processes when clicking the calendar button
		calendarProc.calendarBtn.bind("click", function(){
			calendarProc.dateArray.eq(0).val(calendarProc.heading.find("span").eq(0).text());
			calendarProc.dateArray.eq(1).val(calendarProc.heading.find("span").eq(1).text());
			calendarProc.dateArray.eq(2).val(calendarProc.heading.find("span").eq(2).text());
			//alert("calendar");
		});

		// process when clicking the view button in the calendar modal box
		calendarProc.viewBtn.bind("click", function(){
			calendarProc.display.slideUp();
			calendarProc.modalId.modal("toggle");

			// get the values from heading
			var month = calendarProc.dateArray.eq(0).val();
			var day = calendarProc.dateArray.eq(1).val();
			var year = calendarProc.dateArray.eq(2).val();

			// change the values in heading date
			calendarProc.heading.find("span").eq(0).text(month);
			calendarProc.heading.find("span").eq(1).text(day);
			calendarProc.heading.find("span").eq(2).text(year);

			// change date format to numerical format
			if(month == "Jan"){
				month = 01;
			}else if(month == "Feb"){
				month = 02;
			}else if(month == "Mar"){
				month = 03;
			}else if(month == "Apr"){
				month = 04;
			}else if(month == "May"){
				month = 05;
			}else if(month == "Jun"){
				month = 06;
			}else if(month == "Jul"){
				month = 07;
			}else if(month == "Aug"){
				month = 08;
			}else if(month == "Sep"){
				month = 09;
			}if(month == "Oct"){
				month = 10;
			}else if(month == "Nov"){
				month = 11;
			}else if(month == "Dec"){
				month = 12;
			}
					var out = {
						command: "ordersByDate",
						data: year+"-"+month+"-"+day,
						//data: year+"-"+month+"-"+(parseInt(day)-1),
					};
					calendarProc.displayDate = out.data;
					$.ajax({
						type: "POST",
						url: "../scripts/php/custom/statOrderFetch.php",
						data: {"data": JSON.stringify(out)},
						cache: false,
						success: function(data){
							//alert(data);

							var newData = JSON.parse(data.substr(1,data.length));
							if(newData.command == "ordersByDate"){
								if(newData.status == "success"){
									statButtonEvents.verifiedUnbind();
									statButtonEvents.deleteUnbind();
									calendarProc.display.html(newData.data);
									statButtonEvents.viewVerifiedItems();
									statButtonEvents.deleteItems();
									calendarProc.display.slideDown();
								}else{
									// error query
									calendarProc.display.html("<h2>Error action</h2>");
								}
							}else{
								// error query
								calendarProc.display.html("<h2>Error action</h2>");
							}
						}
					});
		//	alert(month+" "+day+", "+year);
		});
	};
	this.getDate = function(){
			calendarProc.dateArray.eq(0).val(calendarProc.heading.find("span").eq(0).text());
			calendarProc.dateArray.eq(1).val(calendarProc.heading.find("span").eq(1).text());
			calendarProc.dateArray.eq(2).val(calendarProc.heading.find("span").eq(2).text());
			
			var month = calendarProc.dateArray.eq(0).val();
			var day = calendarProc.dateArray.eq(1).val();
			var year = calendarProc.dateArray.eq(2).val();

			// change date format to numerical format
			if(month == "Jan"){
				month = 01;
			}else if(month == "Feb"){
				month = 02;
			}else if(month == "Mar"){
				month = 03;
			}else if(month == "Apr"){
				month = 04;
			}else if(month == "May"){
				month = 05;
			}else if(month == "Jun"){
				month = 06;
			}else if(month == "Jul"){
				month = 07;
			}else if(month == "Aug"){
				month = 08;
			}else if(month == "Sep"){
				month = 09;
			}if(month == "Oct"){
				month = 10;
			}else if(month == "Nov"){
				month = 11;
			}else if(month == "Dec"){
				month = 12;
			}

			calendarProc.displayDate = year+"-"+month+"-"+day;
	};
};

// calendar events object
var calendarEvents = new CalendarEventsClass();