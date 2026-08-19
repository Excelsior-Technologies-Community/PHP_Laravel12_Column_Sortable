<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Task Manager')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f5f7fb;
            color: #1f2937;
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        .navbar {
            background: #111827 !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .2px;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding-left: 14px !important;
            padding-right: 14px !important;
            border-radius: 8px;
            margin: 0 2px;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }

        .page-container {
            padding-top: 30px;
            padding-bottom: 50px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .page-subtitle {
            color: #6b7280;
            margin-bottom: 0;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 20px;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        .stat-card {
            transition: all .2s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            color: #6b7280;
            font-size: 13px;
            font-weight: 500;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 700;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 15px 16px;
            vertical-align: middle;
            border-color: #eef2f7;
        }

        .table tbody tr {
            transition: background .15s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .task-title {
            font-weight: 600;
            color: #111827;
        }

        .task-description {
            max-width: 320px;
            font-size: 12px;
            color: #94a3b8;
        }

        .badge {
            padding: 7px 10px;
            border-radius: 7px;
            font-weight: 600;
            font-size: 11px;
        }

        .form-control,
        .form-select {
            border-radius: 9px;
            border-color: #dbe1ea;
            min-height: 42px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .10);
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-sm {
            border-radius: 7px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .active-filter {
            border-radius: 8px;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1e40af;
        }

        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-state-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 30px;
            color: #94a3b8;
        }

        .detail-label {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        .description-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px;
            color: #475569;
            line-height: 1.7;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            border-radius: 7px;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .pagination .active .page-link {
            color: #fff;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            white-space: nowrap;
        }

        .section-space {
            margin-bottom: 24px;
        }

        @media (max-width: 768px) {

            .page-title {
                font-size: 23px;
            }

            .page-header {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 15px;
            }

            .action-header {
                width: 100%;
                flex-wrap: wrap;
            }

            .stat-value {
                font-size: 23px;
            }

        }
    </style>

    @stack('styles')

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container">

            <a
                class="navbar-brand"
                href="{{ route('tasks.index') }}">

                <i class="bi bi-check2-square"></i>
                Task Manager

            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div
                class="collapse navbar-collapse"
                id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('tasks.index') }}">

                            <i class="bi bi-grid me-1"></i>
                            Tasks

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('tasks.create') }}">

                            <i class="bi bi-plus-circle me-1"></i>
                            Create Task

                        </a>

                    </li>

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('tasks.trash') }}">

                            <i class="bi bi-trash3 me-1"></i>
                            Trash

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>


    <main class="container page-container">

        @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show shadow-sm"
            role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        @endif


        @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show shadow-sm"
            role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        @endif


        @yield('content')

    </main>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>

</html>