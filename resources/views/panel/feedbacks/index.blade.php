@extends('panel.layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Şikayet / Önerilerim</h1>
            <a href="{{ route('feedback.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Yeni Gönder
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-3">
            @forelse ($feedbackList as $item)
                <a href="{{ route('feedback.show', $item) }}"
                   class="block border rounded p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <span class="font-medium">{{ $item->subject }}</span>
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
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $item->type == 1 ? 'Şikayet' : 'Öneri' }} · {{ $item->created_at->format('d.m.Y H:i') }}
                    </p>
                </a>
            @empty
                <p class="text-gray-500">Henüz gönderdiğiniz bir şikayet/öneri yok.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $feedbackList->links() }}
        </div>
    </div>
@endsection
