@extends('dashboard.entete')

@section('content')
    <div class="space-y-8">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-gem text-blue-600"></i>
                Liste des minerais
            </h1>
            <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter minerai
            </button>
        </div>
        <!-- Barre de recherche -->
        <div class="bg-white rounded-xl shadow-lg p-2">
            <div class="flex items-center gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher un minerai..." class="w-full pl-12 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Rechercher</button>
            </div>
        </div>

        <!-- Tableau des minerais -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-gem"></i>
                    Liste des minerais
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Code</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">QR Code</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Unité</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Prix référence</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Site</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">État</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($mines as $mine)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                        <span class="text-white font-bold text-lg">{{ $mine->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium font-mono text-sm">{{ $mine->code }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $mine->code }}" alt="QR Code" class="w-10 h-10 cursor-pointer" onclick="window.open(this.src, '_blank')">
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $mine->nom }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                    {{ $mine->unite }}/Kg
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ number_format($mine->prix_reference, 2) }} Fc</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($mine->siteMinier)
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-green-500 to-green-600 text-white shadow-sm">
                                    {{ $mine->siteMinier->nom }}
                                </span>
                                @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gray-200 text-gray-700 shadow-sm">
                                    Non assigné
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-{{ $mine->etat_minerai == 'En_cours' ? 'blue' : 'red' }}-500 to-{{ $mine->etat_minerai == 'En_cours' ? 'blue' : 'red' }}-600 text-white shadow-sm">
                                    {{ $mine->etat_minerai }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-3">
                                    <button onclick="openEditModal({{ $mine->id }}, '{{ $mine->nom }}', '{{ $mine->unite }}', {{ $mine->prix_reference }}, {{ $mine->site_minier_id ?? 'null' }})" class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $mine->id }}, '{{ $mine->nom }}')" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Supprimer">
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
                                        <i class="fas fa-gem text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun minerai trouvé</p>
                                    <p class="text-gray-400 text-sm mt-1">Commencez par ajouter un nouveau minerai</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de minerai -->
    <div id="mineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-gem"></i>
                    Ajouter un minerai
                </h3>
            </div>
            <form action="{{ route('dashboard.saveMine') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="mineNom" placeholder="Nom du minerai" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unité</label>
                        <input type="text" name="unite" id="mineUnite" placeholder="Ex: kg, tonne" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix référence</label>
                        <input type="number" step="0.01" name="prix_reference" id="minePrix" placeholder="Prix de référence" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site</label>
                        <select name="site_minier_id" id="mineSiteId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                            <option value="">Sélectionner un site</option>
                            @foreach($sites ?? [] as $site)
                            <option value="{{ $site->id }}">{{ $site->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveMineBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification de minerai -->
    <div id="editMineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Modifier un minerai
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="editMineForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editMineId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="editMineNom" placeholder="Nom du minerai" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unité</label>
                        <input type="text" name="unite" id="editMineUnite" placeholder="Ex: kg, tonne" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix référence</label>
                        <input type="number" step="0.01" name="prix_reference" id="editMinePrix" placeholder="Prix de référence" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site</label>
                        <select name="site_minier_id" id="editMineSiteId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                            <option value="">Sélectionner un site</option>
                            @foreach($sites ?? [] as $site)
                            <option value="{{ $site->id }}">{{ $site->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="updateMineBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteMineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirmer la suppression
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir supprimer le minerai <strong id="deleteMineName" class="text-red-600"></strong> ?
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Cette action est irréversible.
                </p>
                <form action="" method="POST" id="deleteMineForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteMineId">
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
            document.getElementById('mineModal').classList.remove('hidden');
            document.getElementById('mineModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('mineModal').classList.add('hidden');
            document.getElementById('mineModal').classList.remove('flex');
            // Reset form
            document.getElementById('mineNom').value = '';
            document.getElementById('mineUnite').value = '';
            document.getElementById('minePrix').value = '';
            document.getElementById('mineSiteId').value = '';
            checkForm();
        }

        function checkForm() {
            const nom = document.getElementById('mineNom').value.trim();
            const unite = document.getElementById('mineUnite').value.trim();
            const prix = document.getElementById('minePrix').value.trim();
            const siteId = document.getElementById('mineSiteId').value;
            const saveBtn = document.getElementById('saveMineBtn');

            if (nom && unite && prix && siteId) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('mineModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function openEditModal(id, nom, unite, prix, siteId) {
            document.getElementById('editMineId').value = id;
            document.getElementById('editMineNom').value = nom;
            document.getElementById('editMineUnite').value = unite;
            document.getElementById('editMinePrix').value = prix;
            document.getElementById('editMineSiteId').value = siteId || '';
            document.getElementById('editMineForm').action = "{{ route('dashboard.updateMine', ':id') }}".replace(':id', id);
            document.getElementById('editMineModal').classList.remove('hidden');
            document.getElementById('editMineModal').classList.add('flex');
            checkEditForm();
        }

        function closeEditModal() {
            document.getElementById('editMineModal').classList.add('hidden');
            document.getElementById('editMineModal').classList.remove('flex');
            // Reset form
            document.getElementById('editMineId').value = '';
            document.getElementById('editMineNom').value = '';
            document.getElementById('editMineUnite').value = '';
            document.getElementById('editMinePrix').value = '';
            document.getElementById('editMineSiteId').value = '';
            checkEditForm();
        }

        function checkEditForm() {
            const nom = document.getElementById('editMineNom').value.trim();
            const unite = document.getElementById('editMineUnite').value.trim();
            const prix = document.getElementById('editMinePrix').value.trim();
            const siteId = document.getElementById('editMineSiteId').value;
            const updateBtn = document.getElementById('updateMineBtn');

            if (nom && unite && prix && siteId) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editMineModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        function openDeleteModal(id, nom) {
            document.getElementById('deleteMineId').value = id;
            document.getElementById('deleteMineName').textContent = nom;
            document.getElementById('deleteMineForm').action = "{{ route('dashboard.deleteMine', ':id') }}".replace(':id', id);
            document.getElementById('deleteMineModal').classList.remove('hidden');
            document.getElementById('deleteMineModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteMineModal').classList.add('hidden');
            document.getElementById('deleteMineModal').classList.remove('flex');
            // Reset form
            document.getElementById('deleteMineId').value = '';
            document.getElementById('deleteMineName').textContent = '';
        }

        // Close delete modal when clicking outside
        document.getElementById('deleteMineModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection