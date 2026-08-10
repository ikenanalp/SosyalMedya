@extends('panel.admin.layouts.app')

@section('headcss')

@endsection

@section('title')

@endsection

@section('content')

    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-semibold mb-6">Şikayet / Öneri Yönetimi</h1>

        {{-- Filtreler --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <select name="status" class="border rounded px-3 py-2 text-sm" onchange="this.form.submit()">
                <option value="">Tüm Durumlar</option>
                <option value="0" @selected(request('status') === '0')>Beklemede</option>
                <option value="1" @selected(request('status') === '1')>İnceleniyor</option>
                <option value="2" @selected(request('status') === '2')>Çözüldü</option>
                <option value="3" @selected(request('status') === '3')>Reddedildi</option>
            </select>

            <select name="type" class="border rounded px-3 py-2 text-sm" onchange="this.form.submit()">
                <option value="">Tüm Türler</option>
                <option value="1" @selected(request('type') === '1')>Şikayet</option>
                <option value="2" @selected(request('type') === '2')>Öneri</option>
            </select>

            @if (request('status') || request('type'))
                <a href="{{ route('admin.feedback.index') }}" class="text-sm text-gray-500 self-center hover:underline">
                    Filtreyi temizle
                </a>
            @endif
        </form>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="border rounded divide-y">
            <div class="grid grid-cols-12 gap-2 px-4 py-2 text-xs font-medium text-gray-500 bg-gray-50">
                <div class="col-span-4">Konu</div>
                <div class="col-span-2">Gönderen</div>
                <div class="col-span-2">Tür</div>
                <div class="col-span-2">Durum</div>
                <div class="col-span-2">Tarih</div>
            </div>

            @forelse ($feedbackList as $item)
                <a href="{{ route('admin.feedback.show', $item) }}"
                   class="grid grid-cols-12 gap-2 px-4 py-3 text-sm hover:bg-gray-50">
                    <div class="col-span-4 truncate">{{ $item->subject }}</div>
                    <div class="col-span-2 truncate">{{ $item->user->name ?? '—' }}</div>
                    <div class="col-span-2">{{ $item->type == 1 ? 'Şikayet' : 'Öneri' }}</div>
                    <div class="col-span-2">
                    <span class="text-xs px-2 py-1 rounded
                        {{ match($item->status) {
                            0 => 'bg-yellow-100 text-yellow-700',
                            1 => 'bg-blue-100 text-blue-700',
                            2 => 'bg-green-100 text-green-700',
                            3 => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
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
                    <div class="col-span-2 text-gray-500 text-xs">{{ $item->created_at->format('d.m.Y H:i') }}</div>
                </a>
            @empty
                <p class="px-4 py-6 text-gray-500 text-sm">Kayıt bulunamadı.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $feedbackList->links() }}
        </div>
    </div>

@endsection
