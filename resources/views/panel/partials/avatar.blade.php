@php
    // $user ve isteğe bağlı $size ('sm' | 'md' | 'lg') değişkenleri parametre olarak gelir.
    $size = $size ?? 'md';
    $sizeClass = match ($size) {
        'sm' => 'avatar-sm',
        'lg' => 'avatar-lg',
        default => '',
    };
@endphp

<span class="avatar {{ $sizeClass }}">
    @if (!empty($user->profile_photo_path))
        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->username }}">
    @else
        <span class="avatar-initial">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
    @endif
</span>
