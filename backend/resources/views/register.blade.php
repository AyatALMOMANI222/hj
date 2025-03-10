@extends('app')

@section('content')
<div class="register-container d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="card shadow-lg p-5 rounded-4" style="width: 100%; max-width: 650px; background-color: #ffffff; border: none; margin: 15px 0;">
        <div class="text-center mb-4">
            <h3 style="color: #3a3a3a; font-weight: 700; position: relative; display: inline-block;">
                إنشاء حساب
                <span style="position: absolute; bottom: -10px; right: 0; left: 0; height: 3px; background: linear-gradient(to left, #4e73df, #224abe); width: 50%; margin: 0 auto;"></span>
            </h3>
        </div>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3 border-0 mb-4">
            <ul class="mb-0 pe-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <style>
            body {
                font-family: 'Cairo', sans-serif;
                direction: rtl;
                text-align: right;
                background-color: #f8f9fa;
            }

            h3, label, input, select, button, small, p {
                font-family: 'Cairo', sans-serif;
            }

            .form-control, .form-select {
                border-radius: 12px;
                padding: 12px 15px;
                border: 1px solid #e0e0e0;
                box-shadow: none;
                transition: all 0.3s ease;
                text-align: right;
                font-size: 14px;
            }

            .form-control:focus, .form-select:focus {
                border-color: #4e73df;
                box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            }

            .input-group-text {
                border-radius: 0 12px 12px 0 !important;
                background-color: #f8f9fc !important;
                border-color: #e0e0e0;
                color: #6c757d;
            }

            .form-control, .form-select {
                border-radius: 12px 0 0 12px !important;
            }

            .btn-primary {
                background: linear-gradient(to left, #4e73df, #224abe);
                border: none;
                padding: 12px 20px;
                font-weight: 600;
                transition: all 0.3s ease;
                border-radius: 50px;
            }

            .btn-primary:hover {
                background: linear-gradient(to left, #224abe, #1a3a94);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
            }

            .form-check-input {
                width: 20px;
                height: 20px;
                margin-left: 0.5rem;
                margin-right: 0;
            }

            .form-check-label {
                padding-right: 0;
            }

            .section-header {
                color: #4e73df;
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 1.25rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid #e0e0e0;
                position: relative;
            }

            .section-header::after {
                content: '';
                position: absolute;
                bottom: -1px;
                right: 0;
                width: 20%;
                height: 3px;
                background: linear-gradient(to left, #4e73df, #224abe);
                border-radius: 3px;
            }

            .form-file-label {
                display: block;
                margin-bottom: 0.5rem;
                color: #4e73df;
                font-size: 0.9rem;
                font-weight: 600;
            }

            .card {
                border-radius: 20px;
            }

            .card:hover {
                transform: none;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
            }
            
            .form-check {
                padding-right: 1.8em;
                padding-left: 0;
                text-align: right;
            }
            
            .form-check .form-check-input {
                float: right;
                margin-right: -1.8em;
            }
            
            .form-switch {
                padding-right: 2.5em;
            }
            
            .form-switch .form-check-input {
                margin-right: -2.5em;
                margin-left: 0.5em;
            }
            
            .form-text {
                color: #6c757d;
                font-size: 0.85rem;
            }
            
            .input-group .form-control {
                text-align: right;
            }
            
            /* Decorative elements */
            .decorative-dot {
                position: absolute;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: linear-gradient(45deg, #4e73df, #224abe);
                z-index: -1;
                opacity: 0.7;
            }
            
            .register-container {
                position: relative;
                overflow: hidden;
                padding: 2rem 0;
            }
            
            .register-container::before {
                content: '';
                position: absolute;
                top: -50px;
                right: -50px;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: radial-gradient(rgba(78, 115, 223, 0.2), rgba(78, 115, 223, 0));
                z-index: 0;
            }
            
            .register-container::after {
                content: '';
                position: absolute;
                bottom: -80px;
                left: -80px;
                width: 200px;
                height: 200px;
                border-radius: 50%;
                background: radial-gradient(rgba(78, 115, 223, 0.15), rgba(78, 115, 223, 0));
                z-index: 0;
            }
        </style>
        
        <!-- Decorative dots -->
        <div class="decorative-dot" style="top: 20px; right: 20px;"></div>
        <div class="decorative-dot" style="bottom: 50px; left: 30px;"></div>
        <div class="decorative-dot" style="top: 50%; right: 50px;"></div>
        
        {{-- نموذج التسجيل --}}
        <form id="registerForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="position-relative my-3">
            @csrf
            {{-- الحقول الأساسية --}}
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" class="form-control border-end-0" placeholder="أدخل اسمك الكامل" required value="{{ old('name') }}">
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control border-end-0" placeholder="أدخل بريدك الإلكتروني" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control border-end-0" placeholder="أدخل كلمة المرور" required>
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-phone"></i></span>
                    <input type="tel" name="phone" class="form-control border-end-0" placeholder="أدخل رقم هاتفك" required value="{{ old('phone') }}">
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fab fa-whatsapp"></i></span>
                    <input type="tel" name="whatsapp" class="form-control border-end-0" placeholder="أدخل رقم الواتساب الخاص بك" required value="{{ old('whatsapp') }}">
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" name="address" class="form-control border-end-0" placeholder="أدخل عنوانك" required value="{{ old('address') }}">
                </div>
            </div>

            {{-- اختيار الدور --}}
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-user-tag"></i></span>
                    <select name="role" class="form-select border-end-0" required id="role">
                        <option value="">اختر الدور</option>
                        <option value="trainee" {{ old('role') == 'trainee' ? 'selected' : '' }}>متدرب</option>
                        <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>مدرب</option>
                        <option value="training_center" {{ old('role') == 'training_center' ? 'selected' : '' }}>مركز تدريبي</option>
                    </select>
                </div>
            </div>

            {{-- الحقول الخاصة بالمدرب --}}
            <div id="instructorFields" style="display: none;">
                <div class="section-header mb-3">معلومات المدرب</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-start-0"><i class="fas fa-language"></i></span>
                            <input type="text" name="language" class="form-control border-end-0" placeholder="اللغة المتحدثة" value="{{ old('language') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-start-0"><i class="fas fa-briefcase"></i></span>
                            <input type="number" name="years_of_experience" class="form-control border-end-0" placeholder="عدد سنوات الخبرة" value="{{ old('years_of_experience') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-graduation-cap"></i></span>
                        <select name="training_type" class="form-select border-end-0">
                            <option value="">اختر نوع التدريب</option>
                            <option value="beginner" {{ old('training_type') == 'beginner' ? 'selected' : '' }}>مبتدئ</option>
                            <option value="advanced" {{ old('training_type') == 'advanced' ? 'selected' : '' }}>متقدم</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-car"></i></span>
                        <input type="text" name="car_type" class="form-control border-end-0" placeholder="أدخل نوع وطراز السيارة" value="{{ old('car_type') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-start-0"><i class="fas fa-id-card"></i></span>
                            <select name="license_type" class="form-select border-end-0">
                                <option value="">اختر نوع الرخصة</option>
                                <option value="private" {{ old('license_type') == 'private' ? 'selected' : '' }}>خاصة</option>
                                <option value="motorcycle" {{ old('license_type') == 'motorcycle' ? 'selected' : '' }}>دراجة نارية</option>
                                <option value="truck" {{ old('license_type') == 'truck' ? 'selected' : '' }}>شاحنة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-start-0"><i class="fas fa-user-clock"></i></span>
                            <input type="number" name="age" class="form-control border-end-0" placeholder="العمر" value="{{ old('age') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-hourglass-half"></i></span>
                        <input type="text" name="session_duration" class="form-control border-end-0" placeholder="مدة الجلسة" value="{{ old('session_duration') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-money-bill-wave"></i></span>
                        <input type="text" name="session_price" class="form-control border-end-0" placeholder="سعر الجلسة" value="{{ old('session_price') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-clock"></i></span>
                        <select name="session_time" class="form-select border-end-0">
                            <option value="">اختر وقت الجلسة</option>
                            <option value="morning" {{ old('session_time') == 'morning' ? 'selected' : '' }}>صباحاً</option>
                            <option value="afternoon" {{ old('session_time') == 'afternoon' ? 'selected' : '' }}>مساءً</option>
                            <option value="evening" {{ old('session_time') == 'evening' ? 'selected' : '' }}>مساءً متأخراً</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="test_preparation" class="form-check-input" {{ old('test_preparation') ? 'checked' : '' }}>
                        <label class="form-check-label">إعداد للاختبار</label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-users"></i></span>
                        <select name="special_training_programs" class="form-select border-end-0">
                            <option value="">اختر برامج تدريب خاصة</option>
                            <option value="women" {{ old('special_training_programs') == 'women' ? 'selected' : '' }}>النساء</option>
                            <option value="elderly" {{ old('special_training_programs') == 'elderly' ? 'selected' : '' }}>كبار السن</option>
                            <option value="special_needs" {{ old('special_training_programs') == 'special_needs' ? 'selected' : '' }}>ذوي الاحتياجات الخاصة</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- الحقول الخاصة بالمتدرب --}}
            <div id="traineeFields" style="display: none;">
                <div class="section-header mb-3">معلومات المتدرب</div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="test_preparation" checked="{{ old('test_preparation') ? 'checked' : '' }}" class="form-check-input">
                        <label class="form-check-label">استعداد للاختبار</label>
                    </div>
                </div>
            </div>

            {{-- الحقول الخاصة بمركز التدريب --}}
            <div id="trainingCenterFields" style="display: none;">
                <div class="section-header mb-3">معلومات مركز التدريب</div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-building"></i></span>
                        <input type="text" name="center_name" class="form-control border-end-0" placeholder="اسم المركز التدريبي" value="{{ old('center_name') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text border-start-0"><i class="fas fa-map-marked-alt"></i></span>
                        <input type="text" name="center_location" class="form-control border-end-0" placeholder="موقع المركز التدريبي" value="{{ old('center_location') }}">
                    </div>
                </div>
            </div>

            {{-- تحميل صورة الملف الشخصي --}}
            <div class="mb-4">
                <label class="form-file-label">صورة الملف الشخصي</label>
                <div class="input-group">
                    <span class="input-group-text border-start-0"><i class="fas fa-image"></i></span>
                    <input type="file" name="profile_picture" class="form-control border-end-0" accept="image/*">
                </div>
                <small class="form-text mt-1">تحميل صورة الملف الشخصي (JPEG، PNG)</small>
            </div>

            <div class="d-grid gap-2 mt-5">
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-user-plus ms-2"></i> تسجيل الحساب
                </button>
            </div>
            
            <div class="text-center mt-4 mb-3">
                <p class="text-muted">لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #4e73df;">تسجيل الدخول</a></p>
            </div>
        </form>
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let roleSelect = document.getElementById('role');
        let instructorFields = document.getElementById('instructorFields');
        let traineeFields = document.getElementById('traineeFields');
        let trainingCenterFields = document.getElementById('trainingCenterFields');

        function toggleRoleFields() {
            let selectedRole = roleSelect.value;

            // إخفاء جميع الحقول أولاً
            instructorFields.style.display = 'none';
            traineeFields.style.display = 'none';
            trainingCenterFields.style.display = 'none';

            // عرض الحقول الخاصة بالدور المختار
            if (selectedRole === 'instructor') {
                instructorFields.style.display = 'block';
            } else if (selectedRole === 'trainee') {
                traineeFields.style.display = 'block';
            } else if (selectedRole === 'training_center') {
                trainingCenterFields.style.display = 'block';
            }
        }

        roleSelect.addEventListener('change', toggleRoleFields);

        toggleRoleFields(); // لتحديث الحقول عند تحميل الصفحة لأول مرة

        // منع إعادة تحميل الصفحة عند إرسال النموذج
        let form = document.getElementById('registerForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(form);

            // إرسال البيانات باستخدام Fetch API
            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message); // عرض رسالة توستر عند نجاح التسجيل
                        form.reset(); // مسح النموذج بعد النجاح
                    } else {
                        toastr.error(data.message); // عرض رسالة خطأ عند فشل التسجيل
                    }
                })
                .catch(error => {
                    toastr.error('حدث خطأ أثناء إرسال البيانات');
                });
        });
    });
    
</script>

@endsection