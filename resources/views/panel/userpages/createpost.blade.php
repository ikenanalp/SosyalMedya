@extends('panel.layouts.app')

@section('headcss')

    /* ===== Genel Ayarlar ===== */
    :root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --danger: #ef4444;
    --text-main: #1a1a2e;
    --text-muted: #6b7280;
    --border: #eef0f4;
    --bg: #f4f5f9;
    --card-bg: #ffffff;
    --radius: 16px;
    --shadow: 0 2px 10px rgba(20, 20, 43, 0.06);
    --shadow-hover: 0 6px 20px rgba(20, 20, 43, 0.1);
    }

    /* ===== Akış Kapsayıcı ===== */
    .feed {
    max-width: 600px;
    margin: 32px auto;
    display: flex;
    flex-direction: column;
    gap: 24px;
    padding: 0 16px;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    color: var(--text-main);
    }

    /* ===== Post Oluşturma Formu ===== */
    .form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 32px;
    }

    .form-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-main);
    margin: 0 0 20px;
    }

    .alert {
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    margin-bottom: 16px;
    }

    .alert-success {
    background: #ecfdf3;
    color: #15803d;
    }

    .alert-danger {
    background: #fdecec;
    color: var(--danger);
    }

    .alert-danger ul {
    margin: 0;
    padding-left: 18px;
    }

    .create-post-form {
    display: flex;
    flex-direction: column;
    gap: 4px;
    }

    .post-textarea {
    width: 100%;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: var(--radius);
    padding: 14px 16px;
    font-size: 15px;
    font-family: inherit;
    color: var(--text-main);
    resize: vertical;
    outline: none;
    transition: border-color 0.15s ease, background 0.15s ease;
    margin-bottom: 12px;
    }

    .post-textarea:focus {
    border-color: var(--primary);
    background: #fff;
    }

    .post-textarea::placeholder {
    color: var(--text-muted);
    }

    .file-input-wrap {
    position: relative;
    display: block;
    margin-bottom: 16px;
    cursor: pointer;
    }

    .file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    }

    .file-input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1.5px dashed var(--border);
    border-radius: var(--radius);
    padding: 14px 16px;
    font-size: 14px;
    color: var(--text-muted);
    background: var(--bg);
    transition: border-color 0.15s ease, color 0.15s ease, background 0.15s ease;
    }

    .file-input-wrap:hover .file-input-label {
    border-color: var(--primary);
    color: var(--primary);
    background: #fff;
    }

    .field-error {
    color: var(--danger);
    font-size: 13px;
    margin: -8px 0 12px;
    }

    .create-post-submit {
    align-self: flex-start;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 10px 28px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease;
    }

    .create-post-submit:hover {
    background: var(--primary-dark);
    }

    /* ===== Profil Kartı ===== */
    .profile-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 8px;
    }

    .avatar-lg {
    width: 64px;
    height: 64px;
    font-size: 22px;
    flex-shrink: 0;
    }

    .profile-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    }

    .profile-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-main);
    margin: 0;
    }

    .profile-stats {
    display: flex;
    gap: 16px;
    font-size: 14px;
    color: var(--text-muted);
    }

    .profile-stats strong {
    color: var(--text-main);
    }

    .profile-subtitle {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    color: var(--text-muted);
    }

    .follow-btn {
    align-self: flex-start;
    margin-top: 4px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
    }

    .follow-btn:hover {
    background: var(--primary-dark);
    }

    .follow-btn.following {
    background: #fff;
    color: var(--danger);
    border: 1px solid var(--danger);
    }

    .follow-btn.following:hover {
    background: #fdecec;
    }

    /* ===== Arama Kartı ===== */
    .search-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 20px;
    }

    .search-form {
    display: flex;
    gap: 10px;
    }

    .search-input-wrap {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 999px;
    padding: 0 16px;
    transition: border-color 0.15s ease, background 0.15s ease;
    }

    .search-input-wrap:focus-within {
    border-color: var(--primary);
    background: #fff;
    }

    .search-icon {
    color: var(--text-muted);
    font-size: 14px;
    }

    .search-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 10px 0;
    font-size: 14px;
    outline: none;
    color: var(--text-main);
    }

    .search-submit {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.15s ease;
    }

    .search-submit:hover {
    background: var(--primary-dark);
    }

    /* ===== Kullanıcı Kartı ===== */
    .user-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .user-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
    }

    .user-card-left {
    display: flex;
    align-items: center;
    gap: 12px;
    }

    .view-profile-btn {
    background: none;
    border: 1px solid var(--primary);
    color: var(--primary);
    border-radius: 999px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s ease, color 0.15s ease;
    }

    .view-profile-btn:hover {
    background: var(--primary);
    color: #fff;
    }

    /* ===== Gönderi Zaman Etiketi ===== */
    .post-time {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    color: var(--text-muted);
    font-size: 13px;
    }

    /* ===== Boş Durum ===== */
    .empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-muted);
    }

    .empty-state i {
    font-size: 36px;
    display: block;
    margin-bottom: 12px;
    opacity: 0.6;
    }

    .empty-state p {
    font-size: 16px;
    margin: 0;
    }

    /* ===== Sayfalama ===== */
    .pagination-wrap {
    display: flex;
    justify-content: center;
    margin-top: 8px;
    }

    .pagination-wrap nav ul {
    display: flex;
    list-style: none;
    gap: 6px;
    padding: 0;
    margin: 0;
    }

    .pagination-wrap a,
    .pagination-wrap span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 8px;
    border-radius: 8px;
    font-size: 13px;
    color: var(--text-main);
    background: var(--card-bg);
    box-shadow: var(--shadow);
    text-decoration: none;
    }

    .pagination-wrap .active span {
    background: var(--primary);
    color: #fff;
    }

    /* ===== Gönderi Kartı ===== */
    .post-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .post-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
    }

    .post-header {
    padding: 18px 20px 4px;
    }

    .post-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    }

    .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #a855f7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(99, 102, 241, 0.35);
    }

    .avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 13px;
    }

    .username {
    font-weight: 600;
    font-size: 15px;
    color: var(--text-main);
    }

    .post-content {
    font-size: 15px;
    line-height: 1.55;
    margin: 0 0 12px;
    color: #33344a;
    white-space: pre-line;
    }

    /* ===== Gönderi Görselleri ===== */
    .post-images {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3px;
    }

    .post-images.multi {
    grid-template-columns: 1fr 1fr;
    }

    .post-image-wrap {
    overflow: hidden;
    background: #000;
    }

    .post-image-wrap img {
    width: 100%;
    height: 100%;
    max-height: 480px;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
    }

    .post-image-wrap:hover img {
    transform: scale(1.03);
    }

    /* ===== Aksiyonlar (Beğeni) ===== */
    .post-actions {
    padding: 12px 20px;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    }

    .like-form {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    }

    .like-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 20px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border-radius: 50%;
    transition: transform 0.15s ease, background 0.15s ease, color 0.15s ease;
    }

    .like-btn:hover {
    background: #fdecec;
    transform: scale(1.1);
    }

    .like-btn.liked {
    color: var(--danger);
    }

    .like-btn:active {
    transform: scale(0.9);
    }

    .like-count {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-muted);
    }

    /* ===== Gönderi Meta (beğeni/yorum sayısı, tarih) ===== */
    .post-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px 20px 4px;
    font-size: 13px;
    color: var(--text-muted);
    }

    .meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    }

    .meta-item .liked-icon {
    color: var(--danger);
    }

    .meta-date {
    margin-left: auto;
    }

    /* ===== Gönderi Silme Butonu ===== */
    .delete-post-form {
    padding: 4px 20px 18px;
    }

    .delete-post-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: 1px solid var(--danger);
    color: var(--danger);
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease, color 0.15s ease;
    }

    .delete-post-btn:hover {
    background: var(--danger);
    color: #fff;
    }

    /* ===== Yorumlar ===== */
    .comments {
    padding: 12px 20px 4px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 260px;
    overflow-y: auto;
    }

    .comment {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    position: relative;
    }

    .comment-body {
    background: var(--bg);
    border-radius: 14px;
    padding: 8px 14px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    max-width: 85%;
    }

    .comment-username {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-main);
    }

    .comment-text {
    font-size: 14px;
    color: #3b3c50;
    line-height: 1.4;
    word-break: break-word;
    }

    .comment-delete-form {
    margin-left: auto;
    }

    .comment-delete-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 12px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: color 0.15s ease, background 0.15s ease;
    }

    .comment-delete-btn:hover {
    color: var(--danger);
    background: #fdecec;
    }

    .no-comments {
    font-size: 13px;
    color: var(--text-muted);
    font-style: italic;
    padding: 4px 0 10px;
    }

    /* ===== Yorum Ekleme Formu ===== */
    .comment-form {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px 18px;
    }

    .comment-input {
    flex: 1;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: 999px;
    padding: 10px 16px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.15s ease, background 0.15s ease;
    }

    .comment-input:focus {
    border-color: var(--primary);
    background: #fff;
    }

    .comment-submit {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease, transform 0.15s ease;
    white-space: nowrap;
    }

    .comment-submit:hover {
    background: var(--primary-dark);
    }

    .comment-submit:active {
    transform: scale(0.96);
    }

    /* ===== Mobil Uyum ===== */
    @media (max-width: 480px) {
    .feed {
    margin: 12px auto;
    gap: 16px;
    padding: 0 8px;
    }

    .profile-card {
    padding: 20px;
    gap: 14px;
    }

    .form-card {
    padding: 22px;
    }

    .search-card {
    padding: 16px;
    }

    .user-card {
    padding: 14px 16px;
    }

    .post-header {
    padding: 14px 14px 4px;
    }

    .post-actions {
    padding: 10px 14px;
    }

    .post-meta {
    padding: 10px 14px 4px;
    }

    .delete-post-form {
    padding: 4px 14px 14px;
    }

    .comments {
    padding: 10px 14px 4px;
    }

    .comment-form {
    padding: 12px 14px 14px;
    }
    }

@endsection

@section('title')
    Post Oluştur
@endsection

@section('content')

    <div class="feed">

        <div class="form-card">
            <h2 class="form-title">Yeni Gönderi Oluştur</h2>

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

                <textarea name="content" class="post-textarea" rows="3" placeholder="Ne düşünüyorsun?">{{ old('content') }}</textarea>
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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
@endsection
