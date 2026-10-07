```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Bloom Solutions | Attendance</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>

:root{
--bloom-purple:#4a00e0;
--bloom-dark:#111c43;
--bloom-orange:#e46c44;
--soft-gray:#f4f7fe;
}

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:var(--soft-gray);
font-size:13px;
color:#334155;
}

.sidebar{
background:#111c43!important;
}

/* HERO */

.attendance-hero{
background:linear-gradient(135deg,#111c43 0%,#4a00e0 100%);
border-radius:16px;
padding:24px;
color:white;
margin-bottom:16px;
}

#live-time{
font-size:2.2rem;
font-weight:700;
}

/* STAT CARDS */

.stat-card{
background:#fff;
border-radius:14px;
padding:14px;
display:flex;
align-items:center;
height:80px;
margin-bottom:14px;
border:1px solid rgba(0,0,0,0.04);
}

.stat-icon{
width:40px;
height:40px;
border-radius:8px;
display:flex;
align-items:center;
justify-content:center;
margin-right:10px;
font-size:15px;
}

/* CALENDAR */

.card-premium{
background:#fff;
border-radius:16px;
box-shadow:0 4px 12px rgba(0,0,0,0.04);
border:1px solid #edf2f7;
padding:25px;
}

.cal-grid{
display:grid;
grid-template-columns:repeat(7,1fr);
gap:8px;
margin-top:10px;
}

.cal-day{
height:55px;
display:flex;
align-items:center;
justify-content:center;
border-radius:10px;
font-size:14px;
font-weight:600;
background:#f8fafc;
border:1px solid #f1f5f9;
}

.cal-present{background:#dcfce7;color:#15803d;border:none;}
.cal-absent{background:#fee2e2;color:#b91c1c;border:none;}
.cal-wfh{background:#e0e7ff;color:#4338ca;border:none;}
.cal-leave{background:#fef3c7;color:#b45309;border:none;}
.cal-today{background:var(--bloom-purple)!important;color:#fff!important;}

.calendar-legend{
display:flex;
gap:20px;
margin-top:18px;
flex-wrap:wrap;
font-size:13px;
}
.nav-pills .nav-link.active{ background:#007bff!important; color:#fff!important; }
.legend-item{
display:flex;
align-items:center;
}

.legend-color{
width:14px;
height:14px;
border-radius:4px;
margin-right:6px;
}

.main-footer{
font-size:13px;
background:#fff;
border-top:1px solid #e2e8f0;
text-align:center;
padding:10px;
}

</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">


<!-- CONTENT -->

<div class="content-wrapper">

<section class="content pt-3">

<div class="container-fluid">

<!-- HERO -->

<div class="attendance-hero">

<div class="row align-items-center">

<div class="col-md-7">

<h1 id="live-time">00:00:00</h1>
<p class="mb-0">Live Attendance System</p>

</div>

<div class="col-md-5 text-right">

<button class="btn btn-light mr-2">
<i class="fas fa-fingerprint"></i> Punch In
</button>

<button class="btn btn-outline-light">
Break
</button>

</div>

</div>

</div>

<!-- STATS -->

<div class="row">

<div class="col-md-4 col-6">

<a href="present.html" style="text-decoration:none;color:inherit;">
<div class="stat-card">

<div class="stat-icon" style="background:#dcfce7;color:#15803d">
<i class="fas fa-user-check"></i>
</div>

<div>
<strong>23</strong><br>
<small>Present</small>
</div>

</div>
</a>

</div>


<div class="col-md-4 col-6">

<a href="absent.html" style="text-decoration:none;color:inherit;">
<div class="stat-card">

<div class="stat-icon" style="background:#fee2e2;color:#b91c1c">
<i class="fas fa-user-times"></i>
</div>

<div>
<strong>01</strong><br>
<small>Absent</small>
</div>

</div>
</a>

</div>


<div class="col-md-4 col-6">

<a href="wfh.html" style="text-decoration:none;color:inherit;">
<div class="stat-card">

<div class="stat-icon" style="background:#e0e7ff;color:#4338ca">
<i class="fas fa-laptop-house"></i>
</div>

<div>
<strong>04</strong><br>
<small>WFH</small>
</div>

</div>
</a>

</div>
</div>
</div>
<!-- CALENDAR CARD -->

<div class="card-premium">

<div class="d-flex justify-content-between mb-3">

<h6 class="font-weight-bold">Attendance Calendar</h6>

</div>

<!-- FILTERS -->

<div class="row mb-3">

<div class="col-md-4">

<input type="text" id="empId" class="form-control" placeholder="Employee ID">

</div>

<div class="col-md-3">

<select id="monthFilter" class="form-control">

<option value="0">January</option>
<option value="1">February</option>
<option value="2">March</option>
<option value="3">April</option>
<option value="4">May</option>
<option value="5">June</option>
<option value="6">July</option>
<option value="7">August</option>
<option value="8">September</option>
<option value="9">October</option>
<option value="10">November</option>
<option value="11">December</option>

</select>

</div>

<div class="col-md-3">

<select id="yearFilter" class="form-control">

<option>2024</option>
<option>2025</option>
<option selected>2026</option>
<option>2027</option>

</select>

</div>

<div class="col-md-2">

<button class="btn btn-primary btn-block" onclick="loadCalendar()">
View
</button>

</div>

</div>

<!-- CALENDAR -->

<div class="cal-grid" id="calendarGrid"></div>

<div class="calendar-legend">

<div class="legend-item">
<div class="legend-color" style="background:#dcfce7"></div>Present
</div>

<div class="legend-item">
<div class="legend-color" style="background:#fee2e2"></div>Absent
</div>

<div class="legend-item">
<div class="legend-color" style="background:#e0e7ff"></div>WFH
</div>

<div class="legend-item">
<div class="legend-color" style="background:#fef3c7"></div>Leave
</div>

</div>

</div>

</div>

</section>

</div>



</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>

function updateClock(){

const now=new Date();

document.getElementById("live-time").textContent=
now.toLocaleTimeString("en-GB");

}

setInterval(updateClock,1000);

updateClock();

/* Calendar Generator */

function loadCalendar(){

const month=document.getElementById("monthFilter").value;

const year=document.getElementById("yearFilter").value;

const empId=document.getElementById("empId").value;

const calendar=document.getElementById("calendarGrid");

calendar.innerHTML="";

const days=["M","T","W","T","F","S","S"];

days.forEach(d=>{

const el=document.createElement("div");

el.className="text-center font-weight-bold text-muted";

el.innerText=d;

calendar.appendChild(el);

});

const firstDay=new Date(year,month,1).getDay();

const daysInMonth=new Date(year,parseInt(month)+1,0).getDate();

let start=firstDay===0?6:firstDay-1;

for(let i=0;i<start;i++){

calendar.appendChild(document.createElement("div"));

}

for(let day=1;day<=daysInMonth;day++){

let dateBox=document.createElement("div");

dateBox.className="cal-day";

dateBox.innerText=day;

/* Demo Attendance */

if(day%6===0){

dateBox.classList.add("cal-absent");

}

else if(day%5===0){

dateBox.classList.add("cal-wfh");

}

else if(day%7===0){

dateBox.classList.add("cal-leave");

}

else{

dateBox.classList.add("cal-present");

}

calendar.appendChild(dateBox);

}

console.log("Showing attendance for employee:",empId);

}

loadCalendar();

</script>

</body>
</html>
```

