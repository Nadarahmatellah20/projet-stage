<head>
    <link rel="stylesheet" href="{{ URL::asset('style/prodstyle.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

@extends('admin.layouts.main')
@section('main-content')

{{-- HEADER --}}
<div class="index-header">
    <div class="search-bar">
        <form action="{{ route('services.index') }}" method="get">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
            <a href="{{ route('services.index') }}">Omettre</a>
        </form>
    </div>
    <button id="modalAddBtn">+ Ajouter</button>
</div>

{{-- MODAL --}}
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un service</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="svStoreForm" action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Nom" required>
                <input type="text" name="header" placeholder="Entête">
                <label>Description</label>
                <textarea id="sv-store-desc" name="desc"></textarea>
           <input type="number" step="0.01" name="price" placeholder="Prix" min="0">        
                <label class="custom-file-upload" for="sv-img-input">Sélectionner des images</label>
                <input type="file" id="sv-img-input" name="imgs[]" multiple accept="image/*">
                <button type="button" class="submit-btn" onclick="submitSvStore()">Ajouter</button>
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

// Tab indent in HTML editor
document.getElementById('htmlEditor').addEventListener('keydown', e => {
    if (e.key === 'Tab') {
        e.preventDefault();
        const s = e.target.selectionStart;
        e.target.value = e.target.value.substring(0, s) + '\t' + e.target.value.substring(e.target.selectionEnd);
        e.target.selectionStart = e.target.selectionEnd = s + 1;
    }
});

let svDescEditor;
ClassicEditor.create(document.getElementById('sv-store-desc')).then(e => svDescEditor = e).catch(console.error);

function submitSvStore() {
    if (svDescEditor) document.getElementById('sv-store-desc').value = svDescEditor.getData();
    document.getElementById('svStoreForm').submit();
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
    @foreach ($services as $item)
    <div class="item">
        <div class="name-container">
            @php
                $firstImg = $item->prod_images->first();
                $cleanPath = $firstImg ? preg_replace('#^images/products/#', '', $firstImg->path) : null;
            @endphp
            <img src="{{ $cleanPath ? asset('images/products/'.$cleanPath) : asset('pre_assets/img/empty-img.png') }}">
        </div>
        <div class="desc">
            <p><a href="{{ route('svSiteShow', $item) }}" target="_blank">{{ $item->name }}</a></p>
            <p>{{ $item->header }}</p>
        </div>
        <div class="timestamps-container">
            <p>Ajouté: {{ $item->created_at->format('d/m/Y') }}</p>
            <p>MAJ: {{ $item->updated_at->format('d/m/Y') }}</p>
        </div>
        <div class="btn-container">
            <a href="{{ route('services.edit', $item) }}">Modifier</a>
            <form action="{{ route('services.destroy', $item) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce service ?')">
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
    <div class="pagination-container">{{ $services->links('vendor.pagination.default') }}</div>
@endif
</div>

@endsection
