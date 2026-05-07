@extends('admin.layouts.main')
@section('main-content')

<head>
    <link rel="stylesheet" href="{{ URL::asset('style/edit-prod-style.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

<div class="form-container edit">

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="swEditForm" action="{{ route('softwares.update', $software->id) }}"
          method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $software->name) }}">
        </div>
        <div class="form-group">
            <label>En tête</label>
            <input type="text" name="header" value="{{ old('header', $software->header) }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="sw-desc" name="desc">{{ old('desc', $software->desc) }}</textarea>
        </div>
         <div class="form-group">
            <label>Fiche technique</label>
            <textarea id="sw-datasheet" name="datasheet">
                {{ old('datasheet', $software->datasheet) }}
            </textarea>
        </div>
        <div class="form-group">
            <label>Catégorie</label>
            <input type="text" name="category" value="{{ old('category', $software->category) }}">
        </div>
        <div class="form-group">
            <label>Prix</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $software->price) }}">
        </div>
        <div class="form-group">
            <label>Paiement</label>
            <select name="payment">
                <option value="subscription" {{ old('payment', $software->payment) == 'subscription' ? 'selected' : '' }}>Abonnement</option>
                <option value="one-time"     {{ old('payment', $software->payment) == 'one-time'     ? 'selected' : '' }}>Paiement Unique</option>
            </select>
        </div>
        <div class="form-group">
            <label>Images</label>
            <label for="sw-img-input" class="custom-file-upload">Sélectionner des images</label>
            <input type="file" id="sw-img-input" name="imgs[]" multiple accept="image/*">
        </div>
        <div class="submit-btn">
            <button type="button" class="btn" onclick="submitSwForm()">Enregistrer les modifications</button>
        </div>
    </form>

    <div id="img-container">
        @foreach ($content as $img)
        @php $cleanPath = preg_replace('#^images/products/#', '', $img->path); @endphp
        <div class="img-item-db">
            <form action="{{ route('swdeleteImg', ['software' => $software->id, 'img' => $img->id]) }}"
                  method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                @csrf @method('DELETE')
                <button type="submit" class="delete-hover">✖</button>
            </form>
            <img src="{{ asset('images/products/' . $cleanPath) }}">
        </div>
        @endforeach
    </div>

</div>

<script>
    let swDescEditor;
    ClassicEditor.create(document.querySelector('#sw-desc')).then(e => swDescEditor = e).catch(console.error);
    function submitSwForm() {
        document.getElementById('sw-desc').value = swDescEditor.getData();
        document.getElementById('swEditForm').submit();
    }
</script>

@endsection
