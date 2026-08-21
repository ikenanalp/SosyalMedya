@extends('panel.layouts.app')

@section('title')
    Profili Düzenle
@endsection

@section('content')

    <div class="feed">

        <a href="{{ route('panel.user.showProfilePage') }}" class="back-link">← Profilime dön</a>

        <div class="form-card">
            <h1 class="form-title">Profili Düzenle</h1>
            <p class="form-note">Kullanıcı adını, profil fotoğrafını ve kısa biyografini buradan güncelleyebilirsin.</p>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panel.user.updateProfile') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="username">Kullanıcı Adı</label>
                    <input type="text" name="username" id="username" class="input" maxlength="50"
                           value="{{ old('username', $user->username) }}">
                    <span class="field-hint">Yalnızca harf, rakam, nokta ve alt çizgi kullanabilirsin.</span>
                    @error('username')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mevcut avatar önizlemesi --}}
                <div class="field">
                    <label>Mevcut Fotoğraf</label>
                    <div style="display:flex; align-items:center; gap:16px;">
                        <span class="avatar avatar-lg">
                    @if (!empty($user->profile_photo_path))
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->username }}">
                            @else
                                <span class="avatar-initial">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                            @endif
                </span>

                        @if ($user->profile_photo_path)
                            <label style="display:flex; align-items:center; gap:8px; font-size:14px; color:var(--sm-text-muted); cursor:pointer;">
                                <input type="checkbox" name="remove_avatar" value="1">
                                Mevcut fotoğrafı kaldır
                            </label>
                        @endif
                    </div>
                </div>

                <div class="field">
                    <label for="avatar">Yeni Fotoğraf Yükle</label>
                    <input type="file" name="avatar" id="avatar" class="input" accept="image/png,image/jpeg,image/webp">
                    <span class="field-hint">JPG, PNG veya WEBP formatında, en fazla 2MB.</span>
                    @error('avatar')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="bio">Biyografi</label>
                    <textarea name="bio" id="bio" class="input" rows="3" maxlength="160"
                              placeholder="Kendinden kısaca bahset...">{{ old('bio', $user->bio) }}</textarea>
                    <span class="field-hint">En fazla 160 karakter.</span>
                    @error('bio')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="create-post-submit">Kaydet</button>
            </form>
        </div>

        @if ($user->avatars->count() > 0)
            <div class="form-card" style="margin-top: 20px;">
                <h2 class="form-title" style="font-size: 18px;">Önceki Avatarlar</h2>
                <p class="form-note">Geçmişte yüklediğin fotoğraflardan birini tekrar aktif yapabilir ya da kalıcı olarak silebilirsin.</p>

                <div class="avatar-history-grid">
                    @foreach ($user->avatars as $avatar)
                        @php $isCurrent = $user->profile_photo_path === $avatar->image_url; @endphp
                        <div class="avatar-history-item {{ $isCurrent ? 'is-current' : '' }}">
                            <img src="{{ asset('storage/' . $avatar->image_url) }}" alt="Eski avatar">

                            @if ($isCurrent)
                                <span class="avatar-history-badge">Aktif</span>
                            @else
                                <div class="avatar-history-actions">
                                    <form action="{{ route('panel.user.useAvatar', $avatar) }}" method="post">
                                        @csrf
                                        <button type="submit" class="avatar-history-btn" title="Bunu kullan">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('panel.user.deleteAvatar', $avatar) }}" method="post"
                                          onsubmit="return confirm('Bu avatarı kalıcı olarak silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="avatar-history-btn avatar-history-btn--danger" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection
