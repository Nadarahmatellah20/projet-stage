<head>
    <link rel="stylesheet" href="{{ URL::asset('style/prodstyle.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

@extends('admin.layouts.main')
@section('main-content')

{{-- HEADER --}}
<div class="index-header">
    <div class="search-bar">
        <form action="{{ route('softwares.index') }}" method="get">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
            <a href="{{ route('softwares.index') }}">Omettre</a>
        </form>
    </div>
    <button id="modalAddBtn">+ Ajouter</button>
</div>

{{-- MODAL --}}
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un logiciel</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="swStoreForm" action="{{ route('softwares.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="name-cat-container">
                    <input type="text" name="name" placeholder="Nom" required>
                    <input type="text" name="category" placeholder="Catégorie">
                </div>
                <input type="text" name="header" placeholder="Entête">
                <label>Description</label>
                <textarea id="sw-store-desc" name="desc"></textarea>
                <label>La fiche technique</label>
                              <textarea id="sv-store-desc" name="desc"></textarea>
                <label>Paiement</label>
                <select name="payment">
                    <option value="subscription">Abonnement</option>
                    <option value="one-time">Paiement Unique</option>
                </select>
                <input type="number" step="0.01" name="price" placeholder="Prix" min="0">
                <label class="custom-file-upload" for="sw-img-input">Sélectionner des images</label>
                <input type="file" id="sw-img-input" name="imgs[]" multiple accept="image/*">
                <button type="button" class="submit-btn" onclick="submitSwStore()">Ajouter</button>
            </form>
        </div>
    </div>
</div>

<script>
var modal = document.getElementById("myModal");
var btn   = document.getElementById("modalAddBtn");
var span  = document.getElementsByClassName("close")[0];
btn.onclick    = () => modal.style.display = "flex";
span.onclick   = () => modal.style.display = "none";
window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; };

let swDescEditor;
ClassicEditor.create(document.getElementById('sw-store-desc')).then(e => swDescEditor = e).catch(console.error);

function submitSwStore() {
    if (swDescEditor) document.getElementById('sw-store-desc').value = swDescEditor.getData();
    document.getElementById('swStoreForm').submit();
}
</script>

{{-- ALERTS --}}
@if (session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="error-box">
        @foreach ($errors->all() as $err)<p>{{ $err }}</p>@endforeach
    </div>
@endif

{{-- ITEMS --}}
<div class="items-container">
@if (($searching && $isFound) || (!$searching))
    @foreach ($softwares as $item)
    <div class="item">
        <div class="name-container">
            @php
                $firstImg = $item->prod_images->first();
                $cleanPath = $firstImg ? preg_replace('#^images/products/#', '', $firstImg->path) : null;
            @endphp
            <img src="{{ $cleanPath ? asset('images/products/'.$cleanPath) : asset('pre_assets/img/empty-img.png') }}">
        </div>
        <div class="desc">
            <p><a href="{{ route('swSiteShow', $item) }}" target="_blank">{{ $item->name }}</a></p>
            <p>{{ $item->header }}</p>
        </div>
        <div class="timestamps-container">
            <p>Ajouté: {{ $item->created_at->format('d/m/Y') }}</p>
            <p>MAJ: {{ $item->updated_at->format('d/m/Y') }}</p>
        </div>
        <div class="btn-container">
            <a href="{{ route('softwares.edit', $item) }}">Modifier</a>
            <form action="{{ route('softwares.destroy', $item) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce logiciel ?')">
                @csrf @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </div>
    </div>
    @endforeach
@else
    <p style="text-align:center;color:#64748b;padding:30px;">Aucun résultat trouvé.</p>
@endif
@if (($searching && $isFound) || (!$searching))
    <div class="pagination-container">{{ $softwares->links('vendor.pagination.default') }}</div>
@endif
</div>

@endsection
