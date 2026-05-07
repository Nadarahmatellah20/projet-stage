<head>
    <link rel="stylesheet" href="{{ URL::asset('style/prodstyle.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

@extends('admin.layouts.main')
@section('main-content')

{{-- HEADER --}}
<div class="index-header">
    <div class="search-bar">
        <form action="{{ route('courses.index') }}" method="get">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
            <a href="{{ route('courses.index') }}">Omettre</a>
        </form>
    </div>
    <button id="modalAddBtn">+ Ajouter</button>
</div>

{{-- MODAL --}}
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter une formation</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="crStoreForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="name-cat-container">
                    <input type="text" name="name" placeholder="Nom" required>
                    <input type="text" name="category" placeholder="Catégorie">
                </div>
                <input type="text" name="header" placeholder="Entête">
                <label>Description</label>
                <textarea id="cr-store-desc" name="desc"></textarea>
                <div class="name-cat-container">
                    <input type="text" name="prof" placeholder="Professeur">
                    <input type="text" name="period" placeholder="Durée (ex: 2 mois)">
                </div>
                <input type="number" step="0.01" name="price" placeholder="Prix" min="0">
                <label class="custom-file-upload" for="cr-img-input">Sélectionner des images</label>
                <input type="file" id="cr-img-input" name="imgs[]" multiple accept="image/*">
                <button type="button" class="submit-btn" onclick="submitCrStore()">Ajouter</button>
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

let crDescEditor;
ClassicEditor.create(document.getElementById('cr-store-desc'))
    .then(e => crDescEditor = e)
    .catch(console.error);

function submitCrStore() {
    if (crDescEditor) document.getElementById('cr-store-desc').value = crDescEditor.getData();
    document.getElementById('crStoreForm').submit();
}
</script>

{{-- ALERTS --}}
@if (session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="error-box">
        @foreach ($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

{{-- ITEMS --}}
<div class="items-container">

    @if (isset($searching) && $searching && isset($isFound) && !$isFound)
        <p style="padding:1rem;">Aucun résultat trouvé.</p>

    @elseif (isset($courses))
        @foreach ($courses as $item)
        <div class="item">
            <div class="name-container">
                @php
                    $firstImg = $item->prod_images->first();
                @endphp
                <img src="{{ $firstImg ? asset('images/' . $firstImg->path) : asset('pre_assets/img/empty-img.png') }}"
                     alt="{{ $item->name }}">
            </div>
            <div class="desc">
                <p>{{ $item->name }}</p>
                <p>{{ $item->header }}</p>
            </div>
            <div class="timestamps-container">
                <p>Ajouté: {{ $item->created_at->format('d/m/Y') }}</p>
                <p>MAJ: {{ $item->updated_at->format('d/m/Y') }}</p>
            </div>
            <div class="btn-container">
                <a href="{{ route('courses.edit', $item) }}">Modifier</a>
                <form action="{{ route('courses.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Supprimer cette formation ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        </div>
        @endforeach

        <div class="pagination-container">
            {{ $courses->links('vendor.pagination.default') }}
        </div>
    @endif

</div>

@endsection