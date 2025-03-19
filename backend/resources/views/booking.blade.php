@extends('app')

@section('content')
<div class="booking-container" dir="rtl">
    <!-- Header Section -->
    <div class="booking-header mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-content p-4 rounded-4">
                        <h1 class="booking-title mb-2">حجز جلسة تدريب</h1>
                        <p class="booking-subtitle">أكمل النموذج أدناه لحجز جلسة تدريب مع المدرب</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Form Section -->
    <div class="booking-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-5">
                        <div class="card-header bg-gradient-light p-3">
                            <h4 class="card-title mb-0"><i class="fas fa-calendar-check me-2 text-primary"></i>معلومات الحجز</h4>
                        </div>
                        <div class="card-body p-4">
                            <!-- Alert for success/errors -->
                            <div id="bookingAlert" class="alert d-none" role="alert"></div>

                            <form id="bookingForm">
                                <input type="hidden" id="trainer_id" name="trainer_id" value="{{ $trainer_id ??183 }}">
                                
                                <!-- Date & Time Row -->
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="date" class="form-label">تاريخ الجلسة <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="date" name="date" required min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="time" class="form-label">وقت الجلسة <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="time" name="time" required>
                                    </div>
                                </div>

                                <!-- Day Row -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="day" class="form-label">اليوم <span class="text-danger">*</span></label>
                                        <select class="form-select" id="day" name="day" required>
                                            <option value="" selected disabled>اختر اليوم</option>
                                            <option value="الأحد">الأحد</option>
                                            <option value="الإثنين">الإثنين</option>
                                            <option value="الثلاثاء">الثلاثاء</option>
                                            <option value="الأربعاء">الأربعاء</option>
                                            <option value="الخميس">الخميس</option>
                                            <option value="الجمعة">الجمعة</option>
                                            <option value="السبت">السبت</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>

                                <!-- Location Row -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="starting_location" class="form-label">موقع بدء الجلسة <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="starting_location" name="starting_location" rows="3" required placeholder="يرجى إدخال العنوان التفصيلي لنقطة البداية..."></textarea>
                                        <small class="text-muted">يرجى تحديد الموقع بدقة لضمان وصول المدرب في الوقت المحدد</small>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="notes" class="form-label">ملاحظات إضافية</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="أي معلومات إضافية ترغب في إخبار المدرب بها..."></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary px-5 py-2">
                                            <i class="fas fa-save me-2"></i>تأكيد الحجز
                                        </button>
                                        <a href="/trainers" class="btn btn-outline-secondary px-4 py-2 ms-2">
                                            <i class="fas fa-arrow-right me-2"></i>العودة
                                        </a>
                                    </div>
                                </div>
                            </form>
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
<style>
    .booking-container {
        padding: 20px;
        font-family: 'Cairo', sans-serif;
    }

    .booking-header .header-content {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }

    .booking-title {
        font-weight: 700;
        font-size: 2rem;
    }

    .booking-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: none;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }

    /* Toast Notifications */
    .toast-container {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        width: auto;
        max-width: 90%;
    }

    .toast {
        border-radius: 8px;
        color: white;
        padding: 15px 25px;
        margin-bottom: 10px;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slide-in 0.3s ease-out forwards;
        direction: rtl;
        text-align: right;
    }

    .toast.success {
        background-color: #28a745;
    }

    .toast.error {
        background-color: #dc3545;
    }

    .toast-content {
        display: flex;
        align-items: center;
    }

    .toast-icon {
        margin-left: 12px;
        font-size: 1.2rem;
    }

    .toast-close {
        margin-right: 10px;
        background: none;
        border: none;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .toast-close:hover {
        opacity: 1;
    }

    @keyframes slide-in {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fade-out {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .card {
            background-color: #2a2d3a;
            color: #e0e0e0;
        }
        
        .card-header {
            background: linear-gradient(135deg, #3a3f51, #2a2d3a);
        }
        
        .form-control, .form-select {
            background-color: #3a3f51;
            border-color: #4a5169;
            color: #e0e0e0;
        }
        
        .text-muted {
            color: #b0b0b0 !important;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .booking-title {
            font-size: 1.6rem;
        }
        
        .booking-subtitle {
            font-size: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }

        .toast {
            min-width: 250px;
        }
    }
</style>
@endprepend

<div class="toast-container" id="toastContainer"></div>

<script>
// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Get form element
    const form = document.getElementById('bookingForm');
    const alertBox = document.getElementById('bookingAlert');
    const toastContainer = document.getElementById('toastContainer');

    // Set today as min date
    document.getElementById('date').min = new Date().toISOString().split('T')[0];

    // Auto-update day when date changes
    document.getElementById('date').addEventListener('change', function() {
        const date = new Date(this.value);
        const days = ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
        const daySelect = document.getElementById('day');
        daySelect.value = days[date.getDay()];
    });

    // Toast notification function
    function showToast(message, type) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Create content
        const content = document.createElement('div');
        content.className = 'toast-content';
        
        // Create icon
        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        icon.innerHTML = type === 'success' 
            ? '<i class="fas fa-check-circle"></i>' 
            : '<i class="fas fa-exclamation-circle"></i>';
        
        // Create message
        const text = document.createElement('div');
        text.textContent = message;
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'toast-close';
        closeBtn.innerHTML = '&times;';
        closeBtn.onclick = function() {
            removeToast(toast);
        };
        
        // Assemble toast
        content.appendChild(icon);
        content.appendChild(text);
        toast.appendChild(content);
        toast.appendChild(closeBtn);
        
        // Add to container
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            removeToast(toast);
        }, 5000);
    }
    
    // Function to remove toast with animation
    function removeToast(toast) {
        toast.style.animation = 'fade-out 0.3s forwards';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent page refresh
        
        // Get form data
        const trainer_id = document.getElementById('trainer_id').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value + ':00'; // Add seconds
        const day = document.getElementById('day').value;
        const starting_location = document.getElementById('starting_location').value;
        const notes = document.getElementById('notes').value;
        
        // Validate required fields
        if (!date || !time || !day || !starting_location) {
            showToast('يرجى ملء جميع الحقول المطلوبة', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جارِ الحجز...';
        submitBtn.disabled = true;
        
        // Get token
        const token = localStorage.getItem('token');
        
        if (!token) {
            showToast('يرجى تسجيل الدخول أولاً', 'error');
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>تأكيد الحجز';
            submitBtn.disabled = false;
            return;
        }
        
        // Create request data
        const data = {
            trainer_id: 183,
            date: date,
            time: time,
            day: day,
            starting_location: starting_location,
            notes: notes
        };
        
        // Log data being sent
        console.log('Sending data:', data);
        
        // Make API call
        fetch('/api/booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(function(result) {
            console.log('API result:', result);
            
            // Reset button
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>تأكيد الحجز';
            submitBtn.disabled = false;
            
            if (result.message && result.Booking) {
                // Success
                showToast('تم حجز الجلسة بنجاح!', 'success');
                form.reset();
            } else {
                // Error
                showToast(result.error || 'حدث خطأ أثناء إنشاء الحجز', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            
            // Reset button
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>تأكيد الحجز';
            submitBtn.disabled = false;
            
            // Show error
            showToast('فشل الاتصال بالخادم', 'error');
        });
    });
});
</script>

@endsection
