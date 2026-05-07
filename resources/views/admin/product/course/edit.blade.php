@extends('admin.layouts.main')
@section('main-content')

<head>
    <link rel="stylesheet" href="{{ URL::asset('style/edit-prod-style.css') }}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js') }}"></script>
</head>

<div class="form-container edit">

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="crEditForm" action="{{ route('courses.update', $course) }}"
          method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $course->name) }}">
        </div>
        <div class="form-group">
            <label>Catégorie</label>
            <input type="text" name="category" value="{{ old('category', $course->category) }}">
        </div>
        <div class="form-group">
            <label>En tête</label>
            <input type="text" name="header" value="{{ old('header', $course->header) }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="cr-desc" name="desc">{{ old('desc', $course->desc) }}</textarea>
        </div>
        <div class="form-group">
            <label>Prof</label>
            <input type="text" name="prof" value="{{ old('prof', $course->prof) }}">
        </div>
        <div class="form-group">
            <label>Période</label>
            <input type="text" name="period" value="{{ old('period', $course->period) }}">
        </div>
        <div class="form-group">
            <label>Prix</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}">
        </div>
        <div class="form-group">
            <label>Images</label>
            <label for="cr-img-input" class="custom-file-upload">Sélectionner des images</label>
            <input type="file" id="cr-img-input" name="imgs[]" multiple accept="image/*"
                   onchange="previewCrImages(this)">
        </div>

        <div id="cr-preview-container" class="preview-container"></div>

        <div class="submit-btn">
            <button type="button" class="btn" onclick="submitCrForm()">Enregistrer les modifications</button>
        </div>
    </form>

    <div id="img-container">
        @foreach ($content as $img)
        <div class="img-item-db">
            <form action="{{ route('courses.deleteImg', [$course, $img]) }}"
                  method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                @csrf @method('DELETE')
                <button type="submit" class="delete-hover">✖</button>
            </form>
            <img src="{{ asset('images/' . $img->path) }}" alt="image">
        </div>
        @endforeach
    </div>

</div>

<script>
    let crDescEditor;
    ClassicEditor.create(document.querySelector('#cr-desc'))
        .then(e => crDescEditor = e)
        .catch(console.error);

    function submitCrForm() {
        document.getElementById('cr-desc').value = crDescEditor.getData();
        document.getElementById('crEditForm').submit();
    }

    function previewCrImages(input) {
        const container = document.getElementById('cr-preview-container');
        container.innerHTML = '';
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

@endsection