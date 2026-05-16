<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Mines Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
        }
        .glass-effect {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .gradient-text {
            color: #0A1F7E;
        }
        .institution-bg {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center min-h-screen">
            
            <!-- Colonne gauche : Image -->
            <div class="">
                <img 
                    src="{{ asset('assets/images/3.jpg') }}" 
                    alt="Exploitation minière" 
                    class="w-full h-full object-contain"
                >
                <div class="text-center mt-6">
                    <span class="inline-block bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-full font-semibold text-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                        Du site à l'exploitation, zéro doute
                    </span>
                </div>
            </div>

            <!-- Colonne droite : Formulaire de connexion -->
            <div class="glass-effect rounded-3xl shadow-2xl p-12">
                <!-- Titre du formulaire -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenu(e)</h2>
                    <p class="text-gray-600">Dans l'application tracemines RDC 2.0</p>
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    <!-- Champ Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-3">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            Adresse email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-lg"
                            placeholder="votre@email.com"
                            required
                            autocomplete="email"
                            autofocus
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-3">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-lg"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Options supplémentaires -->
                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="mr-3 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-gray-700">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <!-- Bouton de connexion -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-lg shadow-lg"
                    >
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Se connecter
                    </button>
                </form>

                <!-- Lien d'inscription -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Pas encore de compte ? 
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200">
                            Créer un compte
                        </a>
                    </p>
                </div>

               
            </div>
        </div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.glass-effect');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                form.style.transition = 'all 0.6s ease';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
