@extends('app')

@section('content')
<div class="profile-container py-5" dir="rtl">
    <div class="container">
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="text-center py-5" style="display: none;">
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
            <p class="mt-3 text-muted fw-light">جاري تحميل البيانات...</p>
        </div>

        <div id="profileContent" class="row g-4" style="display: none;">
            <!-- Profile Header -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="profile-header position-relative">
                            <!-- Cover Image -->
                            <div class="profile-cover" style="height: 150px; background: linear-gradient(45deg, #2575fc, #6a11cb);"></div>
                            
                            <!-- Profile Image and Basic Info -->
                            <div class="profile-info px-4 pb-4">
                                <div class="d-flex flex-wrap align-items-end position-relative" style="margin-top: -50px;">
                                    <div class="profile-image-container me-4">
                                        <div class="profile-image rounded-circle border-4 border-white shadow" 
                                             style="width: 150px; height: 150px; overflow: hidden; border-style: solid;">
                                            <img id="userImage" src="" alt="" class="w-100 h-100 object-fit-cover d-none">
                                            <div id="profileImagePlaceholder" class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user fa-3x text-primary opacity-50"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-text mt-3 mt-sm-0 flex-grow-1" >
                                        <h3 class="mb-1 fw-bold" id="userName" style="margin-top: 50px;">...</h3>
                                        <p class="text-muted mb-2" id="userEmail">...</p>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge bg-gradient-primary px-3 py-2 rounded-pill" id="userRole">...</span>
                                            <a href="#" id="updateProfileBtn" class="btn btn-sm ms-3 px-3 py-2 rounded-pill shadow-sm" style="background: linear-gradient(45deg, #20c997, #28a745); color: white; transition: all 0.3s ease;margin-right:550px;">
                                                <i class="fas fa-user-edit me-1"></i> تعديل الملف الشخصي
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="col-12">
                <div class="row g-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                        <i class="fas fa-calendar-alt fa-lg"></i>
                                    </div>
                                    <h6 class="card-title mb-0 text-muted">العمر</h6>
                                </div>
                                <h3 class="mb-0 fw-bold" id="userAge">-</h3>
                                <small class="text-muted">سنة</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                        <i class="fas fa-star fa-lg"></i>
                                    </div>
                                    <h6 class="card-title mb-0 text-muted">سنوات الخبرة</h6>
                                </div>
                                <h3 class="mb-0 fw-bold" id="userExperience">-</h3>
                                <small class="text-muted">سنوات</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                                        <i class="fas fa-clock fa-lg"></i>
                                    </div>
                                    <h6 class="card-title mb-0 text-muted">الجلسات المكتملة</h6>
                                </div>
                                <h3 class="mb-0 fw-bold" id="completedSessions">0</h3>
                                <small class="text-muted">جلسة</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                                        <i class="fas fa-users fa-lg"></i>
                                    </div>
                                    <h6 class="card-title mb-0 text-muted">التقييم</h6>
                                </div>
                                <h3 class="mb-0 fw-bold" id="userRating">-</h3>
                                <small class="text-muted">من 5 نجوم</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 d-flex align-items-center">
                            <span class="bg-gradient-primary text-white rounded-circle p-2 me-2">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            معلومات الحساب
                        </h5>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-group p-3 bg-light rounded-4 h-100">
                                    <label class="text-muted small mb-1">الاسم الكامل</label>
                                    <div class="detail-value fw-medium" id="fullName">...</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group p-3 bg-light rounded-4 h-100">
                                    <label class="text-muted small mb-1">رقم الهاتف</label>
                                    <div class="detail-value fw-medium" id="phoneNumber">...</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group p-3 bg-light rounded-4 h-100">
                                    <label class="text-muted small mb-1">العنوان</label>
                                    <div class="detail-value fw-medium" id="address">...</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group p-3 bg-light rounded-4 h-100">
                                    <label class="text-muted small mb-1">تاريخ الانضمام</label>
                                    <div class="detail-value fw-medium" id="joinDate">...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Stats -->
            <div class="col-lg-4">
                <!-- Trainer Information -->
                <div id="trainerInfo" class="card border-0 shadow-sm rounded-4 mb-4" style="display: none;">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 d-flex align-items-center">
                            <span class="bg-gradient-success text-white rounded-circle p-2 me-2">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </span>
                            معلومات التدريب
                        </h5>
                        <div class="trainer-details">
                            <div class="detail-item mb-3 p-3 bg-light rounded-4">
                                <label class="text-muted small mb-1">نوع التدريب</label>
                                <div class="detail-value fw-medium" id="trainingType">...</div>
                            </div>
                            <div class="detail-item mb-3 p-3 bg-light rounded-4">
                                <label class="text-muted small mb-1">نوع السيارة</label>
                                <div class="detail-value fw-medium" id="carType">...</div>
                            </div>
                            <div class="detail-item mb-3 p-3 bg-light rounded-4">
                                <label class="text-muted small mb-1">سعر الجلسة</label>
                                <div class="detail-value fw-medium" id="sessionPrice">...</div>
                            </div>
                            <div class="detail-item p-3 bg-light rounded-4">
                                <label class="text-muted small mb-1">مدة الجلسة</label>
                                <div class="detail-value fw-medium" id="sessionDuration">...</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 d-flex align-items-center">
                            <span class="bg-gradient-warning text-white rounded-circle p-2 me-2">
                                <i class="fas fa-clock"></i>
                            </span>
                            النشاط الأخير
                        </h5>
                        <div id="recentActivity" class="activity-timeline">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-history fa-2x mb-3"></i>
                                <p class="mb-0">لا يوجد نشاط حديث</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-container {
    background-color: #f8f9fa;
    min-height: calc(100vh - 60px);
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-group {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,.05);
}

.detail-group:hover {
    background-color: #e9ecef !important;
    transform: translateY(-2px);
}

.detail-value {
    color: #2575fc;
    font-size: 1.1rem;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #2575fc, #6a11cb);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
}

.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #0dcaf0);
}

.activity-timeline {
    position: relative;
}

.activity-item {
    position: relative;
    padding-right: 30px;
    padding-bottom: 1.5rem;
    border-right: 2px solid #e9ecef;
}

.activity-item::before {
    content: '';
    position: absolute;
    right: -9px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #2575fc;
}

.activity-item:last-child {
    padding-bottom: 0;
}

.loading-animation {
    display: inline-flex;
    align-items: center;
}

.spinner-grow {
    width: 1rem;
    height: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

#profileContent {
    animation: fadeIn 0.5s ease-out;
}

@media (max-width: 768px) {
    .profile-info {
        text-align: center;
    }
    
    .profile-image-container {
        margin: 0 auto 1rem;
    }
    
    .profile-text {
        width: 100%;
        text-align: center;
    }
}
</style>

<!-- Include the Update Profile Modal -->
@include('update-modal')

@prepend('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endprepend

<script>
// Define the storage base URL
const STORAGE_BASE_URL = '{{ url("storage") }}/';

document.addEventListener('DOMContentLoaded', async function() {
    const loadingSpinner = document.getElementById('loadingSpinner');
    const profileContent = document.getElementById('profileContent');
    const userImage = document.getElementById('userImage');
    const profileImagePlaceholder = document.getElementById('profileImagePlaceholder');

    // Show loading spinner
    loadingSpinner.style.display = 'block';
    profileContent.style.display = 'none';

    try {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = "{{ route('login.view') }}";
            return;
        }

        const response = await fetch("/api/user/token/2", {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.message || 'Failed to fetch user data');
        }

        const user = data.user;
        console.log('User data:', user);

        // Handle profile image - simple approach
        if (user.profile_picture) {
            console.log('Profile picture found:', user.profile_picture);
            
            // Set image source based on path format
            if (user.profile_picture.startsWith('http')) {
                // Already a full URL
                userImage.src = user.profile_picture;
            } else {
                // Handle relative path
                const picturePath = user.profile_picture.startsWith('/') ? 
                    user.profile_picture.substring(1) : user.profile_picture;
                userImage.src = STORAGE_BASE_URL + picturePath;
            }
            
            // Show image, hide placeholder
            userImage.classList.remove('d-none');
            profileImagePlaceholder.classList.add('d-none');
        } else {
            // No image available, show placeholder
            userImage.classList.add('d-none');
            profileImagePlaceholder.classList.remove('d-none');
        }
        
        // Update user information
        document.getElementById('userName').textContent = user.name || 'غير محدد';
        document.getElementById('userEmail').textContent = user.email || 'غير محدد';
        document.getElementById('userRole').textContent = translateRole(user.role) || 'غير محدد';
        document.getElementById('fullName').textContent = user.name || 'غير محدد';
        document.getElementById('phoneNumber').textContent = user.phone || 'غير محدد';
        document.getElementById('address').textContent = user.address || 'غير محدد';
        document.getElementById('joinDate').textContent = formatDate(user.created_at) || 'غير محدد';
        document.getElementById('userAge').textContent = user.age || '-';
        document.getElementById('userExperience').textContent = user.years_of_experience || '-';
        document.getElementById('userRating').textContent = user.rating ? user.rating.toFixed(1) : '-';

        // Show trainer-specific information if user is a trainer
        if (user.role === 'trainer') {
            document.getElementById('trainerInfo').style.display = 'block';
            document.getElementById('trainingType').textContent = translateTrainingType(user.training_type) || 'غير محدد';
            document.getElementById('carType').textContent = translateCarType(user.car_type) || 'غير محدد';
            document.getElementById('sessionPrice').textContent = user.session_price ? user.session_price + ' ريال' : 'غير محدد';
            document.getElementById('sessionDuration').textContent = user.session_duration ? user.session_duration + ' دقيقة' : 'غير محدد';
        }

        // Hide loading spinner and show content
        loadingSpinner.style.display = 'none';
        profileContent.style.display = 'block';

    } catch (error) {
        console.error('Error fetching user data:', error);
        loadingSpinner.style.display = 'none';
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };
        toastr.error('حدث خطأ أثناء تحميل بيانات المستخدم. الرجاء المحاولة مرة أخرى.');
        
        if (error.message.includes('401')) {
            setTimeout(() => {
                window.location.href = "{{ route('login.view') }}";
            }, 2000);
        }
    }
});

function translateRole(role) {
    const roles = {
        'admin': 'مدير النظام',
        'trainer': 'مدرب',
        'trainee': 'متدرب'
    };
    return roles[role] || role;
}

function translateTrainingType(type) {
    const types = {
        'beginner': 'مبتدئ',
        'advanced': 'متقدم',
        'highway_driving': 'قيادة على الطرق السريعة',
        'city_driving': 'قيادة في المدينة'
    };
    return types[type] || type;
}

function translateCarType(type) {
    const types = {
        'sedan': 'سيدان',
        'suv': 'دفع رباعي',
        'truck': 'شاحنة',
        'manual': 'ناقل عادي',
        'automatic': 'ناقل أوتوماتيكي',
        'electric': 'سيارة كهربائية'
    };
    return types[type] || type;
}

function formatDate(dateString) {
    if (!dateString) return null;
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('ar-SA', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(date);
}

// Update Profile Button Interaction
document.addEventListener('DOMContentLoaded', function() {
    const updateBtn = document.getElementById('updateProfileBtn');
    
    if (updateBtn) {
        // Hover effects
        updateBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(40, 167, 69, 0.4)';
        });
        
        updateBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.15)';
        });
        
        // Click handler
        updateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Open the update profile modal instead of showing a toast
            const updateProfileModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
            updateProfileModal.show();
        });
    }
});
</script>

@endsection

