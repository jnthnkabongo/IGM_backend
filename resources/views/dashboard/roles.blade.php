@extends('dashboard.entete')

@section('content')
    <div class="space-y-8">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-user-shield text-blue-600"></i>
                Liste des roles
            </h1>
            <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter role
            </button>
        </div>
        <!-- Barre de recherche -->
        <div class="bg-white rounded-xl shadow-lg p-2">
            <div class="flex items-center gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher un role..." class="w-full pl-12 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Rechercher</button>
            </div>
        </div>

        <!-- Tableau des roles -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-user-shield"></i>
                    Liste des roles
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $role)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                        <span class="text-white font-bold text-lg">{{ $role->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $role->nom }}</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($role->name)
                                <span class="px-4 py-2 rounded-full text-xs font-bold shadow-sm
                                    {{ $role->name === 'administrateur' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                                @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gray-200 text-gray-700 shadow-sm">
                                    Non défini
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($role->actif ?? true)
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
                                    <button onclick="openEditModal({{ $role->id }}, '{{ $role->nom }}', '{{ $role->description ?? '' }}')" class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $role->id }}, '{{ $role->nom }}')" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Supprimer">
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
                                        <i class="fas fa-user-shield text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun role trouvé</p>
                                    <p class="text-gray-400 text-sm mt-1">Commencez par ajouter un nouveau role</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de role -->
    <div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-user-shield"></i>
                    Ajouter un rôle
                </h3>
            </div>
            <form action="{{ route('dashboard.saveRole') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du rôle</label>
                        <input type="text" name="nom" id="roleName" placeholder="Ex: administrateur" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="roleDescription" placeholder="Description du rôle..." rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" oninput="checkForm()"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveRoleBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification de role -->
    <div id="editRoleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Modifier un rôle
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="editRoleForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editRoleId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du rôle</label>
                        <input type="text" name="nom" id="editRoleName" placeholder="Ex: administrateur" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="editRoleDescription" placeholder="Description du rôle..." rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" oninput="checkEditForm()"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="updateRoleBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteRoleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirmer la suppression
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir supprimer le rôle <strong id="deleteRoleName" class="text-red-600"></strong> ?
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Cette action est irréversible.
                </p>
                <form action="" method="POST" id="deleteRoleForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteRoleId">
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
            document.getElementById('roleModal').classList.remove('hidden');
            document.getElementById('roleModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('roleModal').classList.add('hidden');
            document.getElementById('roleModal').classList.remove('flex');
            // Reset form
            document.getElementById('roleName').value = '';
            document.getElementById('roleDescription').value = '';
            checkForm();
        }

        function checkForm() {
            const nom = document.getElementById('roleName').value.trim();
            const description = document.getElementById('roleDescription').value.trim();
            const saveBtn = document.getElementById('saveRoleBtn');

            if (nom && description) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('roleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function openEditModal(id, nom, description) {
            document.getElementById('editRoleId').value = id;
            document.getElementById('editRoleName').value = nom;
            document.getElementById('editRoleDescription').value = description;
            document.getElementById('editRoleForm').action = "{{ route('dashboard.updateRole', ':id') }}".replace(':id', id);
            document.getElementById('editRoleModal').classList.remove('hidden');
            document.getElementById('editRoleModal').classList.add('flex');
            checkEditForm();
        }

        function closeEditModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
            document.getElementById('editRoleModal').classList.remove('flex');
            // Reset form
            document.getElementById('editRoleId').value = '';
            document.getElementById('editRoleName').value = '';
            document.getElementById('editRoleDescription').value = '';
            checkEditForm();
        }

        function checkEditForm() {
            const nom = document.getElementById('editRoleName').value.trim();
            const description = document.getElementById('editRoleDescription').value.trim();
            const updateBtn = document.getElementById('updateRoleBtn');

            if (nom && description) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editRoleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        function openDeleteModal(id, nom) {
            document.getElementById('deleteRoleId').value = id;
            document.getElementById('deleteRoleName').textContent = nom;
            document.getElementById('deleteRoleForm').action = "{{ route('dashboard.deleteRole', ':id') }}".replace(':id', id);
            document.getElementById('deleteRoleModal').classList.remove('hidden');
            document.getElementById('deleteRoleModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteRoleModal').classList.add('hidden');
            document.getElementById('deleteRoleModal').classList.remove('flex');
            // Reset form
            document.getElementById('deleteRoleId').value = '';
            document.getElementById('deleteRoleName').textContent = '';
        }

        // Close delete modal when clicking outside
        document.getElementById('deleteRoleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
