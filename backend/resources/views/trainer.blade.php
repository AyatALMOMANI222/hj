@extends('app')

@section('content')
<div class="trainer-container" dir="rtl">
    <!-- Welcome Banner -->
    <div class="welcome-section mb-4">
        <div class="welcome-banner p-4 rounded-4">
            <div class="row align-items-center">
                <div class="col-md-8 p-4">
                    <h2 class="welcome-title mb-2 p-2">بحث عن مدربين</h2>
                    <p class="welcome-subtitle mb-0">ابحث عن مدربي القيادة المناسبين لاحتياجاتك</p>
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
        <!-- Filters Section -->
        <div class="filters-section mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-light p-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                    <h5 class="card-title mb-0"><i class="fas fa-filter me-2 text-primary"></i>تصفية المدربين</h5>
                    <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="filterCollapse">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-2">
                            <!-- Basic Filters Row -->
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <label for="trainingType" class="form-label small text-muted">نوع التدريب</label>
                                <select id="trainingType" name="training_type" class="form-select form-select-sm">
                                    <option value="" selected>جميع أنواع التدريب</option>
                                    <option value="beginner">مبتدئ</option>
                                    <option value="advanced">متقدم</option>
                                    <option value="highway_driving">قيادة على الطرق السريعة</option>
                                    <option value="city_driving">قيادة في المدينة</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <label for="carType" class="form-label small text-muted">نوع السيارة</label>
                                <select id="carType" name="car_type" class="form-select form-select-sm">
                                    <option value="" selected>جميع أنواع السيارات</option>
                                    <option value="sedan">سيدان</option>
                                    <option value="suv">دفع رباعي</option>
                                    <option value="truck">شاحنة</option>
                                    <option value="manual">ناقل عادي</option>
                                    <option value="automatic">ناقل أوتوماتيكي</option>
                                    <option value="electric">سيارة كهربائية</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <label for="language" class="form-label small text-muted">اللغة</label>
                                <select id="language" name="language" class="form-select form-select-sm">
                                    <option value="" selected>جميع اللغات</option>
                                    <option value="arabic">العربية</option>
                                    <option value="english">الإنجليزية</option>
                                    <option value="french">الفرنسية</option>
                                </select>
                            </div>

                            <!-- Experience & Rating Row -->
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="minExperience" class="form-label small text-muted">سنوات الخبرة</label>
                                <select id="minExperience" name="years_of_experience" class="form-select form-select-sm">
                                    <option value="" selected>جميع سنوات الخبرة</option>
                                    <option value="0,5">أقل من 5 سنوات</option>
                                    <option value="5,10">5-10 سنوات</option>
                                    <option value="10,100">أكثر من 10 سنوات</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="sessionDuration" class="form-label small text-muted">مدة الجلسة</label>
                                <select id="sessionDuration" name="session_duration" class="form-select form-select-sm">
                                    <option value="" selected>جميع المدد</option>
                                    <option value="30">30 دقيقة</option>
                                    <option value="45">45 دقيقة</option>
                                    <option value="60">ساعة</option>
                                    <option value="90">ساعة ونصف</option>
                                    <option value="120">ساعتان</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="maxPrice" class="form-label small text-muted">الحد الأقصى للسعر</label>
                                <input type="number" id="maxPrice" name="session_price" class="form-control form-control-sm" min="0" step="0.01">
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="minRating" class="form-label small text-muted">تقييم المدرب</label>
                                <select id="minRating" name="min_rating" class="form-select form-select-sm">
                                    <option value="" selected>جميع التقييمات</option>
                                    <option value="5">5 نجوم فقط</option>
                                    <option value="4">4 نجوم فأكثر</option>
                                    <option value="3">3 نجوم فأكثر</option>
                                    <option value="2">2 نجوم فأكثر</option>
                                    <option value="1">1 نجمة فأكثر</option>
                                </select>
                            </div>

                            <!-- Time & Type Row -->
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="sessionTime" class="form-label small text-muted">وقت الجلسة</label>
                                <select id="sessionTime" name="session_time" class="form-select form-select-sm">
                                    <option value="" selected>جميع الأوقات</option>
                                    <option value="morning">صباحاً</option>
                                    <option value="afternoon">ظهراً</option>
                                    <option value="evening">مساءً</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="ageGroup" class="form-label small text-muted">الفئة العمرية</label>
                                <select id="ageGroup" name="age" class="form-select form-select-sm">
                                    <option value="" selected>جميع الفئات العمرية</option>
                                    <option value="under_30">أقل من 30 سنة</option>
                                    <option value="between_30_40">30-40 سنة</option>
                                    <option value="over_40">أكثر من 40 سنة</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="licenseType" class="form-label small text-muted">نوع الرخصة</label>
                                <select id="licenseType" name="license_type" class="form-select form-select-sm">
                                    <option value="" selected>جميع الرخص</option>
                                    <option value="private">خاصة</option>
                                    <option value="motorcycle">دراجة نارية</option>
                                    <option value="truck">شاحنة</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="location" class="form-label small text-muted">الموقع</label>
                                <input type="text" id="location" name="location" class="form-control form-control-sm" placeholder="ادخل المدينة أو المنطقة">
                            </div>

                            <!-- Special Options Row -->
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <label for="specialTraining" class="form-label small text-muted">برامج تدريبية خاصة</label>
                                <select id="specialTraining" name="special_training_programs" class="form-select form-select-sm">
                                    <option value="" selected>الكل</option>
                                    <option value="women">تدريب النساء</option>
                                    <option value="elderly">تدريب كبار السن</option>
                                    <option value="special_needs">ذوي الاحتياجات الخاصة</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <label class="form-label small text-muted d-block">خيارات إضافية</label>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" id="fieldTraining" name="field_training_available" value="1">
                                    <label class="form-check-label small" for="fieldTraining">تدريب ميداني متاح</label>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <label class="form-label small text-muted d-block">الإعداد للاختبار</label>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" id="testPreparation" name="test_preparation" value="on">
                                    <label class="form-check-label small" for="testPreparation">الإعداد للاختبار متاح</label>
                                </div>
                            </div>

                            <!-- Submit Row -->
                            <div class="col-12 text-center mt-3 pt-2 border-top">
                                <button type="submit" class="btn btn-primary btn-sm px-4">
                                    <i class="fas fa-search me-1"></i>بحث
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-sm ms-2">
                                    <i class="fas fa-redo me-1"></i>إعادة تعيين
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trainers Results Section -->
        <div class="trainers-section">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Loading State -->
                    <div class="loading-state" style="display: none;">
                        <div class="spinner-container">
                            <div class="spinner"></div>
                            <span>جاري البحث عن المدربين...</span>
                        </div>
                    </div>

                    <!-- Results Container -->
                    <div class="results-container">
                        <div class="row" id="trainersContainer">
                            <!-- Dynamic content will be added here -->
                        </div>
                    </div>

                    <!-- States -->
                    <div class="no-results-state" style="display: none;">
                        <div class="state-content">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <h5>لا توجد نتائج</h5>
                            <p>لم يتم العثور على مدربين مطابقين لمعايير البحث</p>
                        </div>
                    </div>

                    <div class="error-state" style="display: none;">
                        <div class="state-content">
                            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                            <h5>حدث خطأ</h5>
                            <p>حدث خطأ أثناء البحث عن المدربين. يرجى المحاولة مرة أخرى</p>
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
<link rel="stylesheet" href="{{ asset('css/trainer.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/trainer.js') }}" defer></script>
@endprepend

@endsection
