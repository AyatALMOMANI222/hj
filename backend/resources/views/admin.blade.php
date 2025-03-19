@extends('app')

@section('content')
<script>
// Global Constants
const STORAGE_BASE_URL = 'http://127.0.0.1:8000/storage/';

// Check if user is logged in and is admin
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    
    if (!token) {
        // Redirect to login if no token
        window.location.href = '/login';
        return;
    }
    
    // Fetch user profile to check admin status
    fetch('/api/user/profile', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Not authorized');
        }
        return response.json();
    })
    .then(data => {
        if (!data.user || !data.isAdmin) {
            alert('عذراً، هذه الصفحة للمسؤولين فقط.');
            window.location.href = '/';
        }
        
    })
    .catch(error => {
        console.error('Auth error:', error);
        alert('عذراً، يجب تسجيل الدخول كمسؤول للوصول إلى هذه الصفحة.');
        window.location.href = '/login';
    });
});
</script>

<div class="admin-container" dir="rtl">
    <!-- Welcome Banner -->
    <div class="welcome-section mb-4">
        <div class="welcome-banner p-4 rounded-4">
            <div class="row align-items-center">
                <div class="col-md-8 p-4">
                    <h2 class="welcome-title mb-2 p-2">لوحة تحكم الادمن </h2>
                    <p class="welcome-subtitle mb-0">مرحباً بك في لوحة التحكم</p>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                    <div class="dashboard-date">
                        <div class="current-date-card">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span id="currentDate"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-section">
        <!-- Filters and Stats -->
        <div class="filters-stats-section mb-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Role Filter -->
                        <div class="col-md-4">
                            <div class="filter-card">
                                <label for="roleFilter" class="filter-label">
                                    <i class="fas fa-filter text-primary"></i>
                                    تصفية حسب الدور
                                </label>
                                <select id="roleFilter" class="form-select custom-select">
                                    <option value="all" selected>جميع المستخدمين</option>
                                    <option value="trainee">المتدربين</option>
                                    <option value="instructor">المدربين</option>
                                    <option value="training_center">مراكز التدريب</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="col-md-4">
                            <div class="filter-card">
                                <label for="searchInput" class="filter-label">
                                    <i class="fas fa-search text-primary"></i>
                                    بحث
                                </label>
                                <div class="search-input-group">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" id="searchInput" class="form-control custom-input" 
                                           placeholder="البحث بالاسم أو البريد الإلكتروني...">
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="col-md-4">
                            <div class="filter-card">
                                <label class="filter-label">
                                    <i class="fas fa-chart-pie text-primary"></i>
                                    إحصائيات المستخدمين
                                </label>
                                <div class="stats-container">
                                    <div class="stat-item total">
                                        <div class="stat-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="stat-info">
                                            <span id="totalCount" class="stat-number">0</span>
                                            <span class="stat-label">الإجمالي</span>
                                        </div>
                                    </div>
                                    <div class="stat-item active">
                                        <div class="stat-icon">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div class="stat-info">
                                            <span id="activeCount" class="stat-number">0</span>
                                            <span class="stat-label">نشط</span>
                                        </div>
                                    </div>
                                    <div class="stat-item inactive">
                                        <div class="stat-icon">
                                            <i class="fas fa-user-times"></i>
                                        </div>
                                        <div class="stat-info">
                                            <span id="inactiveCount" class="stat-number">0</span>
                                            <span class="stat-label">غير نشط</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="users-section">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Loading State -->
                    <div class="loading-state" style="display: none;">
                        <div class="spinner-container">
                            <div class="spinner"></div>
                            <span>جاري تحميل البيانات...</span>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="table-container">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th class="text-center" width="80">#</th>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Dynamic Content -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        <ul class="pagination" id="pagination">
                            <!-- Dynamic Content -->
                        </ul>
                    </div>

                    <!-- States -->
                    <div class="no-results-state" style="display: none;">
                        <div class="state-content">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <h5>لا توجد نتائج</h5>
                            <p>لم يتم العثور على نتائج مطابقة لبحثك</p>
                        </div>
                    </div>

                    <div class="error-state" style="display: none;">
                        <div class="state-content">
                            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                            <h5>حدث خطأ</h5>
                            <p>حدث خطأ أثناء تحميل البيانات. يرجى المحاولة مرة أخرى</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@prepend('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@endprepend

@endsection
