<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solutions | Holidays</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

    <style>
        :root {
            --primary: #4a00e0;
            --dark: #111c43;
            --bg: #f4f7fe;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
        }

        .content-wrapper {
            background: var(--bg);
            min-height: 100vh;
            padding: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--dark), var(--primary));
            color: #fff;
            padding: 22px 28px;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(74,0,224,.18);
        }

        .page-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .page-header p {
            margin: 6px 0 0;
            opacity: .9;
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.06);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
        background: #4a00e0;
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 14px;
        text-align: center;
    }

        .table tbody td {
            vertical-align: middle;
            padding: 14px;
            border-color: #eef2f7;
        }

        .table-hover tbody tr:hover {
            background: #f8f9ff;
        }
        .holiday-table {
            max-height: 500px;
            overflow-y: auto;
        }

.holiday-table thead th {
    position: sticky;
    top: 0;
    z-index: 10;
}

.table tbody td {
    vertical-align: middle;
    padding: 14px;
    border-color: #eef2f7;
    text-align: center;
}
/* .holidayDate {
    text-align: center;
}

.input-group.date {
    width: 180px;
    margin: auto;
} */

    .holidayDate {
    width: 180px;
    margin: auto;
}

.table-tools {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.search-box {
    width: 300px;
}

.add-btn {
    background: #4a00e0;
    color: white;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    border: none;
    font-size: 22px;
    font-weight: bold;
}

.add-btn:hover {
    background: #111c43;
    color: white;
}

.holiday-badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
}

.holiday-purple{
    background:#ede9fe;
    color:#5b21b6;
    border:1px solid #d8b4fe;
}

.holiday-green{
    background:#ecfdf5;
    color:#059669;
    border:1px solid #a7f3d0;
}

.holiday-blue{
    background:#EEF4FF;
    color:#1D4ED8;
    border:1px solid #BFDBFE;
}

.holiday-magenta{
    background:#FDF2FF;
    color:#A21CAF;
    border:1px solid #e9d5ff;
}

.submit-btn {
    background: linear-gradient(135deg, #111c43, #4a00e0);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(74, 0, 224, 0.25);
    transition: all 0.3s ease;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #4a00e0, #111c43);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(74, 0, 224, 0.35);
}

.submit-btn:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(74, 0, 224, 0.25);
}
    </style>
</head>

<body class="hold-transition sidebar-mini">

<div class="content-wrapper">

    <div class="page-header">
        <h3><i class="fas fa-table mr-2"></i>Holidays List</h3>
        <p>Bloom Solutions Pvt Ltd</p>
    </div>

    <div class="table-card">
        <div class="table-tools">

    <input type="text" 
           id="holidaySearch"
           class="form-control search-box"
           placeholder="Search Holiday...">

    <button type="button" 
            class="add-btn"
            id="addHoliday">
        +
    </button>

</div>
        <div class="table-responsive holiday-table">
    <table class="table table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            <th width="50%">Holiday Name</th>
            <th width="50%">Holiday Date</th>
        </tr>
    </thead>

<tbody id="holidayBody">

<?php $i = 1; ?>

<?php foreach ($holiday as $h): ?>

<?php
$holidayColors = [
    'holiday-purple',
    'holiday-green',
    'holiday-blue',
    'holiday-magenta'
];

$holidayBadge = $holidayColors[($i - 1) % 4];

$i++;
?>

<?php
// Skip Sundays and Second Saturdays
if (
    $h['holiday_name'] == 'Sunday' ||
    $h['holiday_name'] == 'Second Saturday'
) {
    continue;
}
?>

<tr>
    <td>
    <span class="holiday-badge <?= $holidayBadge ?>">
        <?= esc($h['holiday_name']) ?>
    </span>
</td>

    <td>
    <div class="input-group" style="width:180px; margin:auto;">

        <input type="text"
               class="form-control holidayDate"
               name="holiday_date[]"
               value="<?= date('d-m-Y', strtotime($h['holiday_date'])) ?>"
               readonly>

        <div class="input-group-append">
            <span class="input-group-text calendar-btn" style="cursor:pointer;">
                <i class="fas fa-calendar-alt"></i>
            </span>
        </div>

    </div>
</td>
</tr>

<?php endforeach; ?>
</tbody>
</table>
</div>
    </div>
<div class="text-right mt-3" id="submitSection" style="display:none;">
    <button type="button" class="submit-btn" id="submitHoliday">
        <i class="fas fa-save mr-1"></i> Submit
    </button>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

<!-- <script>
$(document).ready(function () {

    $('.holidayDate').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom auto"
    });

    $('.input-group-text').click(function () {
        $(this).closest('.input-group').find('.holidayDate').datepicker('show');
    });

});
</script> -->
<script>

$(document).ready(function(){

    // Search
    $("#holidaySearch").on("keyup", function(){

        var value = $(this).val().toLowerCase();

        $("#holidayBody tr").filter(function(){

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );

        });

    });


    // Add new row
 // Add new row
$("#addHoliday").click(function () {

    // Allow only one new row
    if ($("#holidayBody .newRow").length > 0) {
        alert("Please submit or delete the current row first.");
        return;
    }

    let row = `
    <tr class="newRow">

        <td>
            <input type="text"
                   class="form-control"
                   id="holidayName"
                   placeholder="Enter Holiday Name">
        </td>

        <td>

            <div class="d-flex justify-content-center align-items-center">

                <div class="input-group input-group-sm date" style="width:180px;">

                    <input type="text"
                           class="form-control holidayDate"
                           id="holidayDate"
                           placeholder="dd-mm-yyyy"
                           autocomplete="off">

                    <div class="input-group-append">
                        <span class="input-group-text calendar-btn" style="cursor:pointer;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>

                </div>

                <button type="button"
                        class="btn btn-danger btn-sm ml-2 deleteRow">
                    <i class="fas fa-trash"></i>
                </button>

            </div>

        </td>

    </tr>
    `;

$("#holidayBody").prepend(row);

    $("#submitSection").show();

    $(".holidayDate").last().datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom auto"
    });

    // Scroll to new row
   // Move table to top
$('.holiday-table').animate({
    scrollTop: 0
}, 300);

// Focus on Holiday Name
$("#holidayName").focus();

});


    // calendar icon click
    $(document).on('click','.calendar-btn',function(){

        $(this)
        .closest('.input-group')
        .find('.holidayDate')
        .datepicker('show');

    });
// Delete new row
$(document).on("click", ".deleteRow", function () {

    $(this).closest("tr").remove();

    $("#submitSection").hide();

});

});

$("#submitHoliday").click(function(){

    let holidayName = $("#holidayName").val().trim();
    let holidayDate = $("#holidayDate").val().trim();

    if(holidayName == "" || holidayDate == "")
    {
        alert("Please enter Holiday Name and Holiday Date.");
        return;
    }

    // AJAX code will come here later

    alert("Ready to save.");

});

$('.holidayDate').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,
    orientation: "bottom auto"
});

$(document).on('click', '.calendar-btn', function () {
    $(this)
        .closest('.input-group')
        .find('.holidayDate')
        .datepicker('show');
});
</script>

</body>
</html>