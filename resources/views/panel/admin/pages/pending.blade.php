@extends('panel.admin.layouts.app')

@section('title')

@endsection

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-xl font-semibold mb-6 ">Post Onaylama Sayfası </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @forelse($posts as $post)
            <div class="border p-4 rounded mb-3">
                <p class="text-sm text-gray-500">{{ $post->user->username }}</p>
                <p class="mt-1">{{ $post->content }}</p>

                <div class="flex gap-2 mt-3">
                    <form action="{{ route('posts.approve', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                            Onayla
                        </button>
                    </form>

                    <form action="{{ route('posts.reject', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                            Reddet
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Onay bekleyen post yok.</p>
        @endforelse

        {{ $posts->links() }}
    </div>
@endsection
