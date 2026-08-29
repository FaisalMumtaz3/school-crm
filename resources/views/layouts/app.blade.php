<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>School CRM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* =========================
        GLOBAL
        ========================= */
        * {
            box-sizing: border-box;
        }

        html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: #f8fafc;
            color: #111827;
        }


        /* =========================
        APP WRAPPER
        ========================= */
        .school-app {
            width: 100%;
            min-height: 100vh;
        }


        /* =========================
        SIDEBAR
        ========================= */
        .school-sidebar {
            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            width: 254px;
            height: 100vh;

            background: #030817;
            color: #ffffff;

            display: flex;
            flex-direction: column;

            z-index: 1000;

            overflow: hidden;
        }


        /* =========================
        SIDEBAR BRAND
        ========================= */
        .sidebar-brand {
            height: 64px;
            min-height: 64px;

            display: flex;
            align-items: center;

            padding: 0 16px;

            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;

            border-radius: 10px;

            background: #5146e5;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 10px;

            font-size: 18px;
        }

        .brand-text {
            line-height: 1.15;
        }

        .brand-title {
            font-size: 14px;
            font-weight: 700;
        }

        .brand-subtitle {
            margin-top: 2px;

            font-size: 10px;
            color: #94a3b8;
        }


        /* =========================
        SIDEBAR NAV
        ========================= */
        .sidebar-nav {
            flex: 1;

            padding: 18px 9px 10px;

            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #64748b;
            border-radius: 10px;
        }

        .nav-section {
            margin-bottom: 18px;
        }

        .nav-section-title {
            padding: 0 12px;
            margin-bottom: 8px;

            font-size: 9px;
            font-weight: 600;

            letter-spacing: 2px;
            text-transform: uppercase;

            color: #7890bb;
        }

        .nav-item {
            width: 100%;
            height: 41px;

            display: flex;
            align-items: center;

            padding: 0 12px;
            margin-bottom: 4px;

            border-radius: 11px;

            color: #dbe3f1;
            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            transition: .2s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .06);
            color: #ffffff;
        }

        .nav-item.active {
            background: #5146e5;
            color: #ffffff;

            box-shadow: 0 8px 18px rgba(79, 70, 229, .25);
        }

        .nav-icon {
            width: 20px;
            min-width: 20px;

            margin-right: 9px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;
        }


        /* =========================
        SIDEBAR USER
        ========================= */
        .sidebar-user {
            min-height: 74px;

            margin: 0 9px 9px;
            padding: 10px;

            border-radius: 10px;

            background: #101629;

            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            min-width: 36px;

            border-radius: 50%;

            background: #5146e5;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 13px;
            font-weight: 700;

            margin-right: 10px;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            color: #ffffff;

            font-size: 12px;
            font-weight: 700;
        }

        .user-role {
            margin-top: 2px;

            color: #8491ab;

            font-size: 10px;
        }

        .logout-icon {
            color: #9aa7bf;
            font-size: 16px;
        }


        /* =========================
        MAIN AREA
        ========================= */
        .school-main {
            margin-left: 254px;

            width: calc(100% - 254px);

            min-height: 100vh;

            display: flex;
            flex-direction: column;
        }


        /* =========================
        HEADER
        ========================= */
        .school-header {
            position: sticky;
            top: 0;

            width: 100%;
            height: 64px;
            min-height: 64px;

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            padding: 0 24px;

            z-index: 900;
        }

        .header-right {
            display: flex;
            align-items: center;

            gap: 18px;
        }

        .notification {
            position: relative;

            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #64748b;
        }

        .notification-dot {
            position: absolute;

            top: 7px;
            right: 7px;

            width: 5px;
            height: 5px;

            background: #5146e5;

            border-radius: 50%;
        }

        .header-user {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .header-user-info {
            text-align: right;
            line-height: 1.2;
        }

        .header-user-name {
            font-size: 13px;
            font-weight: 700;

            color: #1e293b;
        }

        .header-user-role {
            margin-top: 3px;

            font-size: 10px;
            color: #64748b;
        }

        .header-avatar {
            width: 36px;
            height: 36px;

            border-radius: 50%;

            background: #e0e7ff;
            color: #4f46e5;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 13px;
            font-weight: 700;
        }


        /* =========================
        CONTENT
        ========================= */
        .school-content {
            flex: 1 1 auto;

            width: 100%;

            min-height: 0;

            padding: 28px 24px 28px;

            overflow-x: hidden;
            overflow-y: auto;
        }

        .school-content > * {
            width: 100%;
        }


        /* =========================
        PAGE
        ========================= */
        .student-form-page {
            width: 100%;
            min-height: 100%;
        }

        .student-form-card {
            min-height: 36rem;
        }


        /* =========================
        FOOTER
        ========================= */
        .school-footer {
            width: 100%;

            height: 42px;
            min-height: 42px;

            border-top: 1px solid #e5e7eb;

            background: #ffffff;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            padding: 0 24px;

            color: #64748b;

            font-size: 10px;
        }


        /* =========================
        TABLET
        ========================= */
        @media (max-width: 900px) {

            .school-sidebar {
                width: 220px;
            }

            .school-main {
                margin-left: 220px;

                width: calc(100% - 220px);
            }

            .school-content {
                padding: 22px 18px 28px;
            }
        }


        /* =========================
        MOBILE
        ========================= */
        @media (max-width: 700px) {

            .school-sidebar {
                width: 70px;
            }

            .sidebar-brand {
                justify-content: center;
                padding: 0;
            }

            .brand-text,
            .nav-section-title,
            .nav-item span:not(.nav-icon),
            .sidebar-user .user-info,
            .logout-icon {
                display: none;
            }

            .brand-icon {
                margin: 0;
            }

            .nav-item {
                justify-content: center;
                padding: 0;
            }

            .nav-icon {
                margin: 0;
            }

            .sidebar-user {
                justify-content: center;
                padding: 8px;
            }

            .user-avatar {
                margin: 0;
            }

            .school-main {
                margin-left: 70px;

                width: calc(100% - 70px);

                min-height: 100vh;
            }

            .school-content {
                min-height: 0;

                padding: 18px 14px 24px;

                overflow-y: auto;
            }

            .student-form-page {
                min-height: auto;
            }

            .student-form-card {
                min-height: 0;
                flex: none;
            }

            .student-form {
                flex: none;
            }

            .student-form-actions {
                margin-top: 2rem;
            }

            .header-user-info {
                display: none;
            }

            .school-header {
                padding: 0 14px;
            }

            .school-footer {
                padding: 0 14px;
            }
        }
    </style>
</head>

<body>

<div class="school-app">

    {{-- =========================
         SIDEBAR
    ========================== --}}
    <aside class="school-sidebar">

        <div class="sidebar-brand">

            <div class="brand-icon">
                🎓
            </div>

            <div class="brand-text">
                <div class="brand-title">
                    School CRM
                </div>

                <div class="brand-subtitle">
                    School Management
                </div>
            </div>

        </div>


        <nav class="sidebar-nav">

            <div class="nav-section">

                <div class="nav-section-title">
                    Main
                </div>

                <a href="{{ url('/') }}"
                   class="nav-item {{ request()->is('/') ? 'active' : '' }}">

                    <span class="nav-icon">⌂</span>
                    <span>Dashboard</span>

                </a>

            </div>


            <div class="nav-section">

                <div class="nav-section-title">
                    People
                </div>

                <a href="{{ url('/students') }}" class="nav-item">
                    <span class="nav-icon">♙</span>
                    <span>Students</span>
                </a>

                <a href="{{ route('teachers.index') }}" class="nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <span class="nav-icon">♧</span>
                    <span>Teachers</span>
                </a>

            </div>


            <div class="nav-section">

                <div class="nav-section-title">
                    Academics
                </div>

                <a href="{{ route('classes.index') }}" class="nav-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <span class="nav-icon">▣</span>
                    <span>Classes</span>
                </a>

                <a href="{{ route('sections.index') }}" class="nav-item {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                    <span class="nav-icon">▣</span>
                    <span>Sections</span>
                </a>

                <a href="#" class="nav-item">
                    <span class="nav-icon">☑</span>
                    <span>Attendance</span>
                </a>

            </div>


            <div class="nav-section">

                <div class="nav-section-title">
                    Finance
                </div>

                <a href="#" class="nav-item">
                    <span class="nav-icon">₨</span>
                    <span>Fees</span>
                </a>

            </div>


            <div class="nav-section">

                <div class="nav-section-title">
                    Management
                </div>

                <a href="#" class="nav-item">
                    <span class="nav-icon">▥</span>
                    <span>Reports</span>
                </a>

            </div>

        </nav>


        <div class="sidebar-user">

            <div class="user-avatar">
                A
            </div>

            <div class="user-info">
                <div class="user-name">
                    Admin
                </div>

                <div class="user-role">
                    Administrator
                </div>
            </div>

            <div class="logout-icon">
                ⇥
            </div>

        </div>

    </aside>


    {{-- =========================
         MAIN
    ========================== --}}
    <main class="school-main">

        {{-- PAGE CONTENT --}}
        <section class="school-content">

            @yield('content')

        </section>


        {{-- FOOTER --}}
        <footer class="school-footer">
            School Management System
        </footer>

    </main>

</div>

</body>
</html>