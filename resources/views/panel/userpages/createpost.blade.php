@extends('panel.layouts.app')

@section('title')
    Gönderi Oluştur
@endsection

@section('content')

    <div class="feed">

        <div class="form-card">
            <h1 class="form-title">Yeni Gönderi</h1>
            <p class="form-note">Bir metin yaz, istersen fotoğraf ekle.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panel.user.createPost') }}" method="post" enctype="multipart/form-data" class="create-post-form">
                @csrf

                <textarea name="content" class="post-textarea" rows="4" placeholder="Ne düşünüyorsun?">{{ old('content') }}</textarea>
                @error('content')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <label class="file-input-wrap">
                    <input type="file" name="images[]" class="file-input" accept="image/*" multiple>
                    <span class="file-input-label">
                        <i class="bi bi-image"></i>
                        Fotoğraf ekle
                    </span>
                </label>
                @error('images.*')
                <div class="field-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="create-post-submit">Paylaş</button>
            </form>
        </div>

    </div>

@endsection
