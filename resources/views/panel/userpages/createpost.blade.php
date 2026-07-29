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


                <form action="{{ route('panel.user.createPost') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                    <textarea
                        name="content"
                        class="form-control form-control-lg bg-light border-0 rounded-3 @error('content') is-invalid @enderror"
                        rows="4"
                        placeholder="Ne düşünüyorsun?"
                        style="resize: none;"
                    >{{ old('content') }}</textarea>

                        @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3 shadow-sm">
                            Paylaş
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
