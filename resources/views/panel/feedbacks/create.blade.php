@extends('panel.layouts.app')

@section('title')
    Şikayet / Öneri Gönder
@endsection

@section('content')

    <div class="feed">

        <a href="{{ route('feedback.index') }}" class="back-link">← Listeye dön</a>

        <div class="form-card">
            <h1 class="form-title">Şikayet / Öneri Gönder</h1>
            <p class="form-note">Konuyu kısa tut, mesajda ayrıntıya gir. İstersen ekran görüntüsü ekleyebilirsin.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label>Tür</label>
                    <div class="radio-row">
                        <label class="radio-opt">
                            <input type="radio" name="type" value="1" {{ old('type') == 1 ? 'checked' : '' }} required>
                            Şikayet
                        </label>
                        <label class="radio-opt">
                            <input type="radio" name="type" value="2" {{ old('type') == 2 ? 'checked' : '' }}>
                            Öneri
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label for="subject">Konu</label>
                    <input type="text" name="subject" id="subject" class="input"
                           value="{{ old('subject') }}" maxlength="255" required>
                </div>

                <div class="field">
                    <label for="message">Mesajınız</label>
                    <textarea name="message" id="message" class="input" rows="7" required>{{ old('message') }}</textarea>
                </div>

                <div class="field">
                    <label for="images">Resim ekle (isteğe bağlı)</label>
                    <input type="file" name="images[]" id="images" class="input" multiple
                           accept="image/png,image/jpeg,image/webp">
                    <span class="field-hint">En fazla 5 resim, her biri 5 MB'a kadar (jpg, png, webp).</span>
                </div>

                <button type="submit" class="create-post-submit">Gönder</button>
            </form>
        </div>

    </div>

@endsection
