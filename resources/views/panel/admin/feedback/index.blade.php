@extends('panel.admin.layouts.app')

@section('title', 'Şikayet / Öneri Yönetimi')
@section('page-title', 'Şikayet / Öneri Yönetimi')

@section('content')

    <form method="GET" class="filter-bar">
        <select name="status" class="select-field" onchange="this.form.submit()">
            <option value="">Tüm Durumlar</option>
            <option value="0" @selected(request('status') === '0')>Beklemede</option>
            <option value="1" @selected(request('status') === '1')>İnceleniyor</option>
            <option value="2" @selected(request('status') === '2')>Çözüldü</option>
            <option value="3" @selected(request('status') === '3')>Reddedildi</option>
        </select>

        <select name="type" class="select-field" onchange="this.form.submit()">
            <option value="">Tüm Türler</option>
            <option value="1" @selected(request('type') === '1')>Şikayet</option>
            <option value="2" @selected(request('type') === '2')>Öneri</option>
        </select>

        @if (request('status') || request('type'))
            <a href="{{ route('admin.feedback.index') }}" class="filter-clear">Filtreyi temizle</a>
        @endif
    </form>

    @if (session('success'))
        <div class="alert-a alert-a--success">
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-a__close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($feedbackList->isEmpty())
        <div class="a-empty">
            <i class="bi bi-inbox"></i>
            <p>Kayıt bulunamadı.</p>
        </div>
    @else
        <div class="list-table">
            <div class="list-table__head">
                <div>Konu</div>
                <div>Gönderen</div>
                <div>Tür</div>
                <div>Durum</div>
                <div>Tarih</div>
            </div>

            @foreach ($feedbackList as $item)
                <a href="{{ route('admin.feedback.show', $item) }}" class="list-table__row">
                    <div class="list-table__col">{{ $item->subject }}</div>
                    <div class="list-table__col">{{ $item->user->name ?? '—' }}</div>
                    <div class="list-table__col">{{ $item->type == 1 ? 'Şikayet' : 'Öneri' }}</div>
                    <div>
                        <span class="badge-pill {{ match($item->status) {
                            0 => 'badge-pill--pending',
                            1 => 'badge-pill--reviewing',
                            2 => 'badge-pill--resolved',
                            3 => 'badge-pill--rejected',
                            default => '',
                        } }}">
                            {{ match($item->status) {
                                0 => 'Beklemede',
                                1 => 'İnceleniyor',
                                2 => 'Çözüldü',
                                3 => 'Reddedildi',
                                default => '-',
                            } }}
                        </span>
                    </div>
                    <div class="list-table__date">{{ $item->created_at->format('d.m.Y H:i') }}</div>
                </a>
            @endforeach
        </div>
    @endif

    <div class="pagination-wrap">
        {{ $feedbackList->links() }}
    </div>

@endsection
