@extends('panel.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-semibold mb-6">Şikayet / Öneri Gönder</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Tür seçimi: şikayet / öneri --}}
            <div>
                <label class="block text-sm font-medium mb-2">Tür</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="type" value="1" {{ old('type') == 1 ? 'checked' : '' }} required>
                        Şikayet
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="type" value="2" {{ old('type') == 2 ? 'checked' : '' }}>
                        Öneri
                    </label>
                </div>
            </div>

            {{-- Konu --}}
            <div>
                <label for="subject" class="block text-sm font-medium mb-1">Konu</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                       maxlength="255" required
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- Mesaj --}}
            <div>
                <label for="message" class="block text-sm font-medium mb-1">Mesajınız</label>
                <textarea name="message" id="message" rows="6" required
                          class="w-full border rounded px-3 py-2">{{ old('message') }}</textarea>
            </div>

            {{-- Resimler --}}
            <div>
                <label for="images" class="block text-sm font-medium mb-1">
                    Resim ekle <span class="text-gray-400 font-normal">(isteğe bağlı, en fazla 5 resim)</span>
                </label>
                <input type="file" name="images[]" id="images" multiple accept="image/png,image/jpeg,image/webp"
                       class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-400 mt-1">Her resim en fazla 5 MB olabilir (jpg, png, webp).</p>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Gönder
            </button>
        </form>
    </div>
@endsection
