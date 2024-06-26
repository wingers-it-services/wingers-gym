 <div class="calendar">
 	<div class="calender-header">
 		<div class="month">July 2021</div>
 		<div class="btns">
 			<!-- today -->
 			<div class="btn today">
 				<i class="fas fa-calendar-day"></i>
 			</div>
 			<!-- previous month -->
 			<div class="btn prev">
 				<i class="fas fa-chevron-left"></i>
 			</div>
 			<!-- next month -->
 			<div class="btn next">
 				<i class="fas fa-chevron-right"></i>
 			</div>
 		</div>
 	</div>
 	<div class="weekdays">
 		<div class="day">Sun</div>
 		<div class="day">Mon</div>
 		<div class="day">Tue</div>
 		<div class="day">Wed</div>
 		<div class="day">Thu</div>
 		<div class="day">Fri</div>
 		<div class="day">Sat</div>
 	</div>
 	<div class="days">
 		<!-- render days with js -->
 	</div>
 </div>




 <style>
 	@import url(https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic);

 	:root {
 		--primary-color: #f90a39;
 		--text-color: #1d1d1d;
 		--bg-color: #f1f1fb;
 	}

 	* {
 		margin: 0;
 		padding: 0;
 		box-sizing: border-box;
 		font-family: "Poppins", sans-serif;
 	}

 	body {
 		background: #ffffff;
 	}

 	.container {
 		width: 100%;
 		min-height: 100vh;
 		display: flex;
 		align-items: center;
 		justify-content: center;
 	}

 	.calendar {
 		width: 100%;
 		background: var(--bg-color);
 		padding: 30px 20px;
 		border-radius: 10px;
 	}

 	.calendar .calender-header {
 		display: flex;
 		justify-content: space-between;
 		align-items: center;
 		margin-bottom: 20px;
 		padding-bottom: 20px;
 		border-bottom: 2px solid #ccc;
 	}

 	.calendar .calender-header .month {
 		display: flex;
 		align-items: center;
 		font-size: 25px;
 		font-weight: 600;
 		color: var(--text-color);
 	}

 	.calendar .calender-header .btns {
 		display: flex;
 		gap: 10px;
 	}

 	.calendar .calender-header .btns .btn {
 		width: 50px;
 		height: 40px;
 		background: var(--primary-color);
 		display: flex;
 		justify-content: center;
 		align-items: center;
 		border-radius: 5px;
 		color: #fff;
 		font-size: 16px;
 		cursor: pointer;
 		transition: all 0.3s;
 	}

 	.calendar .calender-header .btns .btn:hover {
 		background: #db0933;
 		transform: scale(1.05);
 	}

 	.calendar .weekdays {
 		display: flex;
 		gap: 10px;
 		margin-bottom: 10px;
 	}

 	.calendar .weekdays .day {
 		width: calc(100% / 7 - 10px);
 		text-align: center;
 		font-size: 16px;
 		font-weight: 600;
 	}

 	.calendar .days {
 		display: flex;
 		flex-wrap: wrap;
 		gap: 10px;
 	}

 	.calendar .days .day {
 		width: calc(100% / 7 - 10px);
 		height: 50px;
 		background: #fff;
 		display: flex;
 		justify-content: center;
 		align-items: center;
 		border-radius: 5px;
 		font-size: 16px;
 		font-weight: 400;
 		color: var(--text-color);
 		transition: all 0.3s;
 		user-select: none;
 	}

 	.calendar .days .day:not(.next):not(.prev):hover {
 		color: #fff;
 		background: var(--primary-color);
 		transform: scale(1.05);
 	}

 	.calendar .days .day.next,
 	.calendar .days .day.prev {
 		color: #ccc;
 	}

 	/* .calendar .days .day.today {
 		color: #fff;
 		background: var(--primary-color);
 	} */

 	.credits a {
 		position: absolute;
 		bottom: 10px;
 		left: 50%;
 		transform: translateX(-50%);
 		font-size: 14px;
 		color: #aaa;
 	}

 	.credits span {
 		color: var(--primary-color);
 	}
 </style>

 <!-- <script>
 	const daysContainer = document.querySelector(".days");
 	const nextBtn = document.querySelector(".next");
 	const prevBtn = document.querySelector(".prev");
 	const todayBtn = document.querySelector(".today");
 	const month = document.querySelector(".month");

 	const months = [
 		"January",
 		"February",
 		"March",
 		"April",
 		"May",
 		"June",
 		"July",
 		"August",
 		"September",
 		"October",
 		"November",
 		"December",
 	];

 	const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

 	const date = new Date();
 	let currentMonth = date.getMonth();
 	let currentYear = date.getFullYear();

 	const renderCalendar = () => {
 		date.setDate(1);
 		const firstDay = new Date(currentYear, currentMonth, 1);
 		const lastDay = new Date(currentYear, currentMonth + 1, 0);
 		const lastDayIndex = lastDay.getDay();
 		const lastDayDate = lastDay.getDate();
 		const prevLastDay = new Date(currentYear, currentMonth, 0);
 		const prevLastDayDate = prevLastDay.getDate();
 		const nextDays = 7 - lastDayIndex - 1;

 		month.innerHTML = `${months[currentMonth]} ${currentYear}`;

 		let days = "";

 		for (let x = firstDay.getDay(); x > 0; x--) {
 			days += `<div class="day prev">${prevLastDayDate - x + 1}</div>`;
 		}

 		for (let i = 1; i <= lastDayDate; i++) {
 			if (
 				i === new Date().getDate() &&
 				currentMonth === new Date().getMonth() &&
 				currentYear === new Date().getFullYear()
 			) {
 				days += `<div class="day today">${i}</div>`;
 			} else {
 				days += `<div class="day">${i} P </div>`;
 			}
 		}

 		for (let j = 1; j <= nextDays; j++) {
 			days += `<div class="day next">${j} </div>`;
 		}

 		daysContainer.innerHTML = days;
 		hideTodayBtn();
 	};

 	nextBtn.addEventListener("click", () => {
 		currentMonth++;
 		if (currentMonth > 11) {
 			currentMonth = 0;
 			currentYear++;
 		}
 		renderCalendar();
 	});

 	prevBtn.addEventListener("click", () => {
 		currentMonth--;
 		if (currentMonth < 0) {
 			currentMonth = 11;
 			currentYear--;
 		}
 		renderCalendar();
 	});

 	todayBtn.addEventListener("click", () => {
 		currentMonth = date.getMonth();
 		currentYear = date.getFullYear();
 		renderCalendar();
 	});

 	function hideTodayBtn() {
 		if (
 			currentMonth === new Date().getMonth() &&
 			currentYear === new Date().getFullYear()
 		) {
 			todayBtn.style.display = "none";
 		} else {
 			todayBtn.style.display = "flex";
 		}
 	}

 	renderCalendar();
 </script> -->