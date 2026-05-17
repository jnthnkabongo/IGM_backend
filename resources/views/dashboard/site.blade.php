@extends('dashboard.entete')

@section('content')
    <div class="space-y-8">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-map-marker-alt text-blue-600"></i>
                Liste des sites miniers
            </h1>
            <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Ajouter site
            </button>
        </div>
        <!-- Barre de recherche -->
        <div class="bg-white rounded-xl shadow-lg p-2">
            <div class="flex items-center gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher un site..." class="w-full pl-12 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Rechercher</button>
            </div>
        </div>

        <!-- Tableau des sites miniers -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i>
                    Liste des sites miniers
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
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Province</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Territoire</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Responsable</th>
                            <th class="px-4 py-2 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sites as $site)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                                        <span class="text-white font-bold text-lg">{{ $site->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium font-mono text-sm">{{ $site->code }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $site->code }}" alt="QR Code" class="w-10 h-10 cursor-pointer" onclick="window.open(this.src, '_blank')">
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $site->nom }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $site->province }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700 font-medium">{{ $site->territoire }}</span>
                            </td>
                            <td class="px-4 py-2">
                                @if($site->responsable)
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                    {{ $site->responsable->name }}
                                </span>
                                @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-gray-200 text-gray-700 shadow-sm">
                                    Non assigné
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-3">
                                    <button onclick="openEditModal({{ $site->id }}, '{{ $site->nom }}', '{{ $site->province }}', '{{ $site->territoire }}', '{{ $site->latitude ?? '' }}', '{{ $site->longitude ?? '' }}', {{ $site->concession_id ?? 'null' }}, {{ $site->responsable_id ?? 'null' }})" class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $site->id }}, '{{ $site->nom }}')" class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm" title="Supprimer">
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
                                        <i class="fas fa-map-marker-alt text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun site trouvé</p>
                                    <p class="text-gray-400 text-sm mt-1">Commencez par ajouter un nouveau site</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de site -->
    <div id="siteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i>
                    Ajouter un site minier
                </h3>
            </div>
            <form action="{{ route('dashboard.saveSite') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="siteNom" placeholder="Nom du site" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                        <input type="text" name="province" id="siteProvince" placeholder="Province" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Territoire</label>
                        <input type="text" name="territoire" id="siteTerritoire" placeholder="Territoire" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" id="siteLatitude" placeholder="Latitude" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" id="siteLongitude" placeholder="Longitude" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Concession</label>
                        <select name="concession_id" id="siteConcessionId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                            <option value="">Sélectionner une concession</option>
                            @foreach($concessions ?? [] as $concession)
                            <option value="{{ $concession->id }}">{{ $concession->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                        <select name="responsable_id" id="siteResponsableId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkForm()">
                            <option value="">Sélectionner un responsable</option>
                            @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveSiteBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification de site -->
    <div id="editSiteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Modifier un site minier
                </h3>
            </div>
            <form action="" method="POST" class="p-6" id="editSiteForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editSiteId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" name="nom" id="editSiteNom" placeholder="Nom du site" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                        <input type="text" name="province" id="editSiteProvince" placeholder="Province" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Territoire</label>
                        <input type="text" name="territoire" id="editSiteTerritoire" placeholder="Territoire" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" id="editSiteLatitude" placeholder="Latitude" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" id="editSiteLongitude" placeholder="Longitude" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Concession</label>
                        <select name="concession_id" id="editSiteConcessionId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                            <option value="">Sélectionner une concession</option>
                            @foreach($concessions ?? [] as $concession)
                            <option value="{{ $concession->id }}">{{ $concession->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                        <select name="responsable_id" id="editSiteResponsableId" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" oninput="checkEditForm()">
                            <option value="">Sélectionner un responsable</option>
                            @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="updateSiteBtn" disabled class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteSiteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirmer la suppression
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir supprimer le site <strong id="deleteSiteName" class="text-red-600"></strong> ?
                </p>
                <p class="text-gray-500 text-sm mb-6">
                    Cette action est irréversible.
                </p>
                <form action="" method="POST" id="deleteSiteForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="deleteSiteId">
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
            document.getElementById('siteModal').classList.remove('hidden');
            document.getElementById('siteModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('siteModal').classList.add('hidden');
            document.getElementById('siteModal').classList.remove('flex');
            // Reset form
            document.getElementById('siteNom').value = '';
            document.getElementById('siteProvince').value = '';
            document.getElementById('siteTerritoire').value = '';
            document.getElementById('siteLatitude').value = '';
            document.getElementById('siteLongitude').value = '';
            document.getElementById('siteConcessionId').value = '';
            document.getElementById('siteResponsableId').value = '';
            checkForm();
        }

        function checkForm() {
            const nom = document.getElementById('siteNom').value.trim();
            const province = document.getElementById('siteProvince').value.trim();
            const territoire = document.getElementById('siteTerritoire').value.trim();
            const latitude = document.getElementById('siteLatitude').value.trim();
            const longitude = document.getElementById('siteLongitude').value.trim();
            const concessionId = document.getElementById('siteConcessionId').value;
            const responsableId = document.getElementById('siteResponsableId').value;
            const saveBtn = document.getElementById('saveSiteBtn');

            if (nom && province && territoire && latitude && longitude && concessionId && responsableId) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }

        // Close modal when clicking outside
        document.getElementById('siteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function openEditModal(id, nom, province, territoire, latitude, longitude, concessionId, responsableId) {
            document.getElementById('editSiteId').value = id;
            document.getElementById('editSiteNom').value = nom;
            document.getElementById('editSiteProvince').value = province;
            document.getElementById('editSiteTerritoire').value = territoire;
            document.getElementById('editSiteLatitude').value = latitude || '';
            document.getElementById('editSiteLongitude').value = longitude || '';
            document.getElementById('editSiteConcessionId').value = concessionId || '';
            document.getElementById('editSiteResponsableId').value = responsableId || '';
            document.getElementById('editSiteForm').action = "{{ route('dashboard.updateSite', ':id') }}".replace(':id', id);
            document.getElementById('editSiteModal').classList.remove('hidden');
            document.getElementById('editSiteModal').classList.add('flex');
            checkEditForm();
        }

        function closeEditModal() {
            document.getElementById('editSiteModal').classList.add('hidden');
            document.getElementById('editSiteModal').classList.remove('flex');
            // Reset form
            document.getElementById('editSiteId').value = '';
            document.getElementById('editSiteNom').value = '';
            document.getElementById('editSiteProvince').value = '';
            document.getElementById('editSiteTerritoire').value = '';
            document.getElementById('editSiteLatitude').value = '';
            document.getElementById('editSiteLongitude').value = '';
            document.getElementById('editSiteConcessionId').value = '';
            document.getElementById('editSiteResponsableId').value = '';
            checkEditForm();
        }

        function checkEditForm() {
            const nom = document.getElementById('editSiteNom').value.trim();
            const province = document.getElementById('editSiteProvince').value.trim();
            const territoire = document.getElementById('editSiteTerritoire').value.trim();
            const latitude = document.getElementById('editSiteLatitude').value.trim();
            const longitude = document.getElementById('editSiteLongitude').value.trim();
            const concessionId = document.getElementById('editSiteConcessionId').value;
            const responsableId = document.getElementById('editSiteResponsableId').value;
            const updateBtn = document.getElementById('updateSiteBtn');

            if (nom && province && territoire && latitude && longitude && concessionId && responsableId) {
                updateBtn.disabled = false;
            } else {
                updateBtn.disabled = true;
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editSiteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        function openDeleteModal(id, nom) {
            document.getElementById('deleteSiteId').value = id;
            document.getElementById('deleteSiteName').textContent = nom;
            document.getElementById('deleteSiteForm').action = "{{ route('dashboard.deleteSite', ':id') }}".replace(':id', id);
            document.getElementById('deleteSiteModal').classList.remove('hidden');
            document.getElementById('deleteSiteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteSiteModal').classList.add('hidden');
            document.getElementById('deleteSiteModal').classList.remove('flex');
            // Reset form
            document.getElementById('deleteSiteId').value = '';
            document.getElementById('deleteSiteName').textContent = '';
        }

        // Close delete modal when clicking outside
        document.getElementById('deleteSiteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection