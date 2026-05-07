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

    <form id="svEditForm" action="{{ route('services.update', $service) }}"
          method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}">
        </div>
        <div class="form-group">
            <label>En tête</label>
            <input type="text" name="header" value="{{ old('header', $service->header) }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="sv-desc" name="desc">{{ old('desc', $service->desc) }}</textarea>
        </div>
      
        <div class="form-group">
            <label>Prix</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}">
        </div>
        <div class="form-group">
            <label>Images</label>
            <label for="sv-img-input" class="custom-file-upload">Sélectionner des images</label>
            <input type="file" id="sv-img-input" name="imgs[]" multiple accept="image/*">
        </div>
        <div class="submit-btn">
            <button type="button" class="btn" onclick="submitSvForm()">Enregistrer les modifications</button>
        </div>
    </form>

    <div id="img-container">
        @foreach ($content as $img)
        @php $cleanPath = preg_replace('#^images/products/#', '', $img->path); @endphp
        <div class="img-item-db">
            <form action="{{ route('services.deleteImg', [$service, $img]) }}"
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
    let svDescEditor;
    ClassicEditor.create(document.querySelector('#sv-desc')).then(e => svDescEditor = e).catch(console.error);
    function submitSvForm() {
        document.getElementById('sv-desc').value = svDescEditor.getData();
        document.getElementById('svEditForm').submit();
    }
</script>

@endsection
