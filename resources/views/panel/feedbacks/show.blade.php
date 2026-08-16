@extends('panel.layouts.app')

@section('title')
    {{ $feedback->subject }}
@endsection

@section('content')

    <div class="feed">

        <a href="{{ route('feedback.index') }}" class="back-link">← Listeye dön</a>

        @php
            $statusClass = match($feedback->status) {
                0 => 'is-pending',
                1 => 'is-review',
                2 => 'is-done',
                3 => 'is-rejected',
                default => '',
            };
            $statusText = match($feedback->status) {
                0 => 'Beklemede',
                1 => 'İnceleniyor',
                2 => 'Çözüldü',
                3 => 'Reddedildi',
                default => '-',
            };
        @endphp

        <div class="post-card detail-card">

            <div class="detail-head">
                <div>
                    <h1 class="detail-title">{{ $feedback->subject }}</h1>
                    <p class="detail-meta">
                        {{ $feedback->type == 1 ? 'Şikayet' : 'Öneri' }} · {{ $feedback->created_at->format('d.m.Y H:i') }}
                    </p>
                </div>
                <span class="status-tag {{ $statusClass }}">{{ $statusText }}</span>
            </div>

            <div class="detail-body">

                <div class="detail-section">
                    <h2 class="detail-label">Mesaj</h2>
                    <p class="detail-text">{{ $feedback->message }}</p>
                </div>

                @if ($feedback->images->isNotEmpty())
                    <div class="detail-section">
                        <h2 class="detail-label">Eklenen Resimler</h2>
                        <div class="image-grid">
                            @foreach ($feedback->images as $image)
                                <div class="post-image-wrap">
                                    <a href="{{ $image->image_url }}" target="_blank">
                                        <img src="{{ $image->image_url }}" alt="Şikayet/öneri resmi">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="detail-section">
                    <h2 class="detail-label">Yönetici Yanıtı</h2>

                    @if ($feedback->is_responded)
                        <div class="response-box">
                            <p>{{ $feedback->admin_response }}</p>
                            <span class="response-by">
                                {{ $feedback->respondedBy->name ?? 'Yönetici' }} ·
                                {{ $feedback->responded_at->format('d.m.Y H:i') }}
                            </span>
                        </div>
                    @else
                        <div class="response-box is-waiting">
                            Henüz yönetici tarafından yanıt verilmedi.
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

@endsection
