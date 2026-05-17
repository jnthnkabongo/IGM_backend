@extends('dashboard.entete')

@section('content')
    <div class="space-y-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-map text-blue-600"></i>
                Liste des concessions minieres
            </h1>
            <button onclick="openModal()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter une concession
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <div class="flex gap-4 items-center">
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Rechercher une concession..." class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Code</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Numéro cadastre</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Superficie</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Propriétaire</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($concessions as $concession)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                        <span class="text-white font-bold text-lg">{{ $concession->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium font-mono text-sm">{{ $concession->code }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $concession->nom }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $concession->numero_cadastre }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                                    {{ $concession->superficie }} ha
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $concession->proprietaire }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-3">
                                    <button onclick="openEditModal({{ $concession->id }}, '{{ $concession->nom }}', '{{ $concession->numero_cadastre }}', '{{ $concession->superficie }}', '{{ $concession->proprietaire }}')" class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $concession->id }}, '{{ $concession->nom }}')" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Supprimer">
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
                                        <i class="fas fa-map text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucune concession trouvée</p>
                                    <p class="text-gray-400 text-sm mt-1">Commencez par ajouter une nouvelle concession</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de concession -->
    <div id="concessionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Ajouter une concession
                </h3>
            </div>
            <form action="{{ route('dashboard.saveConcession') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="concessionNom" placeholder="Nom de la concession" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro cadastre</label>
                        <input type="text" name="numero_cadastre" id="concessionNumeroCadastre" placeholder="Numéro de cadastre" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Superficie (ha)</label>
                        <input type="number" step="0.01" name="superficie" id="concessionSuperficie" placeholder="Superficie en hectares" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Propriétaire</label>
                        <input type="text" name="proprietaire" id="concessionProprietaire" placeholder="Nom du propriétaire" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveConcessionBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification de concession -->
    <div id="editConcessionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Modifier une concession
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="editConcessionForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editConcessionId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="editConcessionNom" placeholder="Nom de la concession" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro cadastre</label>
                        <input type="text" name="numero_cadastre" id="editConcessionNumeroCadastre" placeholder="Numéro de cadastre" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Superficie (ha)</label>
                        <input type="number" step="0.01" name="superficie" id="editConcessionSuperficie" placeholder="Superficie en hectares" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Propriétaire</label>
                        <input type="text" name="proprietaire" id="editConcessionProprietaire" placeholder="Nom du propriétaire" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="updateConcessionBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de suppression de concession -->
    <div id="deleteConcessionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    Supprimer une concession
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="deleteConcessionForm">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteConcessionId">
                <div class="space-y-4">
                    <p class="text-gray-700">Êtes-vous sûr de vouloir supprimer la concession <span class="font-bold text-red-600" id="deleteConcessionName"></span> ?</p>
                    <p class="text-sm text-gray-500">Cette action est irréversible.</p>
                </div>
                <div class="flex justify-end gap-3 mt-6">
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

    <script>
        function openModal() {
            document.getElementById('concessionModal').classList.remove('hidden');
            document.getElementById('concessionModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('concessionModal').classList.add('hidden');
            document.getElementById('concessionModal').classList.remove('flex');
            // Reset form
            document.getElementById('concessionNom').value = '';
            document.getElementById('concessionNumeroCadastre').value = '';
            document.getElementById('concessionSuperficie').value = '';
            document.getElementById('concessionProprietaire').value = '';
            checkForm();
        }

        function checkForm() {
            const nom = document.getElementById('concessionNom').value.trim();
            const numeroCadastre = document.getElementById('concessionNumeroCadastre').value.trim();
            const superficie = document.getElementById('concessionSuperficie').value.trim();
            const proprietaire = document.getElementById('concessionProprietaire').value.trim();
            const saveBtn = document.getElementById('saveConcessionBtn');

            if (nom && numeroCadastre && superficie && proprietaire) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('concessionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function openEditModal(id, nom, numeroCadastre, superficie, proprietaire) {
            document.getElementById('editConcessionId').value = id;
            document.getElementById('editConcessionNom').value = nom;
            document.getElementById('editConcessionNumeroCadastre').value = numeroCadastre;
            document.getElementById('editConcessionSuperficie').value = superficie;
            document.getElementById('editConcessionProprietaire').value = proprietaire;
            document.getElementById('editConcessionForm').action = "{{ route('dashboard.updateConcession', ':id') }}".replace(':id', id);
            document.getElementById('editConcessionModal').classList.remove('hidden');
            document.getElementById('editConcessionModal').classList.add('flex');
            checkEditForm();
        }

        function closeEditModal() {
            document.getElementById('editConcessionModal').classList.add('hidden');
            document.getElementById('editConcessionModal').classList.remove('flex');
            // Reset form
            document.getElementById('editConcessionId').value = '';
            document.getElementById('editConcessionNom').value = '';
            document.getElementById('editConcessionNumeroCadastre').value = '';
            document.getElementById('editConcessionSuperficie').value = '';
            document.getElementById('editConcessionProprietaire').value = '';
            checkEditForm();
        }

        function checkEditForm() {
            const nom = document.getElementById('editConcessionNom').value.trim();
            const numeroCadastre = document.getElementById('editConcessionNumeroCadastre').value.trim();
            const superficie = document.getElementById('editConcessionSuperficie').value.trim();
            const proprietaire = document.getElementById('editConcessionProprietaire').value.trim();
            const updateBtn = document.getElementById('updateConcessionBtn');

            if (nom && numeroCadastre && superficie && proprietaire) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editConcessionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        function openDeleteModal(id, nom) {
            document.getElementById('deleteConcessionId').value = id;
            document.getElementById('deleteConcessionName').textContent = nom;
            document.getElementById('deleteConcessionForm').action = "{{ route('dashboard.deleteConcession', ':id') }}".replace(':id', id);
            document.getElementById('deleteConcessionModal').classList.remove('hidden');
            document.getElementById('deleteConcessionModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteConcessionModal').classList.add('hidden');
            document.getElementById('deleteConcessionModal').classList.remove('flex');
        }

        // Close delete modal when clicking outside
        document.getElementById('deleteConcessionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection