<head>
    <link rel="stylesheet" href="{{ URL::asset('style/prodstyle.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

@extends('admin.layouts.main')

@section('main-content')

<div class="index-header">
    <div class="search-bar">
        <form action="{{ route('hardwares.index') }}" method="get">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
            <a href="{{ route('hardwares.index') }}">Omettre</a>
        </form>
    </div>

    <button id="modalAddBtn">Ajouter</button>
</div>

{{-- MODAL --}}
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Ajouter un produit</h2>
        </div>

        <div class="modal-body">
            <form id="hwStoreForm" action="{{ route('hardwares.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="name-cat-container">
                    <input type="text" name="name" placeholder="Nom" required>
                    <input type="text" name="category" placeholder="Catégorie">
                </div>

                <input type="text" name="header" placeholder="Entête">

                <label>Description</label>
                <textarea id="hw-store-desc" name="desc"></textarea>

                <label>Fiche technique</label>
                <textarea id="hw-store-datasheet" name="datasheet"></textarea>

              

                <input type="number" step="0.01" name="price" placeholder="Prix" min="0">

                <label class="custom-file-upload" for="hw-img-input">
                    Sélectionner des images
                </label>

                <input type="file" name="imgs[]" multiple>
                <input type="file" id="hw-img-input" name="imgs[]" multiple accept="image/*" style="display:none">

                <button type="button" class="submit-btn" onclick="submitHwStore()">Ajouter</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL + CKEDITOR SCRIPT --}}
<script>
    const modal    = document.getElementById('myModal');
    const openBtn  = document.getElementById('modalAddBtn');
    const closeBtn = document.querySelector('.close');

    openBtn.addEventListener('click', () => modal.style.display = 'flex');
    closeBtn.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });

    let hwDescEditor, hwDatasheetEditor;

    ClassicEditor.create(document.getElementById('hw-store-desc'))
        .then(e => hwDescEditor = e)
        .catch(console.error);

    ClassicEditor.create(document.getElementById('hw-store-datasheet'))
        .then(e => hwDatasheetEditor = e)
        .catch(console.error);

    function submitHwStore() {
        if (hwDescEditor)      document.getElementById('hw-store-desc').value      = hwDescEditor.getData();
        if (hwDatasheetEditor) document.getElementById('hw-store-datasheet').value = hwDatasheetEditor.getData();
        document.getElementById('hwStoreForm').submit();
    }
</script>

{{-- ERRORS --}}
@if ($errors->any())
    <div class="error-box">
        @foreach ($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

{{-- SUCCESS --}}
@if (session('success'))
    <div class="success-box">{{ session('success') }}</div>
@endif

{{-- ITEMS --}}
<div class="items-container">

    @foreach ($hardwares as $hItem)
        <div class="item">

            <div class="name-container">
                @php $firstImg = $hItem->prod_images()->first(); @endphp

                @if($firstImg && $firstImg->path)
                    <img src="{{ asset('images/products/' . $firstImg->path) }}" alt="{{ $hItem->name }}">
                @else
                    <img src="{{ asset('pre_assets/img/empty-img.png') }}" alt="no image">
                @endif
            </div>

            <div class="desc">
                <p>{{ $hItem->name }}</p>
                <p>{{ $hItem->header }}</p>
            </div>

            <div class="timestamps-container">
                <p>{{ $hItem->created_at }}</p>
                <p>{{ $hItem->updated_at }}</p>
            </div>

            <div class="btn-container">
                <a href="{{ route('hardwares.edit', $hItem) }}">Modifier</a>

                <form action="{{ route('hardwares.destroy', $hItem) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce produit ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </div>

        </div>
    @endforeach

</div>

{{-- PAGINATION --}}
<div class="pagination-container">
    {{ $hardwares->links('pagination::bootstrap-5') }}
</div>

@endsection