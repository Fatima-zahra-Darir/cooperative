<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Co-op ERP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            color: #1f2937;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #2d7a52;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.9375rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: #f9fafb;
            color: #1f2937;
        }

        .nav-item.active {
            background: #2d7a52;
            color: white;
        }

        .nav-item-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2d7a52 0%, #1a5f3f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            width: 300px;
        }

        .search-input:focus {
            outline: none;
            border-color: #2d7a52;
            box-shadow: 0 0 0 3px rgba(45, 122, 82, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #9ca3af;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.2s;
        }

        .icon-button:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .search-input {
                width: 200px;
            }
        }
        /* Dropdown Styles */
        .nav-dropdown {
            width: 100%;
        }

        .nav-dropdown-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.75rem 1.5rem;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.9375rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: transparent;
        }

        .nav-dropdown-trigger:hover {
            background: #f9fafb;
            color: #1f2937;
        }

        .nav-dropdown-trigger.active {
            color: #2d7a52;
            font-weight: 500;
        }

        .nav-dropdown-icon {
            width: 16px;
            height: 16px;
            transition: transform 0.2s;
        }

        .nav-dropdown.open .nav-dropdown-icon {
            transform: rotate(180deg);
        }

        .nav-dropdown-content {
            display: none;
            background: #f9fafb;
            padding: 0.25rem 0;
        }

        .nav-dropdown.open .nav-dropdown-content {
            display: block;
        }

        .sub-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1.5rem 0.625rem 3.25rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .sub-nav-item:hover {
            color: #1f2937;
            background: #f3f4f6;
        }

        .sub-nav-item.active {
            color: #2d7a52;
            font-weight: 600;
            background: #f0fdf4;
            border-right: 3px solid #2d7a52;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">🍃</div>
            <div class="logo-text">Co-op ERP</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Tableau de bord</span>
                </a>
                <div class="nav-dropdown {{ request()->routeIs('stock-produit.*', 'stock-capsules.*', 'stock-herb.*') ? 'open' : '' }}">
                    <button class="nav-dropdown-trigger {{ request()->routeIs('stock-produit.*', 'stock-capsules.*', 'stock-herb.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Gestion du stock</span>
                        </div>
                        <svg class="nav-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="nav-dropdown-content">
                        <a href="{{ route('stock-produit.index') }}" class="sub-nav-item {{ request()->routeIs('stock-produit.*') ? 'active' : '' }}">
                            <span>Stock Embalage</span>
                        </a>
                        <a href="{{ route('stock-capsules.index') }}" class="sub-nav-item {{ request()->routeIs('stock-capsules.*') ? 'active' : '' }}">
                            <span>Stock Capsules</span>
                        </a>
                        <a href="{{ route('stock-herb.index') }}" class="sub-nav-item {{ request()->routeIs('stock-herb.*') ? 'active' : '' }}">
                            <span>Stock Herb</span>
                        </a>
                    </div>
                </div>
                <div class="nav-dropdown {{ request()->routeIs('products.*', 'categories.*', 'colors.*', 'sizes.*') ? 'open' : '' }}">
                    <button class="nav-dropdown-trigger {{ request()->routeIs('products.*', 'categories.*', 'colors.*', 'sizes.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Gestion Embalage</span>
                        </div>
                        <svg class="nav-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="nav-dropdown-content">
                        <a href="{{ route('products.index') }}" class="sub-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <span>Embalage</span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="sub-nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <span>Catégories</span>
                        </a>
                        <a href="{{ route('colors.index') }}" class="sub-nav-item {{ request()->routeIs('colors.*') ? 'active' : '' }}">
                            <span>Couleurs</span>
                        </a>
                        <a href="{{ route('sizes.index') }}" class="sub-nav-item {{ request()->routeIs('sizes.*') ? 'active' : '' }}">
                            <span>Tailles</span>
                        </a>
                    </div>
                </div>
                <div class="nav-dropdown {{ request()->routeIs('herbs.*') ? 'open' : '' }}">
                    <button class="nav-dropdown-trigger {{ request()->routeIs('herbs.*') ? 'active' : '' }}" onclick="toggleDropdown(this)">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Gestion Herb</span>
                        </div>
                        <svg class="nav-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="nav-dropdown-content">
                        <a href="{{ route('herbs.index') }}" class="sub-nav-item {{ request()->routeIs('herbs.*') ? 'active' : '' }}">
                            <span>Herb</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('clients.index') }}" class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Clients</span>
                </a>
                <a href="{{ route('fornisseurs.index') }}" class="nav-item {{ request()->routeIs('fornisseurs.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Fournisseurs</span>
                </a>
                <a href="{{ route('commandes.index') }}" class="nav-item {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Gestion Commandes</span>
                </a>
                <a href="{{ route('revenue.index') }}" class="nav-item {{ request()->routeIs('revenue.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Revenus</span>
                </a>
                <a href="{{ route('expenses.index') }}" class="nav-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Dépenses</span>
                </a>
                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Rapports & statistiques</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">ADMINISTRATION</div>
                <a href="{{ route('onca.index') }}" class="nav-item {{ request()->routeIs('onca.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Gestion des documents ONCA</span>
                </a>
                <a href="{{ route('archives.index') }}" class="nav-item {{ request()->routeIs('archives.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span>Archivage administratif</span>
                </a>
                <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Paramètres</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Alex Morgan' }}</div>
                    <div class="user-role">Admin</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
                @csrf
                <button type="submit" style="width: 100%; padding: 0.5rem; background: transparent; border: 1px solid #e5e7eb; border-radius: 0.5rem; color: #6b7280; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="main-header">
            <h1 class="page-title">@yield('page-title', 'Dashboard Overview')</h1>
            <div class="header-actions">
                <div class="search-box">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" class="search-input" placeholder="Search...">
                </div>
                <button class="icon-button" title="Notifications">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>
                <button class="icon-button" title="Help">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleDropdown(button) {
            const dropdown = button.parentElement;
            dropdown.classList.toggle('open');
        }
    </script>
    @stack('scripts')
</body>
</html>

