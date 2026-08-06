@extends('panel.layouts.app')

@section('title')
Post Oluştur
@endsection

@section('content')

    <div class="container py-5" style="max-width: 900px;">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4 p-md-5">
                <h2 class="fw-bold mb-4 text-dark">Yeni Gönderi Oluştur</h2>

                @if(session('success'))
                    <div class="alert alert-success bg-success-subtle text-success-emphasis border-0 rounded-3 alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger bg-danger-subtle text-danger-emphasis border-0 rounded-3 alert-dismissible fade show" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('panel.user.createPost') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <textarea name="content" class="form-control mb-3" rows="3" placeholder="Ne düşünüyorsun?">{{ old('content') }}</textarea>
                    @error('content')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror

                    <input type="file" name="images[]" class="form-control mb-3" accept="image/*" multiple>
                    @error('images.*')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary rounded-pill px-4">Paylaş</button>
                </form>
            </div>
        </div>
    </div>
@endsection
