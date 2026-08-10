@extends('panel.admin.layouts.app')

@section('headcss')

@endsection

@section('title')

@endsection

@section('content')

    <div class="max-w-2xl mx-auto py-10 px-4">
        <a href="{{ route('admin.feedback.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Listeye dön</a>

        <div class="flex items-center justify-between mt-4 mb-2">
            <h1 class="text-2xl font-semibold">{{ $feedback->subject }}</h1>
            <span class="text-xs px-2 py-1 rounded
            {{ match($feedback->status) {
                0 => 'bg-yellow-100 text-yellow-700',
                1 => 'bg-blue-100 text-blue-700',
                2 => 'bg-green-100 text-green-700',
                3 => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-700',
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

        <p class="text-sm text-gray-500 mb-6">
            {{ $feedback->type == 1 ? 'Şikayet' : 'Öneri' }} ·
            {{ $feedback->user->name ?? 'Bilinmeyen kullanıcı' }} ({{ $feedback->user->username ?? '-' }}) ·
            {{ $feedback->created_at->format('d.m.Y H:i') }}
        </p>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Kullanıcının mesajı --}}
        <div class="border rounded p-4 mb-6">
            <p class="whitespace-pre-line text-gray-800">{{ $feedback->message }}</p>
        </div>

        {{-- Eklenen resimler --}}
        @if ($feedback->images->isNotEmpty())
            <div class="mb-6">
                <h2 class="text-sm font-medium mb-2">Eklenen Resimler</h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($feedback->images as $image)
                        <a href="{{ $image->image_url }}" target="_blank">
                            <img src="{{ $image->image_url }}" alt="Feedback resmi"
                                 class="w-full h-28 object-cover rounded border hover:opacity-80">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Önceki yanıt varsa göster --}}
        @if ($feedback->is_responded)
            <div class="bg-gray-50 border rounded p-4 mb-6">
                <p class="text-xs font-medium text-gray-500 mb-1">Mevcut Yanıt</p>
                <p class="whitespace-pre-line text-gray-800">{{ $feedback->admin_response }}</p>
                <p class="text-xs text-gray-400 mt-3">
                    {{ $feedback->respondedBy->name ?? 'Yönetici' }} ·
                    {{ $feedback->responded_at->format('d.m.Y H:i') }}
                </p>
            </div>
        @endif

        {{-- Yanıt formu --}}
        <form action="{{ route('admin.feedback.respond', $feedback) }}" method="POST" class="space-y-4 border-t pt-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="status" class="block text-sm font-medium mb-1">Durum</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2">
                    <option value="0" @selected($feedback->status == 0)>Beklemede</option>
                    <option value="1" @selected($feedback->status == 1)>İnceleniyor</option>
                    <option value="2" @selected($feedback->status == 2)>Çözüldü</option>
                    <option value="3" @selected($feedback->status == 3)>Reddedildi</option>
                </select>
            </div>

            <div>
                <label for="admin_response" class="block text-sm font-medium mb-1">Yanıtınız</label>
                <textarea name="admin_response" id="admin_response" rows="5" required
                          class="w-full border rounded px-3 py-2">{{ old('admin_response', $feedback->admin_response) }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Yanıtı Kaydet
            </button>
        </form>
    </div>

@endsection
