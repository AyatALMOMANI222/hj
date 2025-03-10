@extends('app')

@section('content')
<script>
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
                    <h2 class="welcome-title mb-2 p-2"  style="padding:3px 15px;">لوحة تحكم الادمن </h2>
                    <p class="welcome-subtitle mb-0" style="padding:3px 15px;">مرحباً بك في لوحة التحكم</p>
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

<!-- CSS Styles -->
<style>
    /* Base Styles */
    .admin-container {
        background-color: #f8f9fc;
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Cairo', sans-serif;
    }

    /* Welcome Section */
    .welcome-section {
        margin-bottom: 2rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #2b354f 0%, #1a1f2f 100%);
        color: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5z' fill='%23ffffff' fill-opacity='0.05'/%3E%3C/svg%3E");
        opacity: 0.1;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.8;
    }

    .current-date-card {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        background: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.15);
    }

    /* Filters */
    .filter-card {
        padding: 1rem;
    }

    .filter-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #2b354f;
        margin-bottom: 0.75rem;
    }

    .filter-label i {
        margin-left: 0.5rem;
    }

    .custom-select {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.75rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .custom-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    .search-input-group {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6e707e;
    }

    .custom-input {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.75rem;
        padding-left: 2.5rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .custom-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    /* Stats */
    .stats-container {
        display: flex;
        gap: 1rem;
    }

    .stat-item {
        flex: 1;
        padding: 1rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        color: white;
    }

    .stat-item.total {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .stat-item.active {
        background: linear-gradient(135deg, #1cc88a 0%, #169a6b 100%);
    }

    .stat-item.inactive {
        background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        margin-left: 1rem;
    }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    /* Table */
    .table-container {
        overflow-x: auto;
    }

    .custom-table {
        margin: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        background: #f8f9fc;
        padding: 1rem;
        font-weight: 600;
        color: #2b354f;
        border: none;
        font-size: 0.9rem;
    }

    .custom-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        font-size: 0.9rem;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background: #f8f9fc;
        transform: scale(1.01);
    }

    /* Badges */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .badge-role {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }

    .badge-status-active {
        background: linear-gradient(135deg, #1cc88a 0%, #169a6b 100%);
        color: white;
    }

    .badge-status-inactive {
        background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
        color: white;
    }

    /* Action Buttons */
    .btn-icon {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        margin: 0 0.25rem;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
    }

    /* States */
    .loading-state,
    .no-results-state,
    .error-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .state-content {
        max-width: 400px;
        margin: 0 auto;
    }

    .state-content i {
        color: #6e707e;
        margin-bottom: 1rem;
    }

    .state-content h5 {
        color: #2b354f;
        margin-bottom: 0.5rem;
    }

    .state-content p {
        color: #6e707e;
        font-size: 0.9rem;
    }

    /* Pagination */
    .pagination-container {
        padding: 1rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .page-link {
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        color: #2b354f;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background: #f8f9fc;
        color: #4e73df;
    }

    .page-item.active .page-link {
        background: #4e73df;
        color: white;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .admin-container {
            padding: 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.75rem;
        }
        
        .stats-container {
            flex-wrap: wrap;
        }
        
        .stat-item {
            flex: 0 0 calc(50% - 0.5rem);
        }
    }

    @media (max-width: 992px) {
        .admin-container {
            padding: 1rem;
        }
        
        .welcome-banner {
            padding: 1.5rem !important;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .filter-card {
            margin-bottom: 1rem;
        }
        
        .custom-table thead th {
            font-size: 0.85rem;
            padding: 0.75rem;
        }
        
        .custom-table tbody td {
            font-size: 0.85rem;
            padding: 0.75rem;
        }
        
        .btn-icon-text {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        .welcome-section .row {
            flex-direction: column;
        }
        
        .dashboard-date {
            justify-content: flex-start !important;
            margin-top: 1rem;
        }
        
        .stats-container {
            flex-direction: column;
        }
        
        .stat-item {
            flex: 0 0 100%;
            margin-bottom: 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
        
        .user-info h6 {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .admin-container {
            padding: 0.5rem;
        }
        
        .welcome-banner {
            padding: 1rem !important;
        }
        
        .welcome-title {
            font-size: 1.25rem;
        }
        
        .welcome-subtitle {
            font-size: 0.9rem;
        }
        
        .filter-label {
            font-size: 0.85rem;
        }
        
        .table-container {
            margin: 0 -0.5rem;
        }
        
        .custom-table {
            font-size: 0.8rem;
        }
        
        .user-avatar img {
            width: 35px;
            height: 35px;
        }
        
        .badge {
            padding: 0.35rem 0.7rem;
            font-size: 0.7rem;
        }
        
        .pagination .page-link {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        /* Hide less important columns on mobile */
        .custom-table th:nth-child(4),
        .custom-table td:nth-child(4) {
            display: none;
        }
    }

    /* Table Responsive Scroll */
    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
        border-radius: 15px;
    }

    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Card Responsive Adjustments */
    .card {
        margin-bottom: 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 0.75rem;
        }
    }

    /* Loading State Responsive */
    .loading-state, 
    .no-results-state, 
    .error-state {
        padding: 2rem 1rem;
    }

    @media (max-width: 576px) {
        .loading-state, 
        .no-results-state, 
        .error-state {
            padding: 1.5rem 0.75rem;
        }
        
        .state-content i {
            font-size: 2rem;
        }
        
        .state-content h5 {
            font-size: 1rem;
        }
        
        .state-content p {
            font-size: 0.8rem;
        }
    }

    /* New styles for user row */
    .user-row {
        transition: all 0.2s ease;
    }

    .user-row:hover {
        background-color: #f8f9fc;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .user-avatar img {
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .user-avatar img:hover {
        transform: scale(1.1);
    }

    .user-name {
        color: #2b354f;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .action-buttons .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .action-buttons .btn-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 5px rgba(0,0,0,0.2);
    }

    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 50px;
    }

    .badge-role {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }

    .badge-status-active {
        background: linear-gradient(135deg, #1cc88a 0%, #169a6b 100%);
        color: white;
    }

    .badge-status-inactive {
        background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
        color: white;
    }

    /* Add new button styles */
    .btn-soft-primary {
        color: #4e73df;
        background-color: rgba(78, 115, 223, 0.1);
        border: 1px solid transparent;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-soft-primary:hover {
        color: #fff;
        background-color: #4e73df;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(78, 115, 223, 0.2);
    }

    .btn-soft-danger {
        color: #e74a3b;
        background-color: rgba(231, 74, 59, 0.1);
        border: 1px solid transparent;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-soft-danger:hover {
        color: #fff;
        background-color: #e74a3b;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(231, 74, 59, 0.2);
    }

    .btn-icon-text {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .btn-icon-text i {
        font-size: 1rem;
        margin-left: 0.5rem;
    }

    /* Update action buttons container */
    .action-buttons {
        gap: 0.75rem !important;
    }
</style>

<!-- JavaScript for User Management -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cache DOM elements
        const elements = {
            currentDate: document.getElementById('currentDate'),
            roleFilter: document.getElementById('roleFilter'),
            searchInput: document.getElementById('searchInput'),
            usersTableBody: document.getElementById('usersTableBody'),
            loadingState: document.querySelector('.loading-state'),
            tableContainer: document.querySelector('.table-container'),
            noResultsState: document.querySelector('.no-results-state'),
            errorState: document.querySelector('.error-state'),
            totalCountEl: document.getElementById('totalCount'),
            activeCountEl: document.getElementById('activeCount'),
            inactiveCountEl: document.getElementById('inactiveCount'),
            pagination: document.getElementById('pagination')
        };

        // State management
        const state = {
            allUsers: [],
            filteredUsers: [],
            currentPage: 1,
            usersPerPage: 10,
            isInitialLoad: true,
            lastTableHTML: '',
            lastPaginationHTML: '',
            searchTerm: '',
            currentRole: 'all'
        };

        // Set current date once
        const today = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        elements.currentDate.textContent = today.toLocaleDateString('ar-SA', options);

        // Add memoization helper
        const memoize = {
            lastValues: {},
            hasChanged: function(key, newValue) {
                const changed = JSON.stringify(this.lastValues[key]) !== JSON.stringify(newValue);
                if (changed) {
                    this.lastValues[key] = JSON.parse(JSON.stringify(newValue));
                }
                return changed;
            }
        };

        // Optimized debounce function
        function debounce(func, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Optimize table rendering with memoization
        function renderTableEfficiently() {
            const hasUsers = state.filteredUsers.length > 0;
            const displayState = {
                table: hasUsers ? 'block' : 'none',
                noResults: hasUsers ? 'none' : 'block'
            };

            // Only update display if changed
            if (memoize.hasChanged('displayState', displayState)) {
                elements.tableContainer.style.display = displayState.table;
                elements.noResultsState.style.display = displayState.noResults;
            }

            if (!hasUsers) {
                elements.pagination.innerHTML = '';
                return;
            }

            const startIdx = (state.currentPage - 1) * state.usersPerPage;
            const endIdx = startIdx + state.usersPerPage;
            const usersToDisplay = state.filteredUsers.slice(startIdx, endIdx);
            const totalPages = Math.ceil(state.filteredUsers.length / state.usersPerPage);

            // Only update table if data changed
            if (memoize.hasChanged('tableData', usersToDisplay)) {
                const newTableHTML = generateTableHTML(usersToDisplay, startIdx);
                elements.usersTableBody.innerHTML = newTableHTML;
            }

            // Only update pagination if page state changed
            const paginationState = { currentPage: state.currentPage, totalPages };
            if (memoize.hasChanged('paginationState', paginationState)) {
                const newPaginationHTML = generatePaginationHTML(totalPages);
                elements.pagination.innerHTML = newPaginationHTML;
            }
        }

        // Optimize search with better debounce and memoization
        const handleSearch = debounce(() => {
            const newSearchTerm = elements.searchInput.value.trim().toLowerCase();
            
            // Skip if search term hasn't changed
            if (!memoize.hasChanged('searchTerm', newSearchTerm)) return;
            
            state.searchTerm = newSearchTerm;
            const newFilteredUsers = state.allUsers.filter(user => 
                (user.name && user.name.toLowerCase().includes(state.searchTerm)) ||
                (user.email && user.email.toLowerCase().includes(state.searchTerm))
            );
            
            // Only update if results changed
            if (memoize.hasChanged('filteredUsers', newFilteredUsers)) {
                state.filteredUsers = newFilteredUsers;
                state.currentPage = 1;
                renderTableEfficiently();
            }
        }, 300);

        // Optimize role filter
        elements.roleFilter.addEventListener('change', () => {
            const newRole = elements.roleFilter.value;
            if (memoize.hasChanged('currentRole', newRole)) {
                state.currentRole = newRole;
                fetchUsers(state.currentRole);
            }
        });

        // Optimize counters update
        function updateCounters() {
            const counts = {
                total: state.allUsers.length,
                active: state.allUsers.filter(user => user.is_active === true || user.is_active === 1).length
            };
            
            // Only update if counts changed
            if (memoize.hasChanged('counts', counts)) {
                elements.totalCountEl.textContent = counts.total;
                elements.activeCountEl.textContent = counts.active;
                elements.inactiveCountEl.textContent = counts.total - counts.active;
            }
        }

        // Optimize pagination handler
        elements.pagination.addEventListener('click', (e) => {
            e.preventDefault();
            const pageLink = e.target.closest('.page-link');
            if (!pageLink) return;

            const newPage = parseInt(pageLink.dataset.page);
            if (newPage && newPage !== state.currentPage && newPage > 0) {
                if (memoize.hasChanged('currentPage', newPage)) {
                    state.currentPage = newPage;
                    renderTableEfficiently();
                }
            }
        });

        // Optimize process users
        function processUsers() {
            if (!Array.isArray(state.allUsers)) {
                console.error('allUsers is not an array:', state.allUsers);
                state.allUsers = [];
            }
            
            const newFilteredUsers = [...state.allUsers];
            if (memoize.hasChanged('processedUsers', newFilteredUsers)) {
                state.filteredUsers = newFilteredUsers;
                if (state.isInitialLoad) {
                    updateCounters();
                    state.isInitialLoad = false;
                }
                renderTableEfficiently();
            }
            
            elements.loadingState.style.display = 'none';
        }

        // Add missing fetch functions
        function showLoadingState() {
            elements.loadingState.style.display = 'flex';
            elements.tableContainer.style.display = 'none';
            elements.noResultsState.style.display = 'none';
            elements.errorState.style.display = 'none';
        }

        function fetchUsers(role) {
            showLoadingState();
            const token = localStorage.getItem('token');
            
            if (role === 'all') {
                Promise.all([
                    fetchUserType('trainee', token),
                    fetchUserType('instructor', token),
                    fetchUserType('training_center', token)
                ])
                .then(([trainees, instructors, centers]) => {
                    const traineeUsers = extractUsers(trainees, 'trainee');
                    const instructorUsers = extractUsers(instructors, 'instructor');
                    const centerUsers = extractUsers(centers, 'training_center');
                    
                    state.allUsers = [...traineeUsers, ...instructorUsers, ...centerUsers];
                    processUsers();
                })
                .catch(handleFetchError);
            } else {
                fetchUserType(role, token)
                    .then(data => {
                        state.allUsers = extractUsers(data, role);
                        processUsers();
                    })
                    .catch(handleFetchError);
            }
        }

        function fetchUserType(type, token) {
            return fetch(`/api/user/${type}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            });
        }

        function extractUsers(response, role) {
            let users = [];
            if (Array.isArray(response)) {
                users = response;
            } else if (response.data) {
                users = Array.isArray(response.data) ? response.data : [response.data];
            } else if (response.users) {
                users = Array.isArray(response.users) ? response.users : [response.users];
            } else if (response.user) {
                users = Array.isArray(response.user) ? response.user : [response.user];
            }
            return users.map(user => ({ ...user, role }));
        }

        function handleFetchError(error) {
            console.error('Error fetching users:', error);
            elements.loadingState.style.display = 'none';
            elements.errorState.style.display = 'flex';
            elements.tableContainer.style.display = 'none';
        }

        function generateTableHTML(users, startIdx) {
            return users.map((user, index) => {
                const roleText = translateRole(user.role);
                const isActive = user.is_active === true || user.is_active === 1;
                const statusClass = isActive ? 'badge-status-active' : 'badge-status-inactive';
                const statusText = isActive ? 'نشط' : 'غير نشط';
                const avatarUrl = user.profile_picture ? 
                    `/storage/${user.profile_picture}` : 
                    '/storage/default-avatar.png';

                return `
                    <tr class="user-row">
                        <td class="text-center align-middle">${startIdx + index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar">
                                    <img src="${avatarUrl}" alt="${user.name || 'User'}" 
                                         class="rounded-circle" width="40" height="40"
                                         onerror="this.src='/storage/default-avatar.png'"
                                         loading="lazy">
                                </div>
                                <div class="user-info">
                                    <h6 class="user-name mb-0">${user.name || 'لا يوجد اسم'}</h6>
                                    ${user.center_name ? `<small class="text-muted">${user.center_name}</small>` : ''}
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">${user.email || 'لا يوجد بريد إلكتروني'}</td>
                        <td class="align-middle">${user.phone || 'لا يوجد رقم هاتف'}</td>
                        <td class="align-middle">
                            <span class="badge badge-role">${roleText}</span>
                        </td>
                        <td class="align-middle">
                            <span class="badge ${statusClass}">${statusText}</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="action-buttons d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-soft-primary btn-icon-text">
                                    <i class="fas fa-user-circle me-1"></i>
                                    عرض المستخدم
                                </button>
                                <button type="button" class="btn btn-soft-danger btn-icon-text">
                                    <i class="fas fa-user-times me-1"></i>
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function generatePaginationHTML(totalPages) {
            if (totalPages <= 1) return '';

            let html = `
                <li class="page-item ${state.currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${state.currentPage - 1}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;

            for (let i = 1; i <= totalPages; i++) {
                html += `
                    <li class="page-item ${state.currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
            }

            html += `
                <li class="page-item ${state.currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${state.currentPage + 1}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;

            return html;
        }

        function translateRole(role) {
            const roles = {
                'trainee': 'متدرب',
                'instructor': 'مدرب',
                'training_center': 'مركز تدريب',
                'admin': 'مدير النظام'
            };
            return roles[role] || role;
        }

        // Initial load
        fetchUsers('all');
    });
</script>

@prepend('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endprepend

@endsection
