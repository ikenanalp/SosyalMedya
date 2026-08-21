@extends('panel.admin.layouts.app')

@section('title', $feedback->subject)

@section('content')

    <a href="{{ route('admin.feedback.index') }}" class="back-link">&larr; Listeye dön</a>

    <div class="a-topbar a-topbar--split">
        <div>
            <h1 class="a-topbar-title">{{ $feedback->subject }}</h1>
        </div>
        <span class="badge-pill {{ match($feedback->status) {
            0 => 'badge-pill--pending',
            1 => 'badge-pill--reviewing',
            2 => 'badge-pill--resolved',
            3 => 'badge-pill--rejected',
            default => '',
        } }}">
            {{ match($feedback->status) {
                0 => 'Beklemede',
                1 => 'İnceleniyor',
                2 => 'Çözüldü',
                3 => 'Reddedildi',
                default => '-',
            } }}
        </span>
    </div>

    <div class="detail-meta">
        {{ $feedback->type == 1 ? 'Şikayet' : 'Öneri' }} ·
        {{ $feedback->user->name ?? 'Bilinmeyen kullanıcı' }} ({{ $feedback->user->username ?? '-' }}) ·
        {{ $feedback->created_at->format('d.m.Y H:i') }}
    </div>

    @if (session('success'))
        <div class="alert-a alert-a--success">
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-a__close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-a alert-a--danger alert-a--block">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Kullanıcının mesajı --}}
    <div class="message-block">{{ $feedback->message }}</div>

    {{-- Eklenen resimler --}}
    @if ($feedback->images->isNotEmpty())
        <div class="a-field">
            <label>Eklenen Resimler</label>
            <div class="image-grid">
                @foreach ($feedback->images as $image)
                    <a href="{{ $image->image_url }}" target="_blank">
                        <img src="{{ $image->image_url }}" alt="Geri bildirim resmi">
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Önceki yanıt varsa göster --}}
    @if ($feedback->is_responded)
        <div class="prior-response">
            <div class="prior-response__label">Mevcut Yanıt</div>
            <div class="prior-response__text">{{ $feedback->admin_response }}</div>
            <div class="prior-response__meta">
                {{ $feedback->respondedBy->name ?? 'Yönetici' }} ·
                {{ $feedback->responded_at->format('d.m.Y H:i') }}
            </div>
        </div>
    @endif

    <hr class="a-form-divider">

    {{-- Yanıt formu --}}
    <form action="{{ route('admin.feedback.respond', $feedback) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="a-field">
            <label for="status">Durum</label>
            <select name="status" id="status" class="a-select">
                <option value="0" @selected($feedback->status == 0)>Beklemede</option>
                <option value="1" @selected($feedback->status == 1)>İnceleniyor</option>
                <option value="2" @selected($feedback->status == 2)>Çözüldü</option>
                <option value="3" @selected($feedback->status == 3)>Reddedildi</option>
            </select>
        </div>

        <div class="a-field">
            <label for="admin_response">Yanıtınız</label>
            <textarea name="admin_response" id="admin_response" rows="5" required class="a-textarea">{{ old('admin_response', $feedback->admin_response) }}</textarea>
        </div>

        <button type="submit" class="btn-a btn-a--primary">Yanıtı Kaydet</button>
    </form>

@endsection
