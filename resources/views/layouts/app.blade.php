<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>School CRM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* =========================
        DESIGN SYSTEM - CSS CUSTOM PROPERTIES
        ========================= */
        :root {
            /* Color Palette */
            --color-primary-50: #eef2ff;
            --color-primary-100: #e0e7ff;
            --color-primary-200: #c7d2fe;
            --color-primary-300: #a5b4fc;
            --color-primary-400: #818cf8;
            --color-primary-500: #6366f1;
            --color-primary-600: #4f46e5;
            --color-primary-700: #4338ca;
            --color-primary-800: #3730a3;
            --color-primary-900: #312e81;

            --color-success-50: #ecfdf5;
            --color-success-100: #d1fae5;
            --color-success-500: #10b981;
            --color-success-600: #059669;
            --color-success-700: #047857;

            --color-warning-50: #fffbeb;
            --color-warning-100: #fef3c7;
            --color-warning-500: #f59e0b;
            --color-warning-600: #d97706;

            --color-danger-50: #fef2f2;
            --color-danger-100: #fee2e2;
            --color-danger-500: #ef4444;
            --color-danger-600: #dc2626;

            --color-info-50: #eff6ff;
            --color-info-100: #dbeafe;
            --color-info-500: #3b82f6;
            --color-info-600: #2563eb;

            /* Neutral Colors */
            --color-white: #ffffff;
            --color-gray-50: #f9fafb;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
            --color-gray-950: #030712;

            /* Sidebar Colors */
            --sidebar-bg: var(--color-gray-950);
            --sidebar-border: rgba(255, 255, 255, 0.05);
            --sidebar-text: var(--color-white);
            --sidebar-text-muted: #94a3b8;
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --sidebar-active-bg: var(--color-primary-600);
            --sidebar-active-shadow: rgba(79, 70, 229, 0.25);

            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;

            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

            /* Transitions */
            --transition-fast: 150ms ease;
            --transition-base: 200ms ease;
            --transition-slow: 300ms ease;

            /* Layout */
            --sidebar-width: 254px;
            --sidebar-width-collapsed: 70px;
            --sidebar-width-tablet: 220px;
            --header-height: 64px;
            --footer-height: 42px;

            /* Typography */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            --font-mono: 'JetBrains Mono', 'Fira Code', monospace;

            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-xl: 1.25rem;
            --text-2xl: 1.5rem;
            --text-3xl: 1.875rem;
            --text-4xl: 2.25rem;

            --font-normal: 400;
            --font-medium: 500;
            --font-semibold: 600;
            --font-bold: 700;
        }

        /* =========================
        GLOBAL
        ========================= */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            width: 100%;
            height: 100%;
        }

        body {
            width: 100%;
            min-height: 100vh;
            font-family: var(--font-sans);
            background: var(--color-gray-50);
            color: var(--color-gray-900);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Focus visible for accessibility */
        *:focus-visible {
            outline: 2px solid var(--color-primary-500);
            outline-offset: 2px;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-gray-400);
            border-radius: var(--radius-full);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-gray-500);
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
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
            transition: width var(--transition-base);
            border-right: 1px solid var(--sidebar-border);
        }

        /* =========================
        SIDEBAR BRAND
        ========================= */
        .sidebar-brand {
            height: var(--header-height);
            min-height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 var(--space-4);
            border-bottom: 1px solid var(--sidebar-border);
            position: relative;
        }

        .sidebar-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: var(--space-4);
            right: var(--space-4);
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--color-primary-600), transparent);
            opacity: 0.3;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--color-primary-600), var(--color-primary-700));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: var(--space-3);
            flex-shrink: 0;
            transition: var(--transition-fast);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .brand-icon svg {
            width: 22px;
            height: 22px;
            stroke: white;
        }

        .brand-text {
            line-height: 1.15;
            overflow: hidden;
            transition: opacity var(--transition-fast), width var(--transition-fast);
        }

        .brand-title {
            font-size: var(--text-base);
            font-weight: var(--font-bold);
            white-space: nowrap;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-subtitle {
            margin-top: 2px;
            font-size: var(--text-xs);
            color: var(--sidebar-text-muted);
            white-space: nowrap;
            font-weight: var(--font-medium);
        }

        /* =========================
        SIDEBAR NAV
        ========================= */
        .sidebar-nav {
            flex: 1;
            padding: var(--space-4) var(--space-2) var(--space-2);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-section {
            margin-bottom: var(--space-5);
        }

        .nav-section-title {
            padding: 0 var(--space-3);
            margin-bottom: var(--space-2);
            font-size: var(--text-xs);
            font-weight: var(--font-semibold);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--sidebar-text-muted);
            transition: opacity var(--transition-fast);
            position: relative;
        }

        .nav-section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 12px;
            background: var(--color-primary-600);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        .nav-item {
            width: 100%;
            height: 44px;
            display: flex;
            align-items: center;
            padding: 0 var(--space-3);
            margin-bottom: var(--space-1);
            border-radius: var(--radius-lg);
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
            transition: all var(--transition-fast);
            gap: var(--space-3);
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--color-primary-600);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform var(--transition-fast);
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text);
            padding-left: var(--space-4);
        }

        .nav-item:hover::before {
            transform: scaleY(1);
            transform-origin: top;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
            color: var(--sidebar-text);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            border-left: 3px solid var(--color-primary-600);
        }

        .nav-item.active .nav-icon {
            color: var(--color-primary-400);
        }

        .nav-icon {
            width: 22px;
            min-width: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
            color: var(--sidebar-text-muted);
            transition: all var(--transition-fast);
        }

        .nav-item:hover .nav-icon {
            color: var(--sidebar-text);
        }

        .nav-item span:not(.nav-icon) {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition-fast), width var(--transition-fast);
        }

        /* =========================
        SIDEBAR USER
        ========================= */
        .sidebar-user {
            min-height: 78px;
            margin: 0 var(--space-3) var(--space-3);
            padding: var(--space-3);
            border-radius: var(--radius-xl);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
            display: flex;
            align-items: center;
            gap: var(--space-3);
            border: 1px solid var(--sidebar-border);
            position: relative;
            overflow: hidden;
        }

        .sidebar-user::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--color-primary-600), transparent);
            opacity: 0.3;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--color-primary-600), var(--color-primary-700));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-base);
            font-weight: var(--font-bold);
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .user-info {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            transition: opacity var(--transition-fast), width var(--transition-fast);
        }

        .user-name {
            color: var(--sidebar-text);
            font-size: var(--text-sm);
            font-weight: var(--font-semibold);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            margin-top: 2px;
            color: var(--sidebar-text-muted);
            font-size: var(--text-xs);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: var(--font-medium);
        }

        .logout-btn {
            color: var(--sidebar-text-muted);
            font-size: 16px;
            flex-shrink: 0;
            transition: all var(--transition-fast);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-lg);
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: var(--color-danger-400);
            background: var(--color-danger-500/10);
        }

        .logout-btn:focus-visible {
            outline: 2px solid var(--color-primary-500);
            outline-offset: 2px;
        }

        /* =========================
        MAIN AREA
        ========================= */
        .school-main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--transition-base), width var(--transition-base);
        }

        /* =========================
        HEADER
        ========================= */
        .school-header {
            position: sticky;
            top: 0;
            width: 100%;
            height: var(--header-height);
            min-height: var(--header-height);
            background: var(--color-white);
            border-bottom: 1px solid var(--color-gray-200);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 var(--space-6);
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .notification {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-gray-500);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
        }

        .notification:hover {
            background: var(--color-gray-100);
            color: var(--color-gray-700);
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 6px;
            height: 6px;
            background: var(--color-primary-600);
            border-radius: var(--radius-full);
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-lg);
            transition: background var(--transition-fast);
        }

        .header-user:hover {
            background: var(--color-gray-100);
        }

        .header-user-info {
            text-align: right;
            line-height: 1.2;
        }

        .header-user-name {
            font-size: var(--text-sm);
            font-weight: var(--font-bold);
            color: var(--color-gray-900);
        }

        .header-user-role {
            margin-top: 2px;
            font-size: var(--text-xs);
            color: var(--color-gray-500);
        }

        .header-avatar {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            background: var(--color-primary-100);
            color: var(--color-primary-700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-sm);
            font-weight: var(--font-bold);
        }

        /* =========================
        CONTENT
        ========================= */
        .school-content {
            flex: 1 1 auto;
            width: 100%;
            min-height: 0;
            padding: var(--space-6) var(--space-6) var(--space-8);
            overflow-x: hidden;
            overflow-y: auto;
        }

        .school-content > * {
            width: 100%;
        }

        /* =========================
        PAGE SPECIFIC
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
            height: var(--footer-height);
            min-height: var(--footer-height);
            border-top: 1px solid var(--color-gray-200);
            background: var(--color-white);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 var(--space-6);
            color: var(--color-gray-500);
            font-size: var(--text-xs);
        }

        /* =========================
        COMPONENT UTILITIES
        ========================= */
        .card {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--color-gray-200);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            padding: var(--space-5) var(--space-6);
            border-bottom: 1px solid var(--color-gray-200);
        }

        .card-body {
            padding: var(--space-6);
        }

        .card-footer {
            padding: var(--space-4) var(--space-6);
            border-top: 1px solid var(--color-gray-200);
            background: var(--color-gray-50);
            border-radius: 0 0 var(--radius-xl) var(--radius-xl);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-4);
            font-size: var(--text-sm);
            font-weight: var(--font-semibold);
            border-radius: var(--radius-lg);
            border: none;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
            white-space: nowrap;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: var(--color-primary-600);
            color: var(--color-white);
            box-shadow: 0 1px 2px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--color-primary-700);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: var(--color-white);
            color: var(--color-gray-700);
            border: 1px solid var(--color-gray-300);
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--color-gray-50);
            border-color: var(--color-gray-400);
        }

        .btn-success {
            background: var(--color-success-600);
            color: var(--color-white);
        }

        .btn-success:hover:not(:disabled) {
            background: var(--color-success-700);
        }

        .btn-danger {
            background: var(--color-danger-600);
            color: var(--color-white);
        }

        .btn-danger:hover:not(:disabled) {
            background: var(--color-danger-700);
        }

        .btn-ghost {
            background: transparent;
            color: var(--color-gray-600);
        }

        .btn-ghost:hover:not(:disabled) {
            background: var(--color-gray-100);
            color: var(--color-gray-900);
        }

        .btn-sm {
            padding: var(--space-1) var(--space-3);
            font-size: var(--text-xs);
        }

        .btn-lg {
            padding: var(--space-3) var(--space-6);
            font-size: var(--text-base);
        }

        .btn-icon {
            padding: var(--space-2);
        }

        /* Form elements */
        .form-input {
            width: 100%;
            padding: var(--space-2) var(--space-3);
            font-size: var(--text-sm);
            border: 1px solid var(--color-gray-300);
            border-radius: var(--radius-lg);
            background: var(--color-white);
            color: var(--color-gray-900);
            transition: all var(--transition-fast);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-primary-500);
            box-shadow: 0 0 0 3px var(--color-primary-100);
        }

        .form-input::placeholder {
            color: var(--color-gray-400);
        }

        .form-label {
            display: block;
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
            color: var(--color-gray-700);
            margin-bottom: var(--space-1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: var(--space-1) var(--space-2);
            font-size: var(--text-xs);
            font-weight: var(--font-semibold);
            border-radius: var(--radius-full);
        }

        .badge-primary {
            background: var(--color-primary-100);
            color: var(--color-primary-700);
        }

        .badge-success {
            background: var(--color-success-100);
            color: var(--color-success-700);
        }

        .badge-warning {
            background: var(--color-warning-100);
            color: var(--color-warning-600);
        }

        .badge-danger {
            background: var(--color-danger-100);
            color: var(--color-danger-700);
        }

        .badge-info {
            background: var(--color-info-100);
            color: var(--color-info-700);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            padding: var(--space-3) var(--space-4);
            text-align: left;
            font-size: var(--text-xs);
            font-weight: var(--font-semibold);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-gray-500);
            background: var(--color-gray-50);
            border-bottom: 1px solid var(--color-gray-200);
            white-space: nowrap;
        }

        .table td {
            padding: var(--space-3) var(--space-4);
            font-size: var(--text-sm);
            color: var(--color-gray-600);
            border-bottom: 1px solid var(--color-gray-100);
        }

        .table tbody tr {
            transition: background var(--transition-fast);
        }

        .table tbody tr:hover {
            background: var(--color-gray-50);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Stat Card */
        .stat-card {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--color-gray-200);
            padding: var(--space-5) var(--space-6);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-base);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-card-primary {
            background: linear-gradient(135deg, var(--color-primary-600), var(--color-primary-700));
            border-color: transparent;
            color: var(--color-white);
        }

        .stat-card-primary:hover {
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.3), 0 8px 10px -6px rgba(79, 70, 229, 0.2);
        }

        /* =========================
        TABLET
        ========================= */
        @media (max-width: 1024px) {
            .school-sidebar {
                width: var(--sidebar-width-tablet);
            }

            .school-main {
                margin-left: var(--sidebar-width-tablet);
                width: calc(100% - var(--sidebar-width-tablet));
            }

            .school-content {
                padding: var(--space-5) var(--space-4) var(--space-8);
            }
        }

        /* =========================
        MOBILE
        ========================= */
        @media (max-width: 768px) {
            .school-sidebar {
                width: var(--sidebar-width-collapsed);
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
                padding: var(--space-2);
            }

            .user-avatar {
                margin: 0;
            }

            .school-main {
                margin-left: var(--sidebar-width-collapsed);
                width: calc(100% - var(--sidebar-width-collapsed));
                min-height: 100vh;
            }

            .school-content {
                min-height: 0;
                padding: var(--space-4) var(--space-3) var(--space-6);
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
                padding: 0 var(--space-3);
            }

            .school-footer {
                padding: 0 var(--space-3);
            }

            .table th,
            .table td {
                padding: var(--space-2) var(--space-3);
            }
        }

        /* Print styles */
        @media print {
            .school-sidebar,
            .school-header,
            .school-footer,
            .btn,
            .student-actions {
                display: none !important;
            }

            .school-main {
                margin-left: 0;
                width: 100%;
            }

            .school-content {
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 1px solid var(--color-gray-300);
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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
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

                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span>Dashboard</span>

                </a>

            </div>


            @if (auth()->user()->hasSchoolPermission('students') || auth()->user()->isAdmin())
            <div class="nav-section">

                <div class="nav-section-title">
                    People
                </div>

                <a href="{{ url('/students') }}" class="nav-item {{ request()->is('students*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </span>
                    <span>Students</span>
                </a>

                @if (auth()->user()->hasSchoolPermission('teachers') || auth()->user()->isAdmin())
                <a href="{{ route('teachers.index') }}" class="nav-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M13 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                    </span>
                    <span>Teachers</span>
                </a>
                @endif

            </div>
            @endif


            @if (auth()->user()->hasSchoolPermission('classes') || auth()->user()->hasSchoolPermission('sections') || auth()->user()->hasSchoolPermission('attendance') || auth()->user()->isAdmin())
            <div class="nav-section">

                <div class="nav-section-title">
                    Academics
                </div>

                @if (auth()->user()->hasSchoolPermission('classes') || auth()->user()->isAdmin())
                <a href="{{ route('classes.index') }}" class="nav-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10V4a2 2 0 0 0-2-2h-2v14h-4V4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h4"/>
                            <path d="M11 14h6"/>
                            <path d="M11 18h6"/>
                        </svg>
                    </span>
                    <span>Classes</span>
                </a>
                @endif

                @if (auth()->user()->hasSchoolPermission('sections') || auth()->user()->isAdmin())
                <a href="{{ route('sections.index') }}" class="nav-item {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </span>
                    <span>Sections</span>
                </a>
                @endif

                @if (auth()->user()->hasSchoolPermission('attendance') || auth()->user()->isAdmin())
                <a href="{{ route('attendances.index') }}" class="nav-item {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <path d="M9 14l2 2 4-4"/>
                        </svg>
                    </span>
                    <span>Attendance</span>
                </a>
                @endif

            </div>
            @endif


            @if (auth()->user()->hasSchoolPermission('fees') || auth()->user()->isAdmin())
            <div class="nav-section">

                <div class="nav-section-title">
                    Finance
                </div>

                <a href="{{ route('fees.index') }}" class="nav-item {{ request()->routeIs('fees.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </span>
                    <span>Fees</span>
                </a>

            </div>
            @endif


            @if (auth()->user()->hasSchoolPermission('reports') || auth()->user()->isAdmin())
            <div class="nav-section">

                <div class="nav-section-title">
                    Reports
                </div>

                <a href="{{ route('reports.fees') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </span>
                    <span>Fee Report</span>
                </a>

            </div>
            @endif

            @if (auth()->user()->isAdmin())
            <div class="nav-section">

                <div class="nav-section-title">
                    Administration
                </div>

                <a href="{{ route('admin.schools.index') }}" class="nav-item {{ request()->routeIs('admin.schools*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </span>
                    <span>Schools</span>
                </a>

            </div>
            @endif

        </nav>


        <div class="sidebar-user">

            <div class="user-avatar">
                {{ strtoupper(Auth::user()->name[0] ?? 'A') }}
            </div>

            <div class="user-info">
                <div class="user-name">
                    {{ Auth::user()->name }}
                </div>

                <div class="user-role">
                    {{ ucfirst(Auth::user()->role ?? 'Administrator') }}
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Sign out">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>

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