@extends('app')

@section('title', 'الإشعارات')

@section('content')
<div class="notification-page-container py-4" dir="rtl">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 me-3 bg-gradient-primary text-white">
                                    <i class="fas fa-bell fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold">كل الإشعارات</h4>
                                    <p class="text-muted mb-0">عرض وإدارة جميع الإشعارات الخاصة بك</p>
                                </div>
                            </div>
                            <button id="markAllReadBtn" class="btn btn-outline-primary">
                                <i class="fas fa-check-double me-1"></i>
                                تحديد الكل كمقروء
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <!-- Loading State -->
                <div id="loadingSpinner" class="text-center py-5">
                    <div class="loading-animation">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <div class="spinner-grow text-primary ms-1" role="status" style="animation-delay: 0.2s">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <div class="spinner-grow text-primary ms-1" role="status" style="animation-delay: 0.4s">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                    </div>
                    <p class="mt-3 text-muted fw-light">جاري تحميل الإشعارات...</p>
                </div>

                <!-- Empty State (Hidden by default) -->
                <div id="emptyState" class="text-center py-5" style="display: none;">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-bell-slash fa-5x text-muted opacity-25"></i>
                    </div>
                    <h5 class="fw-medium">لا توجد إشعارات حالياً</h5>
                    <p class="text-muted">سيتم عرض الإشعارات هنا عندما تتلقى إشعارات جديدة</p>
                </div>

                <!-- Error State (Hidden by default) -->
                <div id="errorState" class="text-center py-5" style="display: none;">
                    <div class="empty-state-icon mb-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-5x opacity-25"></i>
                    </div>
                    <h5 class="fw-medium">حدث خطأ</h5>
                    <p class="text-muted" id="errorMessage">تعذر تحميل الإشعارات، يرجى المحاولة مرة أخرى</p>
                    <button id="retryButton" class="btn btn-primary mt-2">
                        <i class="fas fa-redo me-1"></i>
                        إعادة المحاولة
                    </button>
                </div>

                <!-- Notifications List -->
                <div id="notificationsContainer" style="display: none;">
                    <!-- Notifications will be added dynamically here -->
                </div>

                <!-- Load More Button -->
                <div id="loadMoreContainer" class="text-center mt-4" style="display: none;">
                    <button id="loadMoreBtn" class="btn btn-outline-primary px-4">
                        تحميل المزيد
                        <i class="fas fa-chevron-down ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <!-- Stats Card -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>
                            إحصائيات الإشعارات
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-card p-3 rounded-4 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-2">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <h6 class="mb-0 text-muted small">الإجمالي</h6>
                                    </div>
                                    <h3 class="mb-0 fw-bold" id="statTotal">0</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card p-3 rounded-4 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-2">
                                            <i class="fas fa-bell-exclamation"></i>
                                        </div>
                                        <h6 class="mb-0 text-muted small">غير مقروءة</h6>
                                    </div>
                                    <h3 class="mb-0 fw-bold" id="statUnread">0</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card p-3 rounded-4 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-2 me-2">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <h6 class="mb-0 text-muted small">جلسات</h6>
                                    </div>
                                    <h3 class="mb-0 fw-bold" id="statSessions">0</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card p-3 rounded-4 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-2 me-2">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <h6 class="mb-0 text-muted small">رسائل</h6>
                                    </div>
                                    <h3 class="mb-0 fw-bold" id="statMessages">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.notification-scripts')
@include('components.notification-styles')
@endsection
