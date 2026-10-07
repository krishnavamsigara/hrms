<!DOCTYPE html>
<html lang="en" style="height: 100%; overflow: hidden;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloomHR | My Team</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        :root {
            --bloom-purple: #4a00e0;
            --bloom-dark: #120038;
            --bloom-bg: #f4f7fe;
            --glass: rgba(255, 255, 255, 0.8);
            --mtn-deep: #1e293b;
        }

        body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--bloom-bg);
    font-size: 13px;
    min-height: 100vh;
    overflow-x: hidden;
}
.wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

        .main-header {
            border-bottom: 1px solid #e2e8f0 !important;
            background: var(--glass) !important;
            backdrop-filter: blur(10px);
        }

        .main-sidebar {
            background: var(--mtn-deep) !important;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.03) !important;
        }

        .custom-brand {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            margin-right: 10px;
        }

        .brand-text {
            font-size: 18px;
            font-weight: 700;
        }

        .brand-blue {
            color: #4a8cff;
        }

        .brand-orange {
            color: #ff7a45;
        }

        .content-wrapper {
    background: var(--bloom-bg) !important;
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 15px !important;
}

        .container-fluid {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 15px;
        }

        .p-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        .scroll-area::-webkit-scrollbar {
            width: 5px;
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .section-label {
            color: var(--bloom-purple);
            font-weight: 800;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: block;
            border-left: 4px solid var(--bloom-purple);
            padding-left: 12px;
        }

        .main-footer {
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            color: #64748b;
            font-size: 12px;
            padding: 1rem 1.5rem !important;
        }

        /* Custom Tabs Styling */
        .custom-tabs-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 15px;
        }

        .custom-tabs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .custom-tabs {
            border-bottom: none;
            flex-wrap: nowrap;
            margin-bottom: -1px;
        }

        .custom-tabs .nav-item {
            margin-bottom: 0;
        }

        .custom-tabs .nav-link {
            color: #64748b;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            padding: 12px 24px;
            white-space: nowrap;
            transition: all 0.3s ease;
            background: transparent;
            font-size: 14px;
        }

        .custom-tabs .nav-link:hover {
            color: #1e293b;
            border-color: transparent;
        }

        .custom-tabs .nav-link.active {
            color: #1e293b;
            font-weight: 700;
            border-color: transparent transparent #0052cc transparent;
            background: transparent;
        }

        .tab-content {
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .tab-pane {
            height: 100%;
            flex: 1;
            width: 100%;
        }

        .tab-pane.active {
            display: flex !important;
            flex-direction: column;
        }
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 250px;
    color: #64748b;
}

        .empty-state i {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }
    </style>
</head>

        <div class="content-wrapper">
    <div class="container-fluid position-relative">

        <!-- Header Card -->
        <div class="p-card flex-row justify-content-between align-items-center"
            style="flex: 0 0 auto; padding: 15px 20px;">

            <div>
                <h5 class="font-weight-bold mb-0">My Team</h5>
                <p class="text-muted mb-0 small" id="teamSubtitle">
                    Manage your team members and requests
                </p>
            </div>
        </div>

        <!-- Employee Empty View -->
        <div id="employeeView" class="p-card flex-fill mt-3">

            <div class="empty-state">
                <i class="fas fa-users-slash"></i>

                <h4 class="font-weight-bold text-dark">
                    No Team Members
                </h4>

                <p>
                    There is no employee currently assigned under you.
                </p>
            </div>


               

            </div>
        </div>

       
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    
</body>

</html>
