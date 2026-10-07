<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions - Payslip</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/css/bootstrap.min.css">
  
  <style>
    :root {
        --bloom-purple: #4a00e0;
        --bloom-dark: #120038;
        --text-dark: #111827;
        --border-grid: #475569; 
        --deductions-header: #475569;
    }
    
    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #f1f5f9;
        color: var(--text-dark);
        padding: 0;
        margin: 0;
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
        padding: 30px 15px;
    }

    .payslip-main-sheet {
        max-width: 850px;
        margin: 0 auto;
        background: #ffffff;
        border: 2px solid var(--border-grid);
        border-radius: 12px; 
        overflow: hidden; 
        position: relative;
        z-index: 1;
        padding: 35px;
    }

    /* Watermark Layer setup matching image_6e94fb.png and image_6e9918.png lines */
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
    .matrix-table th, .matrix-table td {
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

    /* Clean Earnings Header to match image */
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

    /* Deductions Header Background matching image */
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
        text-align: right;
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
  width: 100%; /* Or whatever width your layout needs */
}

.matrix-table td {
  font-weight: 600;
}

.num-col {
  width: 75%;
  text-align: left;
}

/* For the second row's text column */
.matrix-table tr:not(.net-pay-row) td:last-child {
  width: 75%;
  color: #334155;
}
  </style>
</head>
<body>

<div class="print-trigger-bar">
    <button id="pdfBtn" onclick="exportToCanvasPDF()" class="btn-action">
        <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
    </button>
</div>

<div class="payslip-wrapper">
    <div id="statementCanvasContainer" class="payslip-main-sheet">
      
      <!-- Watermark Graphics Layer Section -->
      <div class="watermark-layer">
        <img id="watermarkImg" src="public/dist/img/bloom.jpg" alt="Watermark Graphic" class="watermark-img">
      </div>
      
      <!-- Corporate Header Section -->
      <div class="office-header-container">
        <img id="headerLogoImg" src="public/dist/img/bloom.jpg" alt="Company Logo" class="office-logo-img">
        <h1 class="office-brand-title"><span class="brand-blue">Bloom</span> <span class="brand-red">Solutions</span></h1>
        <p class="office-header-sub">H No. 6-2-981, Flat No. 501, 5th Floor, Maruthi Plaza, Khairatabad - 500004, Hyderabad, Telangana.</p>
        <b class="office-document-title">Payslip for the month of May - 2026</b>
      </div>
      
      <!-- Profile Matrix Grid -->
      <table class="matrix-table">
        <tr>
            <td class="field-label">Employee Name</td>
            <td class="field-value" style="color: var(--bloom-purple); font-weight: 700;">Aishwarya Tanukonda</td>
            <td class="field-label">Employee ID</td>
            <td class="field-value">BS00286</td>
        </tr>
        <tr>
            <td class="field-label">Designation</td>
            <td class="field-value">Software Developer</td>
            <td class="field-label">Location</td>
            <td class="field-value">Hyderabad</td>
        </tr>
        <tr>
            <td class="field-label">Department</td>
            <td class="field-value">Technical</td>
            <td class="field-label">Date of Joining</td>
            <td class="field-value">2-Jun-2025</td>
        </tr>
        <tr>
            <td class="field-label">PAN</td>
            <td class="field-value">FTOPA2302D</td>
            <td class="field-label">PF Account No.</td>
            <td class="field-value">APHYD00614270000011358</td>
        </tr>
        <tr>
            <td class="field-label">ESIC No.</td>
            <td class="field-value">5222085698</td>
            <td class="field-label">UAN</td>
            <td class="field-value">102204741640</td>
        </tr>
        <tr>
            <td class="field-label">Bank Name</td>
            <td class="field-value">AXIS</td>
            <td class="field-label">Bank Account No.</td>
            <td class="field-value">925010019163519</td>
        </tr>
        <tr>
            <td class="field-label">Monthly CTC</td>
            <td class="field-value">₹25,000/-</td>
            <td class="field-label">Leaves without pay</td>
            <td class="field-value">0</td>
        </tr>
      </table>
      
      <!-- Ledgers Row Layout Split matching image_6e94fb.png & image_6e9918.png -->
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
                <tr><td style="width: 72%;">Basic Salary</td><td class="num-col" style="width: 28%;">12,500.00</td></tr>
                <tr><td style="width: 72%;">House Rent Allowance</td><td class="num-col" style="width: 28%;">5,000.00</td></tr>
                <tr><td style="width: 72%;">Medical Allowance</td><td class="num-col" style="width: 28%;">1,250.00</td></tr>
                <tr><td style="width: 72%;">Conveyance Allowance</td><td class="num-col" style="width: 28%;">2,000.00</td></tr>
                <tr><td style="width: 72%;">Other Allowance</td><td class="num-col" style="width: 28%;">2,625.00</td></tr>
                <tr><td style="width: 72%; line-height: 1.3;">Employer Contribution<small style="color:#475569;">(EPF, ESI, NPS)</small></td><td class="num-col" style="width: 28%;">1,625.00</td></tr>
                <tr class="row-total-accent">
                    <td style="width: 72%;">Total Earnings [CTC]</td>
                    <td class="num-col" style="width: 28%;">25,000.00</td>
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
                <tr><td style="width: 72%;">Income Tax</td><td class="num-col" style="width: 28%;">0.00</td></tr>
                <tr><td style="width: 72%;">Professional Tax</td><td class="num-col" style="width: 28%;">200.00</td></tr>
                <tr><td style="width: 72%;">EPF</td><td class="num-col" style="width: 28%;">3,125.00</td></tr>
                <tr><td style="width: 72%;">ESI</td><td class="num-col" style="width: 28%;">0.00</td></tr>
                <tr><td style="width: 72%;">NPS</td><td class="num-col" style="width: 28%;">0.00</td></tr>
                <tr><td style="width: 72%;">Other Deductions</td><td class="num-col" style="width: 28%;">0.00</td></tr>
                <tr class="row-total-accent">
                    <td style="width: 72%;">Total Deductions</td>
                    <td class="num-col" style="width: 28%;">3,325.00</td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Totals Metric Block Grid -->
      <table class="matrix-table">
  <tr class="net-pay-row">
    <td>Net Pay</td>
    <!-- Fixed: Added semicolon after 75% and changed text-left to text-align: left -->
    <td class="num-col" style="width: 75%; font-weight: 600; text-align: left;"> (₹) 21,675/-</td>
  </tr>
  <tr>
    <td class="field-label">Net Salary in Words</td>
    <td style="width: 75%; font-weight: 600; color: #334155;">Indian Rupees Twenty-one Thousand Six Hundred And Seventy-five Only</td>
  </tr>
</table>
      
      <div class="disclaimer-text">
         <i class="fa-solid fa-circle-check text-success mr-1"></i> This is a computer-generated statement, and does not require a signature and stamp.
      </div>
      
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  const localImageSrc = "public/dist/img/bloom.jpg";

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
        } catch(e) {
            console.log("Local canvas asset routing successfully updated.");
        }
    };
  }

  window.addEventListener('DOMContentLoaded', loadAssetsSecurely);

  function exportToCanvasPDF() {
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
      
      const pdf = new jsPDF('p', 'mm', 'a4');
      pdf.addImage(imgData, 'PNG', 0, 10, imgWidth, imgHeight);
      pdf.save('Aishwarya_Tanukonda_Payslip_May_2026.pdf');
      
      btn.innerHTML = '<i class="fa-solid fa-file-pdf mr-2"></i> Export PDF';
      btn.disabled = false;
    }).catch((err) => {
      console.error(err);
      btn.innerHTML = '<i class="fa-solid fa-file-pdf mr-2"></i> Export PDF';
      btn.disabled = false;
      alert("PDF download failed.");
    });
  }
</script>
</body>
</html>