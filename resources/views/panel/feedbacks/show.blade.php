@extends('panel.layouts.app')

@section('content')

    <div class="container py-4">

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">
            ← Listeye Dön
        </a>

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $feedback->subject }}</h3>

                @php
                    $statusClass = match($feedback->status) {
                        0 => 'warning',
                        1 => 'info',
                        2 => 'success',
                        3 => 'danger',
                        default => 'secondary',
                    };

                    $statusText = match($feedback->status) {
                        0 => 'Beklemede',
                        1 => 'İnceleniyor',
                        2 => 'Çözüldü',
                        3 => 'Reddedildi',
                        default => '-',
                    };
                @endphp

                <span class="badge bg-{{ $statusClass }}">
                {{ $statusText }}
            </span>
            </div>

            <div class="card-body">

                <div class="mb-4 text-muted">
                    <strong>{{ $feedback->type == 1 ? 'Şikayet' : 'Öneri' }}</strong>
                    •
                    {{ $feedback->created_at->format('d.m.Y H:i') }}
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold mb-3">Mesaj</h5>

                    <div class="border rounded p-3 bg-light">
                        {{ $feedback->message }}
                    </div>
                </div>

                @if ($feedback->images->isNotEmpty())

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3">Eklenen Resimler</h5>

                        <div class="row g-3">

                            @foreach ($feedback->images as $image)

                                <div class="col-md-4 col-lg-3">

                                    <a href="{{ $image->image_url }}" target="_blank">

                                        <img
                                            src="{{ $image->image_url }}"
                                            class="img-fluid rounded shadow-sm border"
                                            style="height:220px; width:100%; object-fit:cover;"
                                            alt="Feedback Resmi">

                                    </a>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

                <div>

                    <h5 class="fw-bold mb-3">Yönetici Yanıtı</h5>

                    @if ($feedback->is_responded)

                        <div class="alert alert-success mb-0">

                            <p class="mb-3">
                                {{ $feedback->admin_response }}
                            </p>

                            <small class="text-muted">
                                {{ $feedback->respondedBy->name ?? 'Yönetici' }}
                                •
                                {{ $feedback->responded_at->format('d.m.Y H:i') }}
                            </small>

                        </div>

                    @else

                        <div class="alert alert-warning mb-0">
                            Henüz yönetici tarafından yanıt verilmedi.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection
