<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - RentGo Admin</title>

    {{-- Strict SEO & Security: Never index any admin panel views --}}
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --rubick-blue: #1b3bbb;
            --rubick-blue-hover: #1632a3;
            --rubick-blue-light: #eff4fe;
            --rubick-dark: #0f172a;
            --rubick-slate: #334155;
            --rubick-muted: #64748b;
            --rubick-canvas: #f1f5f9;
            --rubick-card-bg: #ffffff;
            --rubick-border: #e2e8f0;
            --sidebar-width: 250px;
        }

        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--rubick-blue);
            color: var(--rubick-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ----------------------------------------------------
           RUBICK SIDEBAR
        ---------------------------------------------------- */
        .rubick-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: var(--rubick-blue);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 0.85rem;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .rubick-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.5rem 0.75rem 1.75rem 0.75rem;
            text-decoration: none;
        }

        .rubick-brand-logo {
            width: 42px;
            height: 42px;
            background: #ffffff;
            color: var(--rubick-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        .rubick-brand-title {
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .rubick-brand-subtitle {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.72rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.5);
            padding: 0.75rem 1rem 0.35rem 1rem;
            margin-top: 0.5rem;
        }

        .rubick-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex-grow: 1;
        }

        .rubick-nav-item {
            width: 100%;
        }

        .rubick-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.1rem;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 9999px;
            transition: all 0.2s ease;
            position: relative;
        }

        .rubick-nav-link i.nav-icon {
            width: 22px;
            font-size: 1.05rem;
            margin-right: 0.75rem;
            opacity: 0.85;
            text-align: center;
        }

        .rubick-nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.12);
        }

        /* Active State: The iconic Rubick white pill */
        .rubick-nav-link.active {
            background-color: #ffffff;
            color: var(--rubick-blue);
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .rubick-nav-link.active i.nav-icon {
            color: var(--rubick-blue);
            opacity: 1;
        }

        .rubick-nav-link .badge-nav {
            margin-left: auto;
            background: #ef4444;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
        }

        .rubick-nav-link.active .badge-nav {
            background: var(--rubick-blue);
            color: #ffffff;
        }

        .rubick-sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rubick-user-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
            text-decoration: none;
        }

        .rubick-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--rubick-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .rubick-user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .rubick-user-role {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-sidebar-logout {
            color: rgba(255, 255, 255, 0.7);
            background: transparent;
            border: none;
            padding: 0.4rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-sidebar-logout:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }

        /* ----------------------------------------------------
           MAIN INSET CANVAS (RUBICK TRADEMARK)
        ---------------------------------------------------- */
        .rubick-main-canvas {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--rubick-canvas);
            border-top-left-radius: 36px;
            position: relative;
            padding: 1.75rem 2rem 3rem 2rem;
            transition: margin-left 0.3s ease;
        }

        /* Topbar Header */
        .rubick-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--rubick-border);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .rubick-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--rubick-muted);
            margin: 0;
        }

        .rubick-breadcrumb a {
            color: var(--rubick-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .rubick-breadcrumb a:hover {
            color: var(--rubick-dark);
        }

        .rubick-breadcrumb .separator {
            color: #94a3b8;
            font-size: 0.75rem;
        }

        .rubick-breadcrumb .current {
            color: var(--rubick-dark);
            font-weight: 600;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .rubick-search-pill {
            position: relative;
            width: 260px;
        }

        .rubick-search-pill input {
            width: 100%;
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 9999px;
            padding: 0.5rem 1rem 0.5rem 2.25rem;
            font-size: 0.825rem;
            color: var(--rubick-dark);
            outline: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .rubick-search-pill input:focus {
            border-color: var(--rubick-blue);
            box-shadow: 0 0 0 3px rgba(27, 59, 187, 0.12);
        }

        .rubick-search-pill i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .rubick-clock-pill {
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 9999px;
            padding: 0.5rem 0.95rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--rubick-slate);
            display: flex;
            align-items: center;
            gap: 0.45rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .rubick-clock-pill i {
            color: var(--rubick-blue);
        }

        .rubick-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            color: var(--rubick-slate);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .rubick-icon-btn:hover {
            background: #f8fafc;
            color: var(--rubick-blue);
            border-color: #cbd5e1;
        }

        .rubick-icon-btn .dot-indicator {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        /* Topbar User Profile */
        .rubick-profile-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            padding: 0.35rem 0.85rem 0.35rem 0.35rem;
            border-radius: 9999px;
            color: var(--rubick-dark);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: all 0.15s ease;
        }

        .rubick-profile-dropdown .dropdown-toggle:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .rubick-profile-dropdown .dropdown-toggle::after {
            margin-left: 0.25rem;
            color: #94a3b8;
        }

        .rubick-profile-dropdown .dropdown-menu {
            border-radius: 14px;
            border: 1px solid var(--rubick-border);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
        }

        .rubick-profile-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.55rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--rubick-slate);
            transition: all 0.15s ease;
        }

        .rubick-profile-dropdown .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--rubick-blue);
        }

        /* ----------------------------------------------------
           GLOBAL ANTISLOP ENTERPRISE COMPONENTS
        ---------------------------------------------------- */
        .card-custom,
        .card {
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 1.5rem;
        }

        .card-custom:hover,
        .card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
        }

        .card-header-custom,
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--rubick-border);
            padding: 1.15rem 1.35rem;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title-custom,
        .card-header h5,
        .card-header h6 {
            color: var(--rubick-dark);
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .card-body {
            padding: 1.35rem;
        }

        /* Page Header Card */
        .page-header-card {
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        }

        .page-title {
            color: var(--rubick-dark);
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .page-subtitle {
            color: var(--rubick-muted);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.2rem;
        }

        /* Buttons */
        .btn-primary,
        .btn-add-car,
        .btn-add-booking,
        .btn-primary-custom,
        .btn-gradient {
            background-color: var(--rubick-blue) !important;
            border: 1px solid var(--rubick-blue) !important;
            color: #ffffff !important;
            border-radius: 10px;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(27, 59, 187, 0.1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-primary:hover,
        .btn-add-car:hover,
        .btn-add-booking:hover,
        .btn-primary-custom:hover,
        .btn-gradient:hover {
            background-color: var(--rubick-blue-hover) !important;
            border-color: var(--rubick-blue-hover) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .btn-outline-custom,
        .btn-rubick-outline {
            background-color: #ffffff;
            border: 1px solid var(--rubick-border);
            color: var(--rubick-slate);
            border-radius: 10px;
            padding: 0.5rem 1.15rem;
            font-size: 0.825rem;
            font-weight: 600;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-outline-custom:hover,
        .btn-rubick-outline:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: var(--rubick-blue);
        }

        /* Tables */
        .table-responsive {
            border-radius: 14px;
            border: 1px solid var(--rubick-border);
            background: #ffffff;
            overflow-x: auto;
        }

        .table,
        .table-custom {
            margin-bottom: 0;
            width: 100%;
            vertical-align: middle;
        }

        .table th,
        .table-custom th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.85rem 1.15rem;
            border-bottom: 1px solid var(--rubick-border);
            border-top: none;
            white-space: nowrap;
        }

        .table td,
        .table-custom td {
            padding: 0.95rem 1.15rem;
            color: #1e293b;
            font-size: 0.85rem;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
            vertical-align: middle;
        }

        .table tbody tr:hover td,
        .table-custom tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Pastel Status Badges */
        .badge {
            font-weight: 600;
            font-size: 0.725rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }

        .badge-available,
        .badge-success,
        .badge.bg-success,
        .status-available {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
            border: 1px solid #a7f3d0 !important;
        }

        .badge-rented,
        .badge-warning,
        .badge.bg-warning,
        .status-rented {
            background-color: #fffbeb !important;
            color: #b45309 !important;
            border: 1px solid #fde68a !important;
        }

        .badge-maintenance,
        .badge-danger,
        .badge.bg-danger,
        .status-maintenance {
            background-color: #fff1f2 !important;
            color: #be123c !important;
            border: 1px solid #fecdd3 !important;
        }

        .badge-info,
        .badge.bg-info,
        .badge.bg-primary {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
            border: 1px solid #bfdbfe !important;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border: 1px solid var(--rubick-border);
            border-radius: 10px;
            padding: 0.55rem 0.85rem;
            font-size: 0.85rem;
            color: var(--rubick-dark);
            transition: all 0.15s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--rubick-blue);
            box-shadow: 0 0 0 3px rgba(27, 59, 187, 0.1);
        }

        /* Alerts */
        .alert-custom,
        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
            font-size: 0.875rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success,
        .alert-success-custom {
            background-color: #ecfdf5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-danger,
        .alert-danger-custom {
            background-color: #fff1f2;
            border-color: #fecdd3;
            color: #9f1239;
        }

        .alert-warning {
            background-color: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }

        /* Mini Stat Card (for subpages) */
        .stat-mini-card {
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.2s ease;
        }

        .stat-mini-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .stat-mini-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            background: var(--rubick-blue-light);
            color: var(--rubick-blue);
        }

        .stat-mini-card.stat-success .stat-icon {
            background: #ecfdf5;
            color: #059669;
        }

        .stat-mini-card.stat-warning .stat-icon {
            background: #fffbeb;
            color: #d97706;
        }

        .stat-mini-card.stat-info .stat-icon {
            background: #f0f9ff;
            color: #0284c7;
        }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--rubick-dark);
            margin: 0;
            line-height: 1.2;
        }

        .stat-content p {
            color: var(--rubick-muted);
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* Pagination */
        .pagination {
            gap: 0.35rem;
            margin-top: 1.5rem;
            justify-content: center;
        }

        .page-item .page-link {
            border-radius: 8px;
            border: 1px solid var(--rubick-border);
            color: var(--rubick-slate);
            font-size: 0.825rem;
            font-weight: 600;
            padding: 0.45rem 0.85rem;
            transition: all 0.15s ease;
        }

        .page-item.active .page-link {
            background-color: var(--rubick-blue);
            border-color: var(--rubick-blue);
            color: #ffffff;
        }

        .page-item .page-link:hover {
            background-color: #f1f5f9;
            color: var(--rubick-blue);
        }

        /* Mobile Sidebar Toggle Button */
        .mobile-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            background: #ffffff;
            border: 1px solid var(--rubick-border);
            border-radius: 10px;
            color: var(--rubick-slate);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .rubick-sidebar {
                transform: translateX(-100%);
            }

            .rubick-sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 50px rgba(0, 0, 0, 0.4);
            }

            .rubick-main-canvas {
                margin-left: 0;
                border-top-left-radius: 0;
                padding: 1rem;
            }

            .mobile-toggle-btn {
                display: flex;
            }

            .rubick-search-pill {
                width: 100%;
                order: 3;
            }

            .rubick-topbar {
                align-items: flex-start;
            }
        }
    @yield('styles')

    <!-- Universal Antislop Enterprise Overrides -->
    <style>
        .page-header-card {
            background: #ffffff !important;
            border: 1px solid var(--rubick-border) !important;
            border-radius: 16px !important;
            padding: 1.35rem 1.6rem !important;
            margin-bottom: 1.5rem !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
            color: var(--rubick-dark) !important;
        }
        .page-header-card::before, .page-header-card::after {
            display: none !important;
        }
        .page-title {
            color: var(--rubick-dark) !important;
            text-shadow: none !important;
            font-size: 1.35rem !important;
            font-weight: 800 !important;
        }
        .page-subtitle {
            color: var(--rubick-muted) !important;
            opacity: 1 !important;
            font-size: 0.85rem !important;
        }
        .btn-add-car, .btn-add-booking, .btn-primary-custom {
            background-color: var(--rubick-blue) !important;
            border: 1px solid var(--rubick-blue) !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(27, 59, 187, 0.1) !important;
            border-radius: 10px !important;
            padding: 0.55rem 1.25rem !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            transform: none !important;
        }
        .btn-add-car:hover, .btn-add-booking:hover, .btn-primary-custom:hover {
            background-color: var(--rubick-blue-hover) !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }
        .stat-mini-card {
            background: #ffffff !important;
            border: 1px solid var(--rubick-border) !important;
            border-radius: 14px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
            transform: none !important;
            padding: 1.25rem !important;
        }
        .stat-mini-card:hover {
            border-color: #cbd5e1 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
            transform: translateY(-1px) !important;
        }
        .stat-mini-card .stat-icon {
            border-radius: 12px !important;
            width: 48px !important;
            height: 48px !important;
            font-size: 1.25rem !important;
        }
        .stat-primary .stat-icon { background: var(--rubick-blue-light) !important; color: var(--rubick-blue) !important; }
        .stat-success .stat-icon { background: #ecfdf5 !important; color: #059669 !important; }
        .stat-warning .stat-icon { background: #fffbeb !important; color: #d97706 !important; }
        .stat-info .stat-icon { background: #f0f9ff !important; color: #0284c7 !important; }
        .stat-content h3 { color: var(--rubick-dark) !important; font-size: 1.5rem !important; font-weight: 800 !important; }
        .stat-content p { color: var(--rubick-muted) !important; font-size: 0.78rem !important; }
        .card-custom {
            background: #ffffff !important;
            border: 1px solid var(--rubick-border) !important;
            border-radius: 16px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
        }
        .card-header-custom {
            background-color: #ffffff !important;
            border-bottom: 1px solid var(--rubick-border) !important;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }
        .card-title-custom {
            color: var(--rubick-dark) !important;
            font-weight: 700 !important;
        }
        .table-custom thead th,
        .table-custom th {
            background: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
            border-bottom: 1px solid var(--rubick-border) !important;
            border-top: none !important;
        }
        .table-custom thead th:first-child,
        .table-custom thead th:last-child {
            border-radius: 0 !important;
        }
        .table-custom td {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .table-custom tbody tr:hover td {
            background-color: #f8fafc !important;
        }
        .alert-custom {
            border: 1px solid var(--rubick-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- ----------------------------------------------------
         RUBICK SIDEBAR NAVIGATION
    ----------------------------------------------------- -->
    <aside class="rubick-sidebar" id="sidebar">
        <!-- Brand Header -->
        <a href="{{ route('admin.dashboard') }}" class="rubick-brand">
            <div class="rubick-brand-logo">
                <i class="fas fa-car-side"></i>
            </div>
            <div>
                <div class="rubick-brand-title">RentGo</div>
                <div class="rubick-brand-subtitle">Cirebon Fleet</div>
            </div>
        </a>

        <!-- Navigation Menu -->
        <ul class="rubick-nav">
            <li class="sidebar-section-label">Menu Utama</li>

            <!-- Dashboard -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Manajemen Mobil -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}"
                   href="{{ route('admin.cars.index') }}">
                    <i class="fas fa-car nav-icon"></i>
                    <span>Kelola Mobil</span>
                </a>
            </li>

            <!-- Manajemen Booking -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                   href="{{ route('admin.bookings.index') }}">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <span>Data Booking</span>
                </a>
            </li>

            <!-- Pesan Masuk / Kontak -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
                   href="{{ route('admin.contacts.index') }}">
                    <i class="fas fa-envelope nav-icon"></i>
                    <span>Pesan Masuk</span>
                    @php
                        $unreadCount = 0;
                        try {
                            if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
                                $unreadCount = \App\Models\Contact::where('status', 'unread')->count();
                            }
                        } catch (\Exception $e) {
                            $unreadCount = 0;
                        }
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge-nav">{{ $unreadCount }}</span>
                    @endif
                </a>
            <!-- Artikel & Yoast SEO -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                   href="{{ route('admin.posts.index') }}">
                    <i class="fas fa-newspaper nav-icon"></i>
                    <span>Blog & SEO</span>
                </a>
            </li>

            <!-- Laporan & Analytics -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                   href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <span>Laporan & Ekspor</span>
                </a>
            </li>

            <li class="sidebar-section-label">Portal Publik</li>

            <!-- Lihat Website -->
            <li class="rubick-nav-item">
                <a class="rubick-nav-link" href="{{ route('landing.home') }}" target="_blank">
                    <i class="fas fa-arrow-up-right-from-square nav-icon"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <!-- Sidebar Footer / Auth Profile -->
        <div class="rubick-sidebar-footer">
            @auth
            <div class="rubick-user-card">
                <div class="rubick-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="rubick-user-name">{{ Auth::user()->name }}</div>
                    <div class="rubick-user-role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn-sidebar-logout" title="Logout">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-light btn-sm w-100 fw-bold text-primary">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
            @endauth
        </div>
    </aside>

    <!-- ----------------------------------------------------
         MAIN INSET WORKSPACE CANVAS
    ----------------------------------------------------- -->
    <main class="rubick-main-canvas">
        <!-- Topbar Header -->
        <header class="rubick-topbar">
            <!-- Left: Toggle & Breadcrumb -->
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle-btn" id="sidebarToggle" type="button" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="rubick-breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">RentGo</a>
                    <span class="separator"><i class="fas fa-chevron-right"></i></span>
                    <span class="current">@yield('title', 'Dashboard')</span>
                </div>
            </div>

            <!-- Right: Search, Clock, Notification, Profile -->
            <div class="topbar-actions">
                <!-- Search Pill -->
                <div class="rubick-search-pill d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalAdminSearch" placeholder="Cari mobil, booking, pelanggan...">
                </div>

                <!-- Live Digital Clock (WIB) -->
                <div class="rubick-clock-pill d-none d-sm-flex">
                    <i class="far fa-clock"></i>
                    <span id="liveTimeBadge">--:--:-- WIB</span>
                </div>

                <!-- Notifications Icon -->
                <div class="dropdown">
                    <a href="#" class="rubick-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                        <i class="far fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="dot-indicator"></span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-2" style="min-width: 280px;">
                        <li class="dropdown-header fw-bold text-dark px-2">Notifikasi Sistem</li>
                        @if($unreadCount > 0)
                            <li>
                                <a class="dropdown-item py-2 rounded-2" href="{{ route('admin.contacts.index') }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="badge bg-danger rounded-circle p-2"><i class="fas fa-envelope"></i></div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $unreadCount }} Pesan Masuk Baru</div>
                                            <small class="text-muted">Perlu respons cepat via WhatsApp</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @else
                            <li><span class="dropdown-item text-muted small py-2">Semua notifikasi telah ditinjau</span></li>
                        @endif
                    </ul>
                </div>

                <!-- Administrator Profile Dropdown -->
                @auth
                <div class="dropdown rubick-profile-dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rubick-avatar" style="width: 28px; height: 28px; font-size: 0.8rem; background: var(--rubick-blue); color: #fff; border: none;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header text-uppercase small text-muted">Akun Petugas</li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="far fa-user me-2 text-muted"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.cars.index') }}">
                                <i class="fas fa-car-side me-2 text-muted"></i> Armada Mobil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </header>

        <!-- Session Flash Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Dynamic Content -->
        <div class="rubick-content-body">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        }

        // Live Digital Clock (WIB)
        function updateLiveClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            const badge = document.getElementById('liveTimeBadge');
            if (badge) {
                badge.textContent = timeStr + ' WIB';
            }
        }
        updateLiveClock();
        setInterval(updateLiveClock, 1000);

        // Auto-dismiss alert after 6 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                if (bsAlert) bsAlert.close();
            });
        }, 6000);
    </script>

    @yield('scripts')
</body>
</html>
