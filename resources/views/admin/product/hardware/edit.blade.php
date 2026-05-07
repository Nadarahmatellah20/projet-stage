@extends('admin.layouts.main')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{ URL::asset('style/edit-prod-style.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

<div class="form-container edit">

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <form id="hwEditForm"
          action="{{ route('hardwares.update', $hardware) }}"
          method="POST"
          enctype="multipart/form-data"
          class="edit-form">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name"
                   value="{{ old('name', $hardware->name) }}">
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <input type="text" name="category"
                   value="{{ old('category', $hardware->category) }}">
        </div>

        <div class="form-group">
            <label>En tête</label>
            <input type="text" name="header"
                   value="{{ old('header', $hardware->header) }}">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea id="hw-desc" name="desc">
                {{ old('desc', $hardware->desc) }}
            </textarea>
        </div>

        <div class="form-group">
            <label>Fiche technique</label>
            <textarea id="hw-datasheet" name="datasheet">
                {{ old('datasheet', $hardware->datasheet) }}
            </textarea>
        </div>

        <div class="form-group">
            <label>Prix</label>
            <input type="number" step="0.01" name="price"
                   min="0"
                   value="{{ old('price', $hardware->price) }}">
        </div>

        <div class="form-group">
            <label>Images</label>
            <label for="hw-img-input" class="custom-file-upload">
                Sélectionner des images
            </label>
            <input type="file" id="hw-img-input" name="imgs[]" multiple accept="image/*">
        </div>

        {{-- BUTTON --}}
        <div class="submit-btn">
            <button type="button" class="btn" onclick="submitHwForm()">
                Enregistrer les modifications
            </button>
        </div>
    </form>

    {{-- IMAGES --}}
    <div id="img-container">

        @foreach ($content as $img)
        @php
            $cleanPath = preg_replace('#^images/products/#', '', $img->path);
        @endphp
        <div class="img-item-db" id="img-div-{{ $img->id }}">

            <form action="{{ route('hwdeleteImg', compact('hardware','img')) }}"
                  method="POST"
                  onsubmit="return confirm('Supprimer cette image ?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="delete-hover">
                    ✖
                </button>
            </form>

            <img src="{{ asset('images/products/' . $cleanPath) }}">
        </div>
        @endforeach

    </div>

</div>

{{-- CKEDITOR --}}
<script>
    let hwDescEditor, hwDatasheetEditor;

    ClassicEditor.create(document.querySelector('#hw-desc'))
        .then(editor => hwDescEditor = editor)
        .catch(console.error);

    ClassicEditor.create(document.querySelector('#hw-datasheet'))
        .then(editor => hwDatasheetEditor = editor)
        .catch(console.error);

    function submitHwForm() {
        document.getElementById('hw-desc').value = hwDescEditor.getData();
        document.getElementById('hw-datasheet').value = hwDatasheetEditor.getData();
        document.getElementById('hwEditForm').submit();
    }
</script>

@endsection
