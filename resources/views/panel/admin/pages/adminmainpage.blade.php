@extends('panel.admin.layouts.app')

@section('title')

@endsection

@section('content')

    <div class="container py-4">
        <!-- Panel Başlığı -->
        <div class="d-flex align-items-center mb-4">
            <h1 class="h3 fw-bold text-dark m-0">Panel</h1>
        </div>

        <!-- İstatistik Kartları Grid Yapısı -->
        <div class="row g-3">

            <!-- Toplam Post -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-primary">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Toplam Post</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_posts'] }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                                <i class="bi bi-collection-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onaylanan Post -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-success">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Onaylanan Post</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['approved_posts'] }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reddedilen Post -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-danger">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Reddedilen Post</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['rejected_posts'] }}</h2>
                            </div>
                            <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
                                <i class="bi bi-x-circle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Post -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-warning">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Bekleyen Post</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['pending_posts'] }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                                <i class="bi bi-hourglass-split fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toplam Kullanıcı -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-info">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Toplam Kullanıcı</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['total_users'] }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banlı Kullanıcı -->
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-start border-4 border-secondary">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small fw-semibold text-uppercase mb-1">Banlı Kullanıcı</p>
                                <h2 class="h3 fw-bold text-dark mb-0">{{ $stats['banned_users'] }}</h2>
                            </div>
                            <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-circle">
                                <i class="bi bi-slash-circle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
