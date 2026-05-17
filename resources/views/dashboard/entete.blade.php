<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Inspection générale des mines</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .primary-color {
            color: #0A1F7E;
        }
        .primary-bg {
            background-color: #0A1F7E;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .sidebar-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }
        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(10, 31, 126, 0.1) 0%, rgba(102, 126, 234, 0.1) 100%);
            border-left: 4px solid #0A1F7E;
            color: #0A1F7E;
            font-weight: 600;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 1000;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .dropdown:hover .dropdown-content,
        .dropdown-content.show {
            display: block;
        }
        
        /* Responsive styles */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                position: fixed;
                z-index: 50;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-menu-toggle {
                display: block;
            }
        }
        @media (min-width: 1024px) {
            .sidebar {
                position: relative;
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg border-b border-gray-200 z-50">
            <div class="px-4 md:px-6 py-6 md:py-8">
                <div class="flex items-center justify-between">
                    <!-- Logo à gauche -->
                    <div class="flex items-center">
                        <button class="mobile-menu-toggle mr-3 bg-white p-2 rounded-lg shadow-lg lg:hidden" onclick="toggleSidebar()">
                            <i class="fas fa-bars text-gray-700"></i>
                        </button>
                        <div class="w-10 h-10 primary-bg rounded-full flex items-center justify-center mr-3">
                            <img src="{{ asset('assets/images/2.png') }}" alt="Logo">
                        </div>
                        <h1 class="text-xl font-bold primary-color">Inspection générale des mines</h1>
                    </div>

                    <!-- Dropdown utilisateur -->
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <div class="w-8 h-8 primary-bg rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('dashboard.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Menu mobile caché -->
                <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4">
                    <nav class="flex flex-col space-y-2">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2">Tableau de bord</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium py-2">Contacts</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium py-2">Campagnes</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium py-2">Messages</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium py-2">Rapports</a>
                    </nav>
                </div>
            </header>

        <!-- Contenu principal avec sidebar -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside class="sidebar w-64 bg-white shadow-lg fixed lg:relative top-0 left-0 h-full z-40 lg:top-auto lg:left-auto">

                <!-- Navigation -->
                <nav class="p-4 flex-1">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-home w-5 mr-3 sidebar-icon"></i>
                                <span>Tableau de bord</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.roles') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-shield-alt w-5 mr-3 sidebar-icon"></i>
                                <span>Rôles</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.utilisateurs') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-users w-5 mr-3 sidebar-icon"></i>
                                <span>Utilisateurs</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-file w-5 mr-3 sidebar-icon"></i>
                                <span>Permis d'exploitation</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('dashboard.concessions')}}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-map w-5 mr-3 sidebar-icon"></i>
                                <span>Concession</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.sites') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-map-marker-alt w-5 mr-3 sidebar-icon"></i>
                                <span>Sites miniers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mines') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-gem w-5 mr-3 sidebar-icon"></i>
                                <span>Mines</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-shopping-cart w-5 mr-3 sidebar-icon"></i>
                                <span>Ventes de minerais</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-people-group w-5 mr-3 sidebar-icon"></i>
                                <span>Clients</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-chart-bar w-5 mr-3 sidebar-icon"></i>
                                <span>Rapports</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-bell w-5 mr-3 sidebar-icon"></i>
                                <span>Alertes</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Section Paramètres -->
                <div class="p-4 border-t border-gray-200">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard.profile') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-user w-5 mr-3 sidebar-icon"></i>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-item flex items-center p-3 rounded-lg text-gray-700">
                                <i class="fas fa-cog w-5 mr-3 sidebar-icon"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="sidebar-item w-full flex items-center p-3 rounded-lg text-gray-700 hover:text-red-600 text-left">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 sidebar-icon"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col main-content overflow-auto">
                <!-- Content -->
                <main class="flex-1 p-4 md:p-8 bg-gray-50">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar pour mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }
        
        // Toggle mobile menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Fermer le sidebar en cliquant à l'extérieur sur mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Fermer le dropdown en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown');
            const dropdownContent = document.querySelector('.dropdown-content');
            
            if (!dropdown.contains(event.target)) {
                dropdownContent.classList.remove('show');
            }
        });

        // Toggle dropdown au clic
        document.querySelector('.dropdown button').addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelector('.dropdown-content').classList.toggle('show');
        });
    </script>
</body>
</html>