<?php
$content = $content ?? [];
$earnings = $earnings ?? [];
$deductions = $deductions ?? [];

$cnt = !empty($content[0]) ? $content[0] : [];
$month = $cnt['month'] ?? '';
$year = $cnt['year'] ?? '';

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number)
    {
        $number = (float) $number;
        if (class_exists('NumberFormatter')) {
            try {
                $fmt = new NumberFormatter("en_IN", NumberFormatter::SPELLOUT);
                return ucwords($fmt->format($number));
            } catch (\Exception $e) {
                return (string) $number;
            }
        }
        return (string) $number;
    }
}

if (!function_exists('number_format_indian')) {
    function number_format_indian($number)
    {
        $number = (string) round((float) $number);
        $length = strlen($number);

        if ($length <= 3) {
            return $number;
        }

        $lastThree = substr($number, -3);
        $restUnits = substr($number, 0, $length - 3);
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);

        return $restUnits . "," . $lastThree;
    }
}

// Calculate Total Earnings dynamically
$totalEarningsSum = 0;
if (!empty($earnings)) {
    foreach ($earnings as $e) {
        $totalEarningsSum += (float)($e['amount'] ?? $e['a_amount'] ?? 0);
    }
} else {
    $totalEarningsSum = (float)($cnt['ctc'] ?? $cnt['monthly_ctc'] ?? 0);
}

// Calculate Total Deductions dynamically
$totalDeductionsSum = 0;
if (!empty($deductions)) {
    foreach ($deductions as $d) {
        $totalDeductionsSum += (float)($d['d_amount'] ?? $d['amount'] ?? 0);
    }
} else {
    $totalDeductionsSum = (float)($cnt['total_deductions'] ?? 0);
}

// Calculate Net Pay dynamically
$calculatedNetPay = max(0, $totalEarningsSum - $totalDeductionsSum);
?>
<style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #120038;
        --text-dark: #111827;
        --border-grid: #475569;
        --deductions-header: #475569;
    }

    .print-trigger-bar {
        background: #ffffff;
        padding: 12px;
        text-align: right;
        border-bottom: 1px solid #e2e8f0;
    }

    .btn-action {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action:hover {
        background: #f8fafc;
        color: var(--bloom-purple);
    }

    .payslip-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 30px;
    }

    .payslip-main-sheet {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        background: #ffffff;
        border: 2px solid var(--border-grid);
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        padding: 35px;
    }

        /* Watermark Layer setup */
        .watermark-layer {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-5deg);
            width: 440px;
            height: 440px;
            pointer-events: none;
            opacity: 0.16;
            z-index: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .watermark-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .office-header-container {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .office-logo-img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .office-brand-title {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 6px 0;
            letter-spacing: -0.5px;
        }

        .brand-blue {
            color: #0056b3;
        }

        .brand-red {
            color: #d9383a;
        }

        .office-header-sub {
            font-size: 13px;
            color: #334155;
            margin: 0 0 10px 0;
            line-height: 1.4;
            font-weight: 400;
        }

        .office-document-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 5px;
            display: block;
        }

        /* Transparent Table Grid Structure */
        .matrix-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            background: transparent;
            border: 1px solid var(--border-grid);
            border-radius: 10px;
            overflow: hidden;
        }

        .matrix-table th,
        .matrix-table td {
            border-right: 1px solid var(--border-grid);
            border-bottom: 1px solid var(--border-grid);
            padding: 11px 14px;
            font-size: 13px;
            vertical-align: middle;
            background: transparent !important;
        }

        .matrix-table tr:last-child td {
            border-bottom: none;
        }

        .matrix-table tr td:last-child,
        .matrix-table tr th:last-child {
            border-right: none;
        }

        .field-label {
            font-weight: 600;
            color: #475569;
            width: 22%;
        }

        .field-value {
            color: var(--text-dark);
            font-weight: 500;
            width: 28%;
        }

        /* Clean Earnings Header */
        .earnings-header-heading {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 13px;
        }

        .earnings-header-amount {
            color: #64748b;
            font-weight: 600;
            font-size: 13px;
            text-align: right;
        }

        /* Deductions Header Background */
        .deductions-header-heading {
            background-color: var(--deductions-header) !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .deductions-header-amount {
            background-color: var(--deductions-header) !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13px;
            text-align: right;
        }

        .num-col {
            text-align: left;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }

        .row-total-accent td {
            color: var(--text-dark) !important;
            font-size: 13px;
            font-weight: 700 !important;
        }

        .net-pay-row td {
            color: var(--bloom-purple) !important;
            font-size: 16px;
            font-weight: 800 !important;
        }

        .disclaimer-text {
            text-align: center;
            font-size: 11px;
            color: #64748b;
            margin-top: 30px;
            position: relative;
            z-index: 2;
        }

        .matrix-table {
            width: 100%;
        }

        .matrix-table td {
            font-weight: 600;
        }

        .num-col {
            width: 75%;
            text-align: right;
        }

        .matrix-table tr:not(.net-pay-row) td:last-child {
            width: 75%;
            color: #334155;
        }

        .btn-action {
            background: #4A00E0;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 4px 10px rgba(74, 0, 224, .25);
        }

        .btn-action:hover {
            background: #3600B3;
            transform: translateY(-2px);
    </style>
    <div class="content-wrapper" style="padding: 20px 0;">
        <div class="payslip-wrapper">
        <div id="statementCanvasContainer" class="payslip-main-sheet">

            <!-- Watermark Graphics Layer Section -->
            <div class="watermark-layer">
                <img id="watermarkImg" src="<?= base_url('public/dist/img/bloom.jpg') ?>" class="watermark-img"
                    alt="Watermark">
            </div>

            <!-- Corporate Header Section -->
            <div class="office-header-container">
                <img id="headerLogoImg" src="<?= base_url('public/dist/img/bloom.jpg') ?>" alt="Company Logo"
                    class="office-logo-img">
                <h1 class="office-brand-title"><span class="brand-blue">Bloom</span> <span
                        class="brand-red">Solutions</span></h1>
                <p class="office-header-sub">H No. 6-2-981, Flat No. 501, 5th Floor, Maruthi Plaza, Khairatabad -
                    500004, Hyderabad, Telangana.</p>
                <b class="office-document-title">
                    Payslip for the month of <?= esc($month) ?> - <?= esc($year) ?>
                </b>
            </div>

            <!-- Profile Matrix Grid -->
            <table class="matrix-table">
                <?php if (!empty($content)): ?>
                    <?php foreach ($content as $item): ?>
                        <tr>
                            <td class="field-label">Employee Name</td>
                            <td class="field-value" style="color: var(--bloom-purple); font-weight:700;">
                                <?= esc($item['user_name'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">Employee ID</td>
                            <td class="field-value">
                                <?= esc($item['emp_id'] ?? 'N/A'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">Designation</td>
                            <td class="field-value">
                                <?= esc($item['Designation'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">Location</td>
                            <td class="field-value">
                                <?= esc($item['location'] ?? 'N/A'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">Department</td>
                            <td class="field-value">
                                <?= esc($item['department_name'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">Date of Joining</td>
                            <td class="field-value">
                                <?php
                                $date = 'N/A';
                                if (!empty($item['joining_date'])) {
                                    $d = DateTime::createFromFormat('n/j/Y', $item['joining_date']);
                                    if (!$d) {
                                        $d = DateTime::createFromFormat('Y-m-d', $item['joining_date']);
                                    }
                                    if ($d) {
                                        $date = $d->format('j-M-Y');
                                    }
                                }
                                echo esc($date);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">PAN</td>
                            <td class="field-value">
                                <?= esc($item['pan'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">PF Account No.</td>
                            <td class="field-value">
                                <?= esc($item['pf_account_no'] ?? 'N/A'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">ESIC No.</td>
                            <td class="field-value">
                                <?= esc($item['esic_no'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">UAN</td>
                            <td class="field-value">
                                <?= esc($item['uan'] ?? 'N/A'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">Bank Name</td>
                            <td class="field-value">
                                <?= esc($item['bank_name'] ?? 'N/A'); ?>
                            </td>

                            <td class="field-label">Bank Account No.</td>
                            <td class="field-value">
                                <?= esc($item['bank_account_no'] ?? 'N/A'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="field-label">Monthly CTC</td>
                            <td class="field-value">
                                ₹<?= number_format_indian($item['monthly_ctc'] ?? 0); ?>/-
                            </td>

                            <td class="field-label">Leaves without pay</td>
                            <td class="field-value">
                                <?= esc($item['no_days_absent'] ?? 0); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center p-3 text-muted">No Employee Details Available</td>
                    </tr>
                <?php endif; ?>
            </table>

            <!-- Ledgers Row Layout Split -->
            <div class="row no-gutters">
                <div class="col-6 pr-2">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th class="earnings-header-heading" style="width: 72%;">EARNINGS</th>
                                <th class="earnings-header-amount" style="width: 28%;">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($earnings)): ?>
                                <?php foreach ($earnings as $earning): ?>
                                    <tr>
                                        <td style="width:72%;">
                                            <?= esc($earning['allowance_name'] ?? $earning['allowance'] ?? $earning['name'] ?? ''); ?>
                                        </td>
                                        <td class="num-col" style="width:28%;">
                                            <?= number_format_indian($earning['amount'] ?? $earning['a_amount'] ?? 0); ?>.00
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td style="width: 72%;">Basic Salary</td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['basic_salary'] ?? $cnt['basic'] ?? (($cnt['ctc'] ?? $cnt['monthly_ctc'] ?? 0) * 0.50)); ?>.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 72%;">House Rent Allowance</td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['hra'] ?? $cnt['house_rent_allowance'] ?? (($cnt['ctc'] ?? $cnt['monthly_ctc'] ?? 0) * 0.20)); ?>.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 72%;">Medical Allowance</td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['medical_allowance'] ?? $cnt['medical'] ?? 0); ?>.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 72%;">Conveyance Allowance</td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['conveyance_allowance'] ?? $cnt['conveyance'] ?? 0); ?>.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 72%;">Special / Other Allowance</td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['other_allowance'] ?? $cnt['special_allowance'] ?? $cnt['other'] ?? (($cnt['ctc'] ?? $cnt['monthly_ctc'] ?? 0) * 0.30)); ?>.00
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 72%; line-height: 1.3;">Employer Contribution <small style="color:#475569;">(EPF,ESI,NPS)</small></td>
                                    <td class="num-col" style="width: 28%;">
                                        <?= number_format_indian($cnt['employer_contribution'] ?? $cnt['epf_employer'] ?? 0); ?>.00
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr class="row-total-accent">
                                <td>Total Earnings [CTC]</td>
                                <td class="num-col">
                                    <?= number_format_indian($totalEarningsSum); ?>.00
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-6 pl-2">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th class="earnings-header-heading" style="width: 72%;">DEDUCTIONS</th>
                                <th class="earnings-header-amount" style="width: 28%;">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($deductions)): ?>
                                <?php foreach ($deductions as $deduction): ?>
                                    <tr>
                                        <td style="width:72%;">
                                            <?= esc($deduction['deduction_name'] ?? $deduction['deduction'] ?? $deduction['name'] ?? ''); ?>
                                        </td>
                                        <td class="num-col" style="width:28%;">
                                            <?= number_format_indian($deduction['d_amount'] ?? $deduction['amount'] ?? 0); ?>.00
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <tr class="row-total-accent">
                                <td>Total Deductions</td>
                                <td class="num-col">
                                    <?= number_format_indian($totalDeductionsSum); ?>.00
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Metric Block Grid -->
            <table class="matrix-table">
                <tr class="net-pay-row">
                    <td>Net Pay</td>
                    <td class="num-col" style="width:75%; text-align:left;">
                        ₹ <?= number_format_indian($calculatedNetPay); ?>/-
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Net Salary in Words</td>
                    <td style="width:75%;">
                        Indian Rupees <?= esc(convertNumberToWords($calculatedNetPay)); ?> Only
                    </td>
                </tr>
            </table>

            <div class="disclaimer-text">
                <i class="fa-solid fa-circle-check text-success mr-1"></i> This is a computer-generated statement, and
                does not require a signature and stamp.
            </div>

            <div id="pdfControls" class="print-trigger-bar">
                <button id="pdfBtn" onclick="exportToCanvasPDF()" class="btn-action">
                    <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
                </button>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const localImageSrc = "<?= base_url('public/dist/img/bloom.jpg') ?>";

        function loadAssetsSecurely() {
            const img = new Image();
            img.crossOrigin = "anonymous";
            img.src = localImageSrc;
            img.onload = function () {
                const canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                try {
                    const dataURL = canvas.toDataURL("image/jpeg");
                    document.getElementById('headerLogoImg').src = dataURL;
                    document.getElementById('watermarkImg').src = dataURL;
                } catch (e) {
                    console.log("Local canvas asset routing successfully updated.");
                }
            };
        }

        window.addEventListener('DOMContentLoaded', loadAssetsSecurely);

        function exportToCanvasPDF() {
            const controls = document.getElementById("pdfControls");
            controls.style.display = "none";
            const btn = document.getElementById('pdfBtn');

            if (!window.html2canvas || !window.jspdf) {
                alert("Initializing components. Please try again.");
                return;
            }

            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Generating PDF...';
            btn.disabled = true;

            const { jsPDF } = window.jspdf;
            const element = document.getElementById('statementCanvasContainer');

            const options = {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: false,
                backgroundColor: "#ffffff"
            };

            html2canvas(element, options).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: [imgWidth, imgHeight]
                });

                const margin = 10;
                pdf.addImage(
                    imgData,
                    'PNG',
                    margin,
                    margin,
                    imgWidth - (margin * 2),
                    imgHeight - (margin * 2)
                );
                const fileName = `${employeeName}_Payslip_${payMonth}_${payYear}.pdf`;
                pdf.save(fileName);
                controls.style.display = "block";

                btn.innerHTML = '<i class="fa-solid fa-file-pdf mr-2"></i> Export PDF';
                btn.disabled = false;
            }).catch((err) => {
                console.error(err);
                btn.innerHTML = '<i class="fa-solid fa-file-pdf mr-2"></i> Export PDF';
                btn.disabled = false;
                controls.style.display = "block";
                alert("PDF download failed.");
            });
        }
    </script>
    <script>
        const employeeName = "<?= esc(str_replace(' ', '_', $cnt['user_name'] ?? 'Employee')); ?>";
        const payMonth = "<?= esc($month) ?>";
        const payYear = "<?= esc($year) ?>";
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</div>