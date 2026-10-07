<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solution | My Calendar</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
  
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #2a0080;
        --mtn-deep: #120038;
        --bloom-orange: #e46c44;
        --bloom-success: #10b981;
        --glass: rgba(255, 255, 255, 0.95);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; font-size: 13px; color: #334155; }

    /* --- FULLCALENDAR CUSTOM UI (UNCHANGED) --- */
    .fc { padding: 10px; }
    .fc-toolbar-title { font-size: 1.4rem !important; font-weight: 800 !important; color: var(--mtn-deep); }
    
    .fc-button { 
        background: #fff !important; 
        color: var(--bloom-purple) !important; 
        border: 1px solid #e2e8f0 !important;
        font-weight: 700 !important;
        text-transform: capitalize !important;
        padding: 8px 16px !important;
        border-radius: 12px !important;
        transition: 0.3s !important;
        box-shadow: none !important;
    }
    .fc-button-primary:not(:disabled):active, 
    .fc-button-primary:not(:disabled).fc-button-active {
        background: var(--bloom-purple) !important;
        color: #fff !important;
        border-color: var(--bloom-purple) !important;
    }
    .fc-button:hover { background: #f8faff !important; border-color: var(--bloom-purple) !important; }

    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9 !important; }
    .fc-col-header-cell-cushion { color: #64748b; font-weight: 700; padding: 12px 0 !important; text-decoration: none !important; }
    .fc-daygrid-day-number { font-weight: 600; color: #475569; padding: 10px !important; text-decoration: none !important; }
    
    .fc-daygrid-day.fc-day-today { background: rgba(74, 0, 224, 0.04) !important; }
    .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: var(--bloom-purple); font-weight: 800; }

    .fc-event { 
        border: none !important; 
        padding: 4px 8px !important; 
        border-radius: 8px !important; 
        font-weight: 600 !important; 
        font-size: 11px !important;
        margin: 2px 4px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        cursor: pointer;
    }
    /* --- END MAIN CALENDAR CSS --- */

    .nav-pills .nav-link.active{ background:#007bff!important; color:#fff!important; }
    .legend-item { display: flex; align-items: center; margin-bottom: 12px; font-weight: 600; font-size: 12px; }
    .dot { width: 12px; height: 12px; border-radius: 4px; margin-right: 10px; }

    /* Mini Calendar Styles */
    .mini-cal-card { background: #fff; border-radius: 15px; margin-bottom: 15px; border: 1px solid #e2e8f0; }
    .mini-cal-header { display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #f8faff; border-radius: 15px 15px 0 0; }
    .mini-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; padding: 10px; }
    .mini-day-head { font-weight: 800; color: #94a3b8; font-size: 10px; }
    .mini-day {
    padding: 8px 0;
    font-weight: 700;
    font-size: 12px;
    border-radius: 6px;
}

    .btn-holiday {
        background: var(--bloom-orange); color: white !important; font-weight: 700; border-radius: 10px; width: 100%; margin-bottom: 15px; border: none; padding: 8px;
    }

    .main-footer { background: #fff !important; border-top: 1px solid #e2e8f0 !important; font-size: 12px; padding: 1rem 1.5rem !important; }

    .fc-daygrid-day.holiday-day {
    background: #ffe5e5 !important;
}

.fc-daygrid-day.sunday-day {
    background: #f1f5f9 !important;
}

.fc-daygrid-day.fc-day-today {
    background: #fff8c5 !important;
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 

  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-lg-9">
            <div class="card card-bloom">
              <div class="card-body">
                <!-- MAIN CALENDAR (UNCHANGED) -->
                <div id="calendar"></div>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <!-- MINI CALENDAR (ABOVE EVENT KEY) -->
            <div class="mini-cal-card shadow-sm">
                <div class="mini-cal-header text-xs">
                    <span id="miniMonthYear" class="font-weight-bold">April 2026</span>
                    <div>
                        <i class="fas fa-chevron-left mr-2" style="cursor:pointer" onclick="changeMiniMonth(-1)"></i>
                        <i class="fas fa-chevron-right" style="cursor:pointer" onclick="changeMiniMonth(1)"></i>
                    </div>
                </div>
                <div class="mini-cal-grid" id="miniCalGrid"></div>
            </div>

            <!-- HOLIDAY BUTTON -->
           <a href="<?= base_url('aut_pages/holidays') ?>" 
   class="btn btn-holiday btn-sm shadow-sm">
    <i class="fas fa-calendar-check mr-2"></i> Holiday List
</a>

            <div class="card card-bloom p-4">
                <h6 class="font-weight-bold mb-4" style="color: var(--mtn-deep);">Event Key</h6>
                
                <div class="legend-item"><div class="dot" style="background: var(--bloom-purple);"></div><span>Meetings / Reviews</span></div>
                <div class="legend-item"><div class="dot" style="background: var(--bloom-orange);"></div><span>Public Holidays</span></div>
                <div class="legend-item"><div class="dot" style="background: var(--bloom-success);"></div><span>Approved Leaves</span></div>

                <hr class="my-4">
                
                <div class="bg-light p-3 rounded-lg">
                    <p class="small font-weight-bold text-muted mb-2">Upcoming This Week</p>
                    <div id="upcomingEventsList"></div>
                </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>

  <!-- EVENT MANAGEMENT MODAL (POPUP) -->
  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" style="border-radius: 15px;">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="modalHeader">Event Details</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="eventId">
            <div class="form-group">
                <label class="small font-weight-bold">Event Name</label>
                <input type="text" id="eventTitle" class="form-control" placeholder="Enter title">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">Date</label>
                        <input type="date" id="eventDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small font-weight-bold">Time</label>
                        <input type="time" id="eventTime" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-danger btn-sm mr-auto d-none" id="btnDelete" onclick="deleteEvent()">Delete</button>
          <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="saveEvent()" style="background:var(--bloom-purple); border:none;">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

 
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<?php
$holidayEvents = [];

foreach ($holiday as $row) {

    // Add all holidays except Sunday (WEEK_OFF)
    if ($row['holiday_type'] !== 'WEEK_OFF') {

        $holidayEvents[] = [
            'date' => $row['holiday_date'],
            'name' => $row['holiday_name']
        ];
    }
}
?>
<script>
const holidayEvents = <?= json_encode($holidayEvents) ?>;
const holidayDates = holidayEvents.map(h => h.date);

const todayStr = new Date().toISOString().split('T')[0];

  let mainCalendar;
  let mDate = new Date();

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    mainCalendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 'auto',
      aspectRatio: 1.8,

      dayCellDidMount: function(info) {

    const year = info.date.getFullYear();
    const month = String(info.date.getMonth() + 1).padStart(2, '0');
    const day = String(info.date.getDate()).padStart(2, '0');

    const dateStr = `${year}-${month}-${day}`;

    // Today (highest priority)
    const today = new Date();
    const todayStr =
    today.getFullYear() + '-' +
    String(today.getMonth() + 1).padStart(2, '0') + '-' +
    String(today.getDate()).padStart(2, '0');

   if (dateStr === todayStr) {

    info.el.style.backgroundColor = '#ffd54f';
    info.el.style.border = '1px solid #ffb300';

    const todayLabel = document.createElement('div');
    todayLabel.innerHTML = "Today";

    todayLabel.style.position = "absolute";
    todayLabel.style.top = "50%";
    todayLabel.style.left = "50%";
    todayLabel.style.transform = "translate(-50%, -50%)";

    todayLabel.style.fontSize = "11px";
    todayLabel.style.fontWeight = "700";
    todayLabel.style.color = "#8a5a00";
    todayLabel.style.textAlign = "center";
    todayLabel.style.width = "90%";
    todayLabel.style.lineHeight = "14px";

    info.el.style.position = "relative";
    info.el.appendChild(todayLabel);

    info.el.title = "Today";

    return;
}

    // Holiday (Festival + National)
   const holidayObj = holidayEvents.find(h => h.date === dateStr);

if (holidayObj) {

    info.el.style.backgroundColor = '#ffb3b3';
    info.el.style.border = '1px solid #ff4d4d';

    const holidayLabel = document.createElement('div');
holidayLabel.innerHTML = holidayObj.name;

holidayLabel.style.position = 'absolute';
holidayLabel.style.top = '50%';
holidayLabel.style.left = '50%';
holidayLabel.style.transform = 'translate(-50%, -50%)';

holidayLabel.style.fontSize = '11px';
holidayLabel.style.fontWeight = '700';
holidayLabel.style.color = '#b91c1c';
holidayLabel.style.textAlign = 'center';
holidayLabel.style.width = '90%';
holidayLabel.style.lineHeight = '14px';

info.el.style.position = 'relative';
info.el.appendChild(holidayLabel);

    info.el.title = holidayObj.name;

    return;
}

    // Sunday
    if (info.date.getDay() === 0) {
        info.el.style.backgroundColor = '#d1d5db';
    }
},

      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      
      selectable: true,
      dateClick: function(info) {
        openEventModal(null, info.dateStr);
      },
      eventClick: function(info) {
        openEventModal(info.event);
      }
    });
    mainCalendar.render();
    renderMiniCalendar();
    updateUpcomingList();
  });

  function openEventModal(event = null, dateStr = null) {
    $('#eventModal').modal('show');
    if (event) {
        $('#modalHeader').text('Edit Event');
        $('#eventId').val(event.id);
        $('#eventTitle').val(event.title);
        $('#eventDate').val(event.startStr.split('T')[0]);
        $('#eventTime').val(event.startStr.includes('T') ? event.startStr.split('T')[1].substring(0,5) : "10:00");
        $('#btnDelete').removeClass('d-none');
    } else {
        $('#modalHeader').text('Add New Event');
        $('#eventId').val('');
        $('#eventTitle').val('');
        $('#eventDate').val(dateStr);
        $('#eventTime').val("10:00");
        $('#btnDelete').addClass('d-none');
    }
  }

  function saveEvent() {
    const id = $('#eventId').val();
    const title = $('#eventTitle').val();
    const start = $('#eventDate').val() + 'T' + $('#eventTime').val();

    if (!title) return alert("Title is required");

    if (id) {
        let ev = mainCalendar.getEventById(id);
        ev.setProp('title', title);
        ev.setStart(start);
    } else {
        mainCalendar.addEvent({
            id: String(Date.now()),
            title: title,
            start: start,
            backgroundColor: '#4a00e0'
        });
    }
    $('#eventModal').modal('hide');
    updateUpcomingList();
  }

  function deleteEvent() {
    mainCalendar.getEventById($('#eventId').val()).remove();
    $('#eventModal').modal('hide');
    updateUpcomingList();
  }

  function updateUpcomingList() {
    const list = document.getElementById('upcomingEventsList');
    list.innerHTML = '';
    mainCalendar.getEvents().slice(0, 4).forEach(ev => {
        const d = new Date(ev.start).toLocaleDateString('en-US', { month: 'short', day: '2-digit' });
        list.innerHTML += `<div class="small mb-2"><b>${ev.title}</b> <span class="text-muted">(${d})</span></div>`;
    });
  }

  function renderMiniCalendar() {
    const grid = document.getElementById('miniCalGrid');
    grid.innerHTML = '';
    ['S','M','T','W','T','F','S'].forEach(d => grid.innerHTML += `<div class="mini-day-head">${d}</div>`);
    const y = mDate.getFullYear(), m = mDate.getMonth();
    document.getElementById('miniMonthYear').innerText = mDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    const firstDay = new Date(y, m, 1).getDay();
    const daysInMonth = new Date(y, m + 1, 0).getDate();
    for(let i=0; i<firstDay; i++) grid.innerHTML += `<div></div>`;
    for (let d = 1; d <= daysInMonth; d++) {

    const dateStr =
        y + '-' +
        String(m + 1).padStart(2, '0') + '-' +
        String(d).padStart(2, '0');

    const currentDate = new Date(y, m, d);

    let bgColor = '#ffffff';
    let border = '';

    // Today
    if (dateStr === todayStr) {
        bgColor = '#ffd54f';
        border = '2px solid #ffb300';
    }

    // Holiday (Company / Festival / National)
    else if (holidayDates.includes(dateStr)) {
        bgColor = '#ffb3b3';
        border = '1px solid #ff4d4d';
    }

    // Sunday
    else if (currentDate.getDay() === 0) {
        bgColor = '#d1d5db';
    }

    grid.innerHTML += `
        <div class="mini-day"
             style="
                background:${bgColor};
                border:${border};
                border-radius:6px;
                margin:1px;
             ">
             ${d}
        </div>`;
}
  }

  function changeMiniMonth(offset) {
    mDate.setMonth(mDate.getMonth() + offset);
    renderMiniCalendar();
  }
</script>
</body>
</html>