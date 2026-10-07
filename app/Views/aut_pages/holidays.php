<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bloom Solutions | Holiday Calendar</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        

    <style>
        :root {
            --primary: #4a00e0;
            --dark: #111c43;
            --bg: #f4f7fe;
            --orange: #ff7a45;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
        }

        /* HEADER */
        .hero-section {
            background: linear-gradient(135deg, #111c43, #4a00e0);
            padding: 30px;
            border-radius: 24px;
            color: #fff;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(74, 0, 224, .2);
        }

        .hero-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .hero-subtitle {
            opacity: .9;
            font-size: 15px;
        }

        /* 5 COLUMNS ROW SYSTEM SETUP */
        @media (min-width: 1200px) {
            .col-xl-2p4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        /* HOLIDAY CARD */
        .holiday-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
            transition: .3s ease;
            height: 100%;
            position: relative;
            animation: fadeUp .6s ease;
            border: none;
            display: flex;
            flex-direction: column;
        }

        .holiday-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
        }

        .holiday-image-container {
            width: 100%;
            height: 120px;
            overflow: hidden;
            background: #e2e8f0;
            position: relative;
        }

        /* Duotone Color Overlay matching brand palette */
        .holiday-image-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(74, 0, 224, 0.15), rgba(17, 28, 67, 0.3));
            mix-blend-mode: multiply;
            pointer-events: none;
        }

        .holiday-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .holiday-card:hover .holiday-image {
            transform: scale(1.08);
        }

        .holiday-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }

        .holiday-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            line-height: 1.4;
            min-height: 40px;
        }

        .holiday-date {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .holiday-badge {
            display: inline-block;
            align-self: flex-start;
            padding: 4px 10px;
            background: #eef2ff;
            color: var(--primary);
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="content-wrapper p-4">
        <section class="content">
            <div class="container-fluid">

                <div class="hero-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="hero-title">
                                🎉 Holiday Calendar (2026)
                            </div>
                            <div class="hero-subtitle">
                                Bloom Solutions Pvt Ltd - Company Holiday Management
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

            

<?php

$imageMap = [
    'Second Saturday' => 'second_saturday.png',
    'Christmas Day' => 'christmas/christmas.png',
    'Boxing Day' => 'boxing_day/boxing_day.png',
    'Bhogi' => 'bhogi/bhogi.png',
    'Sankranti' => 'sankranti/sankranti.png',
    'Republic Day' => 'republic_day/republic_day.png',
    'Maha Shivaratri' => 'maha_shivaratri/maha_shivaratri.png',
    'Holi' => 'holi/holi.png',
    'Ugadi' => 'ugadi/ugadi.png',
    'Sri Rama Navami' => 'sri_rama_navami/sri_rama_navami.png',
    'Good Friday' => 'good_friday/good_friday.png',
    'Deepavali' => 'deepavali/deepavali.png',
    'Ramzan (Eid-ul-Fitr)' => 'ramzan/ramzan.png',
    'Following Day of Ramzan' => 'ramzan_eid_ul/ramzan_eid_ul.png',

    "Babu Jagjivan Ram's Birthday" => 'babu_jagjivan_jayanti/babu_jagjeevan_jayanti.png',

    "Dr. B.R Ambedkar's Birthday" => 'dr._b.r._ambedkar_s_birthday/dr._b.r._ambedkar_s_birthday.png',

    'Bakrid (Eid-ul-Azha)' => 'bakrid/bakrid.png',
    'Moharram' => 'moharram/moharram.png',
    'Bonalu' => 'bonalu/bonalu.png',
    'Independence Day' => 'independence_day/independence_day.png',

    'Eid Miladun Nabi' => 'eid_miladun_nabi/eid_miladun_nabi.png',

    'Sri Krishnaastami' => 'sri_krishnaastami/sri_krishnaastami.png',

    'Vinayaka Chavithi' => 'vinayaka_chavithi/vinayaka_chavithi.png',

    'Mahatma Gandhi Jayanthi' => 'mahatma_gandhi_jayanthi/mahatma_gandhi_jayanthi.png',

    'Saddula Bathukamma' => 'saddula_bathukamma/saddula_bathukamma.png',

    'Vijaya Dasami' => 'vijaya_dasami/vijaya_dasami.png',
    'Following Day of Vijaya Dasami' => 'vijaya_dasami/vijaya_dasami.png',

    "Guru Nanak's Jayanthi" => 'guru_nanak_s_jayanthi/guru_nanak_s_jayanthi.png',
    ];
?>

<?php
$currentMonth = '';
$currentYear = date('Y');
?>

<?php
$currentYear = date('Y');
$currentMonth = '';
?>

<?php foreach ($holiday as $h): ?>

    <?php
    // Get holiday year
    $holidayYear = date('Y', strtotime($h['holiday_date']));

    // IMPORTANT: Skip all previous/future years
    if ($holidayYear != $currentYear) {
        continue;
    }

    // Skip Sundays
    if (
        $h['holiday_type'] == 'WEEK_OFF' &&
        $h['holiday_name'] == 'Sunday'
    ) {
        continue;
    }

    $month = date('F', strtotime($h['holiday_date']));

    if ($month != $currentMonth):
        $currentMonth = $month;
    ?>

<div class="col-12 mt-4 mb-3">
    <h3 style="font-weight:700;color:#111c43;">
        <?= strtoupper($month) ?>
    </h3>
    <hr>
</div>



<?php
$currentMonth = $month;
endif;
?>

<?php
$image = $imageMap[$h['holiday_name']] ?? 'cinematic_festive.jpg';
?>

    <div class="col-xl-2p4 col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="holiday-card">

            <div class="holiday-image-container">
                <img src="<?= base_url('public/dist/img/' . $image) ?>"
                     class="holiday-image"
                     alt="<?= esc($h['holiday_name']) ?>">
            </div>

            <div class="holiday-body">
                <div>
                    <div class="holiday-title">
                        <?= esc($h['holiday_name']) ?>
                    </div>

                    <div class="holiday-date">
                        <i class="fas fa-calendar-alt mr-2 text-muted"></i>
                        <?= date('d-M-Y', strtotime($h['holiday_date'])) ?>
                    </div>
                </div>

                <div class="holiday-badge">
                    <?= esc($h['holiday_type']) ?>
                </div>
            </div>

        </div>
    </div>

<?php endforeach; ?>



                </div>

            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bloom Solutions | Holiday Calendar</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

   <style>
        :root {
            --primary: #4a00e0;
            --dark: #111c43;
            --bg: #f4f7fe;
            --orange: #ff7a45;
        }

       body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    font-size: 13px;
}

        /* HEADER */
        .hero-section {
            background: linear-gradient(135deg, #111c43, #4a00e0);
            padding: 30px;
            border-radius: 24px;
            color: #fff;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(74, 0, 224, .2);
        }

        .hero-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .hero-subtitle {
            opacity: .9;
            font-size: 15px;
        }

        /* 5 COLUMNS ROW SYSTEM SETUP */
        @media (min-width: 1200px) {
            .col-xl-2p4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        /* HOLIDAY CARD */
        .holiday-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
            transition: .3s ease;
            height: 100%;
            position: relative;
            animation: fadeUp .6s ease;
            border: none;
            display: flex;
            flex-direction: column;
        }

        .holiday-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
        }

        .holiday-image-container {
            width: 100%;
            height: 120px;
            overflow: hidden;
            background: #e2e8f0;
            position: relative;
        }

        /* Duotone Color Overlay matching brand palette */
        .holiday-image-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(74, 0, 224, 0.15), rgba(17, 28, 67, 0.3));
            mix-blend-mode: multiply;
            pointer-events: none;
        }

        .holiday-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .holiday-card:hover .holiday-image {
            transform: scale(1.08);
        }

        .holiday-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }

        .holiday-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            line-height: 1.4;
            min-height: 40px;
        }

        .holiday-date {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .holiday-badge {
            display: inline-block;
            align-self: flex-start;
            padding: 4px 10px;
            background: #eef2ff;
            color: var(--primary);
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
    </style>
</head>

<body>
<div class="content-wrapper p-4">
    <section class="content">
        <div class="container-fluid">

            <div class="hero-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="hero-title">🎉 Holiday Calendar (<?= $currentYear ?>)</div>
                        <div class="hero-subtitle">Bloom Solutions Pvt Ltd - Company Holiday Management</div>
                    </div>
                </div>
            </div>

            <div class="row">

<?php
$imageMap = [
    'Second Saturday' => 'second_saturday.png',
    'Christmas Day' => 'christmas.png',
    'Boxing Day' => 'boxing_day.png',
    'Bhogi' => 'bhogi.png',
    'Sankranti' => 'sankranti.png',
    'Republic Day' => 'republic_day.png',
    'Maha Shivaratri' => 'maha_shivaratri.png',
    'Holi' => 'holi.png',
    'Ugadi' => 'ugadi.png',
    'Sri Rama Navami' => 'sri_rama_navami.png',
    'Good Friday' => 'good_friday.png',
    'Deepavali' => 'deepavali.png',
    'Ramzan (Eid-ul-Fitr)' => 'ramzan.png',
    'Following Day of Ramzan' => 'ramzan.png',
    'Babu Jagjivan Ram Birthday' => 'babu_jagjeevan_jayanti.png',
    'Dr. BR Ambedkar Birthday' => 'dr._b.r._ambedkar_s_birthday.png',
    'Bakrid (Eid-ul-Azha)' => 'bakrid.png',
    'Moharram' => 'moharram.png',
    'Bonalu' => 'bonalu.png',
    'Independence Day' => 'independence_day.png',
    'Eid Miladun Nabi' => 'eid_miladun_nabi.png',
    'Sri Krishnaastami' => 'sri_krishnaastami.png',
    'Vinayaka Chavithi' => 'vinayaka_chavithi.png',
    'Mahatma Gandhi Jayanthi' => 'mahatma_gandhi_jayanthi.png',
    'Saddula Bathukamma' => 'saddula_bathukamma.png',
    'Vijaya Dasami' => 'vijaya_dasami.png',
    'Following Day of Vijaya Dasami' => 'vijaya_dasami.png',
    'Guru Nanak Jayanthi' => 'guru_nanak_s_jayanthi.png',
];
$currentMonth = '';
?>

<?php if (!empty($holiday)): ?>
    <?php
$currentYear = date('Y');
$currentMonth = '';
?>

<?php foreach ($holiday as $h): ?>

    <?php
    // Get holiday year
    $holidayYear = date('Y', strtotime($h['holiday_date']));

    // IMPORTANT: Skip all previous/future years
    if ($holidayYear != $currentYear) {
        continue;
    }

    // Skip Sundays
    if (
        $h['holiday_type'] == 'WEEK_OFF' &&
        $h['holiday_name'] == 'Sunday'
    ) {
        continue;
    }

    $month = date('F', strtotime($h['holiday_date']));

    if ($month != $currentMonth):
        $currentMonth = $month;
    ?>
            <div class="col-12 mt-4 mb-3">
                <h3 style="font-weight:700;color:#111c43;"><?= strtoupper($month) ?></h3>
                <hr>
            </div>
        <?php endif; ?>

        <?php $image = $imageMap[$h['holiday_name']] ?? 'cinematic_festive.jpg'; ?>

        <div class="col-xl-2p4 col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="holiday-card">
                <div class="holiday-image-container">
                    <img src="<?= base_url('public/dist/img/' . $image) ?>"
                         class="holiday-image"
                         alt="<?= esc($h['holiday_name']) ?>">
                </div>
                <div class="holiday-body">
                    <div>
                        <div class="holiday-title"><?= esc($h['holiday_name']) ?></div>
                        <div class="holiday-date">
                            <i class="fas fa-calendar-alt mr-2 text-muted"></i>
                            <?= date('d-M-Y', strtotime($h['holiday_date'])) ?>
                        </div>
                    </div>
                    <div class="holiday-badge"><?= esc($h['holiday_type']) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No holidays found.</p>
<?php endif; ?>

            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</body>
</html>
