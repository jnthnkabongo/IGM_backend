@extends('dashboard.entete')

@section('content')
    <div class="space-y-8">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-users text-blue-600"></i>
                Liste des utilisateurs
            </h1>
            <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter utilisateur
            </button>
        </div>
        <!-- Barre de recherche -->
        <div class="bg-white rounded-xl shadow-lg p-2">
            <div class="flex items-center gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher un utilisateur..." class="w-full pl-12 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Rechercher</button>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-users"></i>
                    Liste des utilisateurs
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rôle</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Téléphone</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                        <span class="text-white font-bold text-lg">{{ $user->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $user->email }}</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($user->role)
                                <span class="px-4 py-2 rounded-full text-xs font-bold shadow-sm
                                    {{ $user->role->nom === 'administrateur' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' }}">
                                    {{ ucfirst($user->role->nom) }}
                                </span>
                                @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gray-200 text-gray-700 shadow-sm">
                                    Non défini
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $user->telephone ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($user->actif ?? true)
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                    Actif
                                </span>
                                @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-red-500 to-red-600 text-white shadow-sm">
                                    Inactif
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-3">
                                    <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->telephone ?? '' }}', {{ $user->role_id ?? 'null' }})" class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun utilisateur trouvé</p>
                                    <p class="text-gray-400 text-sm mt-1">Commencez par ajouter un nouveau utilisateur</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout d'utilisateur -->
    <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Ajouter un utilisateur
                </h3>
            </div>
            <form action="{{ route('dashboard.saveUtilisateur') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="name" id="userName" placeholder="Nom complet" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="userEmail" placeholder="email@example.com" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input type="password" name="password" id="userPassword" placeholder="Mot de passe" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="telephone" id="userTelephone" placeholder="Téléphone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div> --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                        <select name="role_id" id="userRoleId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}">{{ $role->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveUserBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification d'utilisateur -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Modifier un utilisateur
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="editUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editUserId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="name" id="editUserName" placeholder="Nom complet" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="editUserEmail" placeholder="email@example.com" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" name="password" id="editUserPassword" placeholder="Nouveau mot de passe" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                        <select name="role_id" id="editUserRoleId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}">{{ $role->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="updateUserBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirmer la suppression
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir supprimer l'utilisateur <strong id="deleteUserName" class="text-red-600"></strong> ?
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Cette action est irréversible.
                </p>
                <form action="" method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteUserId">
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg">
                            Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userModal').classList.remove('flex');
            // Reset form
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userPassword').value = '';
            document.getElementById('userRoleId').value = '';
            checkForm();
        }

        function checkForm() {
            const name = document.getElementById('userName').value.trim();
            const email = document.getElementById('userEmail').value.trim();
            const password = document.getElementById('userPassword').value.trim();
            const roleId = document.getElementById('userRoleId').value;
            const saveBtn = document.getElementById('saveUserBtn');

            if (name && email && password && roleId) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('userModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function openEditModal(id, name, email, roleId) {
            document.getElementById('editUserId').value = id;
            document.getElementById('editUserName').value = name;
            document.getElementById('editUserEmail').value = email;
            document.getElementById('editUserRoleId').value = roleId || '';
            document.getElementById('editUserForm').action = "{{ route('dashboard.updateUtilisateur', ':id') }}".replace(':id', id);
            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex');
            checkEditForm();
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
            // Reset form
            document.getElementById('editUserId').value = '';
            document.getElementById('editUserName').value = '';
            document.getElementById('editUserEmail').value = '';
            document.getElementById('editUserPassword').value = '';
            document.getElementById('editUserRoleId').value = '';
            checkEditForm();
        }

        function checkEditForm() {
            const name = document.getElementById('editUserName').value.trim();
            const email = document.getElementById('editUserEmail').value.trim();
            const roleId = document.getElementById('editUserRoleId').value;
            const updateBtn = document.getElementById('updateUserBtn');

            if (name && email && roleId) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        function openDeleteModal(id, name) {
            document.getElementById('deleteUserId').value = id;
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteUserForm').action = "{{ route('dashboard.deleteUtilisateur', ':id') }}".replace(':id', id);
            document.getElementById('deleteUserModal').classList.remove('hidden');
            document.getElementById('deleteUserModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteUserModal').classList.add('hidden');
            document.getElementById('deleteUserModal').classList.remove('flex');
            // Reset form
            document.getElementById('deleteUserId').value = '';
            document.getElementById('deleteUserName').textContent = '';
        }

        // Close delete modal when clicking outside
        document.getElementById('deleteUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
