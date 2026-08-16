@extends('panel.layouts.app')

@section('title')
    Takip Ettiklerim
@endsection

@section('content')

    <div class="feed">

        <h1 class="feed-heading">
            <span class="feed-kicker">Takip Ettiklerim</span>
            Takip Ettiklerinin Gönderileri
        </h1>

        @forelse($post as $p)
            <div class="post-card">
                <div class="post-header">
                    <div class="post-user">
                        {{--    @include('panel.partials.avatar', ['user' => $p->user, 'size' => 'md']) --}}
                           <span class="post-user-text">
                               <span class="username">{{ $p->user->username }}</span>
                               <span class="post-date">{{ $p->created_at->locale('tr')->diffForHumans() }}</span>
                           </span>
                       </div>

                       @if ($p->content)
                           <p class="post-content">{{ $p->content }}</p>
                       @endif
                   </div>

                   @if ($p->images->count() > 0)
                       <div class="post-images {{ $p->images->count() > 1 ? 'multi' : '' }}">
                           @foreach ($p->images as $img)
                               <div class="post-image-wrap">
                                   <img src="{{ asset('storage/' . $img->image_url) }}" alt="Gönderi resmi">
                               </div>
                           @endforeach
                       </div>
                   @endif

                   @php
                       $likeCount = $p->likes()->count();
                       $isLiked = $p->likes()->where('user_id', auth()->id())->exists();
                   @endphp

                   <div class="post-actions">
                       <form action="{{ route('user.likeSystem', $p->id) }}" method="post" class="like-form">
                           @csrf
                           <button type="submit" class="like-btn {{ $isLiked ? 'liked' : '' }}" aria-label="Beğen">
                               <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                           </button>
                           <span class="like-count">{{ $likeCount }} beğeni</span>
                       </form>
                   </div>

                   {{-- Yorumlar --}}
                <div class="comments">
                    @forelse($p->comments()->latest()->with('user')->get() as $com)
                        <div class="comment">
                            {{--   @include('panel.partials.avatar', ['user' => $com->user, 'size' => 'sm']) --}}
                              <div class="comment-body">
                                  <span class="comment-username">{{ $com->user->username }}</span>
                                  <span class="comment-text">{{ $com->comment }}</span>
                              </div>
                              @if (auth()->id() === $com->user_id)
                                  <form action="{{ route('user.deleteComment', $com->id) }}" method="post"
                                        class="comment-delete-form"
                                        onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz?')">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="comment-delete-btn">Sil</button>
                                  </form>
                              @endif
                          </div>
                      @empty
                          <p class="no-comments">Henüz yorum yapılmamış.</p>
                      @endforelse
                  </div>

                  {{-- Yorum ekleme formu --}}
                <form action="{{ route('user.createComment', $p->id) }}" method="post" class="comment-form">
                    @csrf
                    <input type="text" name="comment" placeholder="Bir yorum yazınız..." class="comment-input">
                    <button type="submit" class="comment-submit">Gönder</button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <p>Takip ettiğin kişilerin henüz gönderisi yok.</p>
            </div>
        @endforelse
    </div>

@endsection
