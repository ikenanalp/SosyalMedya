@extends('panel.admin.layouts.app')

@section('title', 'Panel')
@section('page-title', 'Panel')
@section('page-subtitle', 'Sistem geneline hızlı bakış.')

@section('content')

    <div class="stat-grid">

        <div class="stat-card stat-card--primary">
            <div>
                <div class="stat-card__label">Toplam Post</div>
                <div class="stat-card__value">{{ $stats['total_posts'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-collection-fill"></i></div>
        </div>

        <div class="stat-card stat-card--success">
            <div>
                <div class="stat-card__label">Onaylanan Post</div>
                <div class="stat-card__value">{{ $stats['approved_posts'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-check-circle-fill"></i></div>
        </div>

        <div class="stat-card stat-card--danger">
            <div>
                <div class="stat-card__label">Reddedilen Post</div>
                <div class="stat-card__value">{{ $stats['rejected_posts'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-x-circle-fill"></i></div>
        </div>

        <div class="stat-card stat-card--warning">
            <div>
                <div class="stat-card__label">Bekleyen Post</div>
                <div class="stat-card__value">{{ $stats['pending_posts'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-hourglass-split"></i></div>
        </div>

        <div class="stat-card stat-card--info">
            <div>
                <div class="stat-card__label">Toplam Kullanıcı</div>
                <div class="stat-card__value">{{ $stats['total_users'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-people-fill"></i></div>
        </div>

        <div class="stat-card stat-card--secondary">
            <div>
                <div class="stat-card__label">Banlı Kullanıcı</div>
                <div class="stat-card__value">{{ $stats['banned_users'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-slash-circle-fill"></i></div>
        </div>

        <div class="stat-card stat-card--warning">
            <div>
                <div class="stat-card__label">Bekleyen Geri Bildirim</div>
                <div class="stat-card__value">{{ $stats['feedback_pending'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-hourglass-split"></i></div>
        </div>

        <div class="stat-card stat-card--danger">
            <div>
                <div class="stat-card__label">Şikayetler</div>
                <div class="stat-card__value">{{ $stats['feedback_complains'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-exclamation-circle-fill"></i></div>
        </div>

        <div class="stat-card stat-card--info">
            <div>
                <div class="stat-card__label">Öneriler</div>
                <div class="stat-card__value">{{ $stats['feedback_suggestions'] }}</div>
            </div>
            <div class="stat-card__icon"><i class="bi bi-lightbulb-fill"></i></div>
        </div>

    </div>

@endsection
