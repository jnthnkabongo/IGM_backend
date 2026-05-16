@extends('dashboard.entete')

@section('content')
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 md:p-8 mb-6 md:mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-indigo-100 rounded-full opacity-20 blur-2xl"></div>
            <div class="relative z-10">
                <h1 class="text-1xl md:text-2xl font-bold text-gray-800 mb-2">Bienvenue {{ auth()->user()->name }} dans la plateforme de gestion des mines</h1>
                <p class="text-gray-600 text-sm md:text-base max-w-2xl">Gérez efficacement vos mines, agents et opérations depuis une interface moderne et intuitive.</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Mines Card -->
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-gem text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm text-gray-500 font-medium">Total</span>
                </div>
                <h3 class="text-sm md:text-lg font-semibold text-gray-700 mb-1">Mines actives</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_mines'] ?? 156 }}</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                    <span class="text-green-500 text-xs font-medium">+12%</span>
                </div>
            </div>

            <!-- Agents Card -->
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-people-group text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm text-gray-500 font-medium">Actifs</span>
                </div>
                <h3 class="text-sm md:text-lg font-semibold text-gray-700 mb-1">Agents terrain</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_agents'] ?? 89 }}</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                    <span class="text-green-500 text-xs font-medium">+8%</span>
                </div>
            </div>

            <!-- Permis Card -->
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-contract text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm text-gray-500 font-medium">Validés</span>
                </div>
                <h3 class="text-sm md:text-lg font-semibold text-gray-700 mb-1">Permis d'exploitation</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_permits'] ?? 234 }}</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                    <span class="text-green-500 text-xs font-medium">+23%</span>
                </div>
            </div>
            
            <!-- Inspections Card -->
            <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-check text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-xs md:text-sm text-gray-500 font-medium">Ce mois</span>
                </div>
                <h3 class="text-sm md:text-lg font-semibold text-gray-700 mb-1">Inspections</h3>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_inspections'] ?? 67 }}</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                    <span class="text-green-500 text-xs font-medium">+5%</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 mb-6 md:mb-8">
            <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-4">Actions rapides</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <button class="flex items-center justify-center p-3 md:p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-gem text-blue-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nouvelle Mine</span>
                </button>
                <button class="flex items-center justify-center p-3 md:p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-people-group text-green-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Ajouter Agent</span>
                </button>
                <button class="flex items-center justify-center p-3 md:p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-file-contract text-purple-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Permis d'Exploitation</span>
                </button>
                <button class="flex items-center justify-center p-3 md:p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-clipboard-check text-orange-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Nouvelle Inspection</span>
                </button>
            </div>
        </div>

        <!-- Agents Terrain Section -->
        <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200 mb-6 md:mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-4">
                <h3 class="text-lg md:text-xl font-semibold text-gray-700">Agents terrain actifs</h3>
                <button class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg text-sm font-medium shadow-lg hover:shadow-xl transform transition-all duration-200 hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Ajouter Agent
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Agent 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 md:p-6 border border-blue-200 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Jean-Pierre Muteba</h4>
                            <p class="text-sm text-gray-600">Inspecteur Principal</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2 text-blue-500"></i>
                            <span>+243 812 345 678</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>
                            <span class="text-xs">jp.muteba@mines.cd</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                            <span>Katanga</span>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Actif</span>
                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">12 missions</span>
                        </div>
                    </div>
                </div>

                <!-- Agent 2 -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 md:p-6 border border-green-200 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Marie Kabongo</h4>
                            <p class="text-sm text-gray-600">Inspecteur Junior</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2 text-green-500"></i>
                            <span>+243 823 456 789</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2 text-green-500"></i>
                            <span class="text-xs">m.kabongo@mines.cd</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                            <span>Haut-Katanga</span>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Actif</span>
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">8 missions</span>
                        </div>
                    </div>
                </div>

                <!-- Agent 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 md:p-6 border border-purple-200 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Pierre Ntumba</h4>
                            <p class="text-sm text-gray-600">Superviseur</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2 text-purple-500"></i>
                            <span>+243 834 567 890</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-2 text-purple-500"></i>
                            <span class="text-xs">p.ntumba@mines.cd</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2 text-purple-500"></i>
                            <span>Lualaba</span>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Actif</span>
                            <span class="ml-2 px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-medium">15 missions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl p-4 md:p-6 shadow-lg border border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-4">
                <h3 class="text-lg md:text-xl font-semibold text-gray-700">Dernières mines enregistrées</h3>
                <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-sm font-medium shadow-lg hover:shadow-xl transform transition-all duration-200 hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Nouvelle Mine
                </button>
            </div>
            
            <div class="overflow-x-auto">
               <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="px-4 md:px-6 py-3 font-semibold">Nom de la mine</th>
                        <th scope="col" class="px-4 md:px-6 py-3 font-semibold">Type</th>
                        <th scope="col" class="px-4 md:px-6 py-3 font-semibold hidden md:table-cell">Localisation</th>
                        <th scope="col" class="px-4 md:px-6 py-3 font-semibold hidden lg:table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors duration-200">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center mr-2 md:mr-3 shadow-md">
                                    <i class="fas fa-gem text-white text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Mine de Kolwezi</div>
                                    <div class="text-xs md:text-sm text-gray-500">Permis #KOL-2024-001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900 flex items-center">
                                    <i class="fas fa-gem text-gray-400 mr-1 md:mr-2 text-xs md:text-sm"></i>
                                    <span class="ml-1">Cuivre</span>
                                </div>
                                <div class="text-gray-500 flex items-center mt-1">
                                    <i class="fas fa-certificate text-green-600 mr-1 md:mr-2 text-xs md:text-sm"></i>
                                    <span class="ml-1">Active</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 hidden md:table-cell">
                            <div class="text-sm text-gray-900">Katanga, RDC</div>
                        </td>
                        <td class="px-4 md:px-6 py-4 hidden lg:table-cell">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr class="bg-white border-b hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors duration-200">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center mr-2 md:mr-3 shadow-md">
                                    <i class="fas fa-gem text-white text-sm md:text-base"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Mine de Likasi</div>
                                    <div class="text-xs md:text-sm text-gray-500">Permis #LIK-2024-002</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900 flex items-center">
                                    <i class="fas fa-gem text-gray-400 mr-1 md:mr-2 text-xs md:text-sm"></i>
                                    <span class="ml-1">Cobalt</span>
                                </div>
                                <div class="text-gray-500 flex items-center mt-1">
                                    <i class="fas fa-certificate text-green-600 mr-1 md:mr-2 text-xs md:text-sm"></i>
                                    <span class="ml-1">Active</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 hidden md:table-cell">
                            <div class="text-sm text-gray-900">Haut-Katanga, RDC</div>
                        </td>
                        <td class="px-4 md:px-6 py-4 hidden lg:table-cell">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="4" class="px-4 md:px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-gem text-gray-400 text-3xl mb-2"></i>
                                <span>Aucune autre mine trouvée</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
@endsection
       