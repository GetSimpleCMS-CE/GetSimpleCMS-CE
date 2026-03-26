<?php
/**
 * Module Name: Calendar
 * Module ID: simplecal
 * Description: Displays a localized calendar.
 * Version: 1.0
 * Default W: 4
 * Default H: 4
 */
 
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Unique ID to avoid conflicts between modules (optional)
$uid = 'sc_' . substr(md5(__FILE__), 0, 6);
?>

<style>
#<?php echo $uid ?>-clock {
	color:var(--main-color);
	text-align: center;
	font-size: 1.5rem;
	font-weight: 500;
	letter-spacing: 0.05em;
	margin-bottom: 8px;
	opacity: 0.75;
}

#<?php echo $uid ?>-cal {
	width: 90%;
	max-width: 480px;
	margin: auto;
	font-family: system-ui, sans-serif;
}

#<?php echo $uid ?>-cal .cal-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 8px;
}

#<?php echo $uid ?>-cal .cal-nav {
	background: none;
	border: none;
	font-size: 18px;
	cursor: pointer;
	width: 28px;
}

#<?php echo $uid ?>-cal .cal-today {
	font-size: 12px;
	border: 1px solid #ccc;
	background: #f7f7f7;
	border-radius: 4px;
	padding: 2px 6px;
	cursor: pointer;
}

#<?php echo $uid ?>-cal .cal-grid {
	display: grid;
	grid-template-columns: repeat(7, 1fr);
	gap: 4px;
}

#<?php echo $uid ?>-cal .cal-title {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 6px;
	font-weight: 600;
	text-align: center;
	flex: 1;
	color:var(--main-color);
	opacity: .7;
}

#<?php echo $uid ?>-cal .cal-icon svg {
	width: 16px;
	height: 16px;
	opacity: .8;
	vertical-align: middle;
	opacity: .5;
}

#<?php echo $uid ?>-cal .cal-dayname {
	text-align: center;
	font-size: 12px;
	opacity: .6;
}

#<?php echo $uid ?>-cal .cal-day {
	text-align: center;
	padding: 4px;
	border-radius: 4px;
	cursor: pointer;
	position: relative;
}

#<?php echo $uid ?>-cal .cal-day:hover {
	background: #eee;
}

#<?php echo $uid ?>-cal .cal-day.today {
	background: var(--main-color);
	opacity: 0.4;
	color: rgba(255, 255, 255, 1) !important;
}

#<?php echo $uid ?>-cal .cal-day.weekend {
	color: #c33;
}

#<?php echo $uid ?>-cal .cal-event::after {
	content: "";
	width: 4px;
	height: 4px;
	border-radius: 50%;
	background: #3b82f6;
	position: absolute;
	bottom: 3px;
	left: 50%;
	transform: translateX(-50%);
}
</style>

<div id="<?php echo $uid ?>-clock"></div>

<div id="<?php echo $uid ?>-cal"></div>

<script>
(function() {
	var clockEl = document.getElementById("<?php echo $uid ?>-clock");
	function updateClock() {
		clockEl.textContent = new Intl.DateTimeFormat(navigator.language, {
			timeStyle: 'medium'
		}).format(new Date());
	}
	updateClock();
	setInterval(updateClock, 1000);
})();
</script>

<script>
(function() {

const calEl = document.getElementById("<?php echo $uid ?>-cal");

let date = new Date();
const locale = navigator.language;

let firstDay = 1;
let weekend = [0, 6];

try {
	const info = new Intl.Locale(locale).weekInfo;
	if (info) {
		firstDay = info.firstDay;
		weekend = info.weekend;
	}
} catch (e) {}

const events = {
	/*
  "2026-03-10":true,
  "2026-03-15":true
  */
};

function renderCalendar() {

	const year = date.getFullYear();
	const month = date.getMonth();

	const first = new Date(year, month, 1);
	const last = new Date(year, month + 1, 0);

	const title = new Intl.DateTimeFormat(locale, {
		month: "long",
		year: "numeric"
	}).format(date);

	calEl.innerHTML = `
<div class="cal-header">
	<button class="cal-nav" id="prev">‹</button>
	<div class="cal-title">
		<span class="cal-icon">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
				<path d="M7 2v2H5a2 2 0 0 0-2 2v2h18V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7zm14 8H3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V10z"/>
			</svg>
		</span>
		${title}
	</div>
	<button class="cal-nav" id="next">›</button>
</div>
<!--div style="text-align:center;margin-bottom:6px">
	<button class="cal-today" id="todayBtn">Today</button>
</div-->
<div class="cal-grid" id="grid"></div>
`;

	const grid = calEl.querySelector("#grid");

	const weekdayFormatter =
		new Intl.DateTimeFormat(locale, {
			weekday: "short"
		});

	let weekdayIndex = (firstDay % 7);

	for (let i = 0; i < 7; i++) {
		const d = new Date(2023, 0, weekdayIndex + 1);
		const el = document.createElement("div");
		el.className = "cal-dayname";
		el.textContent = weekdayFormatter.format(d);
		grid.appendChild(el);
		weekdayIndex = (weekdayIndex + 1) % 7;
	}

	let offset = (first.getDay() - (firstDay % 7) + 7) % 7;

	for (let i = 0; i < offset; i++) {
		grid.appendChild(document.createElement("div"));
	}

	const today = new Date();

	for (let d = 1; d <= last.getDate(); d++) {

		const current = new Date(year, month, d);

		const el = document.createElement("div");
		el.className = "cal-day";
		el.textContent = d;

		const weekday = current.getDay();

		if (weekend.includes(weekday))
			el.classList.add("weekend");

		if (
			d === today.getDate() &&
			month === today.getMonth() &&
			year === today.getFullYear()
		) {
			el.classList.add("today");
		}

		const iso = current.toISOString().slice(0, 10);

		if (events[iso])
			el.classList.add("cal-event");

		el.onclick = () => {
			console.log("Selected:", iso);
		};

		grid.appendChild(el);
	}

	calEl.querySelector("#prev").onclick = () => {
		date.setMonth(date.getMonth() - 1);
		renderCalendar();
	};

	calEl.querySelector("#next").onclick = () => {
		date.setMonth(date.getMonth() + 1);
		renderCalendar();
	};

	const todayBtn = calEl.querySelector("#todayBtn");

	if (todayBtn) {
		todayBtn.onclick = () => {
			date = new Date();
			renderCalendar();
		};
	}
}

renderCalendar();

})();
</script>