<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fw-bold" id="updateProfileModalLabel">تحديث الملف الشخصي</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" dir="rtl">
                <form id="updateProfileForm">
                    <!-- Loading Spinner -->
                    <div id="formLoadingSpinner" class="text-center py-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-2 text-muted">جاري تحميل بيانات المستخدم...</p>
                    </div>

                    <div id="formContent">
                        <!-- Profile Picture Section -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="profile-image-preview rounded-circle border border-2 border-primary shadow" 
                                     style="width: 120px; height: 120px; overflow: hidden;">
                                    <img id="profileImagePreview" src="" alt="" class="w-100 h-100 object-fit-cover d-none">
                                    <div id="profileImagePlaceholder" class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user fa-3x text-primary opacity-50"></i>
                                    </div>
                                </div>
                                <label for="profilePictureInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm" 
                                     style="cursor: pointer; transition: all 0.2s ease-in-out;"
                                     onmouseover="this.style.transform='scale(1.1)'" 
                                     onmouseout="this.style.transform='scale(1)'">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="profilePictureInput" name="profile_picture" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <p class="text-muted small mt-2">انقر لتحديث صورة الملف الشخصي</p>
                        </div>

                        <!-- Form Sections -->
                        <div class="row g-4">
                            <!-- Basic Information Section -->
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 mb-4">
                                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                        <h6 class="text-primary fw-bold mb-0">
                                            <i class="fas fa-user-circle me-2"></i>المعلومات الأساسية
                                        </h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">الاسم الكامل</label>
                                                <input type="text" class="form-control rounded-3" id="name" name="name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                                <input type="email" class="form-control rounded-3" id="email" name="email" readonly>
                                                <small class="text-muted">لا يمكن تغيير البريد الإلكتروني</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">رقم الهاتف</label>
                                                <input type="tel" class="form-control rounded-3" id="phone" name="phone">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="whatsapp" class="form-label">رقم الواتساب</label>
                                                <input type="tel" class="form-control rounded-3" id="whatsapp" name="whatsapp">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="age" class="form-label">العمر</label>
                                                <input type="number" class="form-control rounded-3" id="age" name="age" min="18" max="80">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="language" class="form-label">اللغة المفضلة</label>
                                                <select class="form-select rounded-3" id="language" name="language">
                                                    <option value="ar">العربية</option>
                                                    <option value="en">الإنجليزية</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information -->
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 mb-4">
                                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                        <h6 class="text-primary fw-bold mb-0">
                                            <i class="fas fa-map-marker-alt me-2"></i>معلومات الموقع
                                        </h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <!-- <div class="col-md-6">
                                                <label for="address" class="form-label">العنوان</label>
                                                <input type="text" class="form-control rounded-3" id="address" name="address">
                                            </div> -->
                                            <div class="col-12">
                                                <label for="location" class="form-label">الموقع</label>
                                                <textarea class="form-control rounded-3" id="location" name="location" rows="3" style="resize: vertical;"></textarea>
                                            </div>
                                            <div class="col-12" id="centerLocationField" style="display: none;">
                                                <label for="center_location" class="form-label">موقع المركز</label>
                                                <input type="text" class="form-control rounded-3" id="center_location" name="center_location">
                                            </div>
                                            <div class="col-12" id="centerNameField" style="display: none;">
                                                <label for="center_name" class="form-label">اسم المركز</label>
                                                <input type="text" class="form-control rounded-3" id="center_name" name="center_name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructor Specific Information -->
                            <div class="col-12" id="instructorFields" style="display: none;">
                                <div class="card border-0 shadow-sm rounded-4 mb-4">
                                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                        <h6 class="text-primary fw-bold mb-0">
                                            <i class="fas fa-chalkboard-teacher me-2"></i>معلومات المدرب
                                        </h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="years_of_experience" class="form-label">سنوات الخبرة</label>
                                                <input type="number" class="form-control rounded-3" id="years_of_experience" name="years_of_experience" min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="training_type" class="form-label">نوع التدريب</label>
                                                <select class="form-select rounded-3" id="training_type" name="training_type">
                                                    <option value="">اختر نوع التدريب</option>
                                                    <option value="beginner">مبتدئ</option>
                                                    <option value="advanced">متقدم</option>
                                                    <option value="highway_driving">قيادة على الطرق السريعة</option>
                                                    <option value="city_driving">قيادة في المدينة</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="car_type" class="form-label">نوع السيارة</label>
                                                <select class="form-select rounded-3" id="car_type" name="car_type">
                                                    <option value="">اختر نوع السيارة</option>
                                                    <option value="sedan">سيدان</option>
                                                    <option value="suv">دفع رباعي</option>
                                                    <option value="truck">شاحنة</option>
                                                    <option value="manual">ناقل عادي</option>
                                                    <option value="automatic">ناقل أوتوماتيكي</option>
                                                    <option value="electric">سيارة كهربائية</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="license_type" class="form-label">نوع الرخصة</label>
                                                <select class="form-select rounded-3" id="license_type" name="license_type">
                                                    <option value="">اختر نوع الرخصة</option>
                                                    <option value="private">خاصة</option>
                                                    <option value="public">عامة</option>
                                                    <option value="motorcycle">دراجة نارية</option>
                                                    <option value="truck">شاحنة</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="session_price" class="form-label">سعر الجلسة (دينار اردني)</label>
                                                <input type="number" class="form-control rounded-3" id="session_price" name="session_price" min="0">
                                            </div>
                                            
                                            <!-- Availability Fields -->
                                            <div class="col-md-6">
                                                <label for="available_from" class="form-label">متاح من الساعة</label>
                                                <input type="time" class="form-control rounded-3" id="available_from" name="available_from">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="available_to" class="form-label">متاح إلى الساعة</label>
                                                <input type="time" class="form-control rounded-3" id="available_to" name="available_to">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="break_time_duration" class="form-label">مدة الاستراحة (دقيقة)</label>
                                                <input type="number" class="form-control rounded-3" id="break_time_duration" name="break_time_duration" min="0" step="5">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lesson_duration" class="form-label">مدة الدرس (دقيقة)</label>
                                                <input type="number" class="form-control rounded-3" id="lesson_duration" name="lesson_duration" min="30" step="15">
                                            </div>
                                            
                                            <div class="col-12">
                                                <label class="form-label">أيام التدريب المتاحة</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-sun" name="available_days[]" value="Sunday">
                                                        <label class="form-check-label" for="day-sun">الأحد</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-mon" name="available_days[]" value="Monday">
                                                        <label class="form-check-label" for="day-mon">الاثنين</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-tue" name="available_days[]" value="Tuesday">
                                                        <label class="form-check-label" for="day-tue">الثلاثاء</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-wed" name="available_days[]" value="Wednesday">
                                                        <label class="form-check-label" for="day-wed">الأربعاء</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-thu" name="available_days[]" value="Thursday">
                                                        <label class="form-check-label" for="day-thu">الخميس</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-fri" name="available_days[]" value="Friday">
                                                        <label class="form-check-label" for="day-fri">الجمعة</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="day-sat" name="available_days[]" value="Saturday">
                                                        <label class="form-check-label" for="day-sat">السبت</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="field_training_available" name="field_training_available" value="1">
                                                    <label class="form-check-label" for="field_training_available">التدريب الميداني متاح</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="test_preparation" name="test_preparation" value="on">
                                                    <label class="form-check-label" for="test_preparation">تحضير للاختبار</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="special_training_programs" class="form-label">برامج تدريب خاصة</label>
                                                <select class="form-select rounded-3" id="special_training_programs" name="special_training_programs">
                                                    <option value="">اختر من البرامج الخاصة</option>
                                                    <option value="women">النساء</option>
                                                    <option value="elderly">كبار السن</option>
                                                    <option value="special_needs">ذوي الاحتياجات الخاصة</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Change Password Section -->
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-transparent border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary fw-bold mb-0">
                                            <i class="fas fa-lock me-2"></i>تغيير كلمة المرور
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="togglePasswordFields">
                                            <i class="fas fa-plus-circle me-1"></i>تغيير كلمة المرور
                                        </button>
                                    </div>
                                    <div class="card-body p-4" id="passwordFieldsContainer" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control rounded-start-3" id="current_password" name="current_password">
                                                    <button class="btn btn-outline-secondary rounded-end-3 toggle-password" type="button" data-target="current_password">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6">
                                                <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control rounded-start-3" id="new_password" name="new_password">
                                                    <button class="btn btn-outline-secondary rounded-end-3 toggle-password" type="button" data-target="new_password">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control rounded-start-3" id="new_password_confirmation" name="new_password_confirmation">
                                                    <button class="btn btn-outline-secondary rounded-end-3 toggle-password" type="button" data-target="new_password_confirmation">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>إلغاء
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="updateProfileBtn">
                    <i class="fas fa-save me-1"></i>حفظ التغييرات
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Styling */
.form-control,
.form-select {
    padding: 0.6rem 0.75rem;
    border-color: #dee2e6;
    transition: all 0.2s ease-in-out;
}

.form-control:focus,
.form-select:focus {
    border-color: #5b9bd5;
    box-shadow: 0 0 0 0.25rem rgba(91, 155, 213, 0.25);
}

/* Modal Body Scrollbar */
.modal-body {
    max-height: 75vh;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 1.5rem;
}

/* Custom Scrollbar Styling */
.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: rgba(241, 241, 241, 0.5);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: rgba(136, 136, 136, 0.5);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: rgba(85, 85, 85, 0.7);
}

/* Switch Styling */
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transition: transform 0.2s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

/* Responsive Typography */
@media (max-width: 576px) {
    .modal-title {
        font-size: 1.2rem;
    }
    
    .form-label {
        font-size: 0.85rem;
    }
}

/* Custom Animation for Modal */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-content {
    animation: modalFadeIn 0.3s ease-out;
}

/* Gradient Background */
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #006eff);
}

/* Profile Image Effects */
.profile-image-preview {
    transition: all 0.3s ease;
}

.profile-image-preview:hover {
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile Picture Preview
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const profileImagePlaceholder = document.getElementById('profileImagePlaceholder');
    
    // Store user ID for the update API call
    let currentUserId = null;
    
    profilePictureInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
                profileImagePreview.classList.remove('d-none');
                profileImagePlaceholder.classList.add('d-none');
            }
            
            reader.readAsDataURL(file);
        }
    });
    
    // Toggle Password Visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Toggle Password Fields
    const togglePasswordFields = document.getElementById('togglePasswordFields');
    const passwordFieldsContainer = document.getElementById('passwordFieldsContainer');
    
    togglePasswordFields.addEventListener('click', function() {
        const isVisible = passwordFieldsContainer.style.display !== 'none';
        passwordFieldsContainer.style.display = isVisible ? 'none' : 'block';
        this.innerHTML = isVisible ? 
            '<i class="fas fa-plus-circle me-1"></i>تغيير كلمة المرور' : 
            '<i class="fas fa-minus-circle me-1"></i>إلغاء تغيير كلمة المرور';
    });
    
    // When the modal is shown, we'll fetch user data and populate the form
    const updateProfileModal = document.getElementById('updateProfileModal');
    updateProfileModal.addEventListener('show.bs.modal', function(event) {
        const formLoadingSpinner = document.getElementById('formLoadingSpinner');
        const formContent = document.getElementById('formContent');
        
        // Show loading spinner and hide form content
        formLoadingSpinner.style.display = 'block';
        formContent.style.display = 'none';
        
        // Get the token from localStorage
        const token = localStorage.getItem('token');
        if (!token) {
            if (typeof toastr !== 'undefined') {
                toastr.error('يرجى تسجيل الدخول أولاً');
            }
            return;
        }
        
        // Fetch user data from the API
        fetch("/api/user/token/2", {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Failed to fetch user data');
            }
            
            const user = data.user;
            console.log('Populating form with user data:', user);
            
            // Store the user ID for the update API call
            currentUserId = user.id;
            
            // Show/hide fields based on role
            if (user.role === 'instructor') {
                document.getElementById('instructorFields').style.display = 'block';
            } else if (user.role === 'training_center') {
                document.getElementById('centerLocationField').style.display = 'block';
                document.getElementById('centerNameField').style.display = 'block';
            }
            
            // Populate basic form fields
            document.getElementById('name').value = user.name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('whatsapp').value = user.whatsapp || '';
            document.getElementById('age').value = user.age || '';
            document.getElementById('language').value = user.language || 'ar';
            
       
            document.getElementById('address').value = user.address || '';
            
            document.getElementById('location').value = user.location || '';
            
            // Center fields
            if (user.center_name) document.getElementById('center_name').value = user.center_name;
            if (user.center_location) document.getElementById('center_location').value = user.center_location;
            
            // Instructor fields
            if (user.role === 'instructor') {
                document.getElementById('years_of_experience').value = user.years_of_experience || '';
                document.getElementById('training_type').value = user.training_type || '';
                document.getElementById('car_type').value = user.car_type || '';
                document.getElementById('license_type').value = user.license_type || '';
                document.getElementById('session_price').value = user.session_price || '';
                
                // New fields
                document.getElementById('available_from').value = user.available_from || '';
                document.getElementById('available_to').value = user.available_to || '';
                document.getElementById('break_time_duration').value = user.break_time_duration || '';
                document.getElementById('lesson_duration').value = user.lesson_duration || '';
                
                // Checkboxes
                document.getElementById('field_training_available').checked = user.field_training_available === 1;
                document.getElementById('test_preparation').checked = user.test_preparation === 1 || user.test_preparation === "on";
                
                // Set special training programs select value
                const specialTrainingSelect = document.getElementById('special_training_programs');
                console.log('Special Training Programs Value:', user.special_training_programs);
                
                if (user.special_training_programs) {
                    // Make sure the option exists before setting it
                    const options = Array.from(specialTrainingSelect.options);
                    const optionExists = options.some(option => option.value === user.special_training_programs);
                    
                    if (optionExists) {
                        specialTrainingSelect.value = user.special_training_programs;
                        console.log('Set special_training_programs to:', specialTrainingSelect.value);
                    } else {
                        console.warn('Option value not found in dropdown:', user.special_training_programs);
                        // Add the option if it doesn't exist
                        const newOption = new Option(user.special_training_programs, user.special_training_programs);
                        specialTrainingSelect.add(newOption);
                        specialTrainingSelect.value = user.special_training_programs;
                    }
                } else {
                    // Set to empty/default option
                    specialTrainingSelect.selectedIndex = 0;
                }
                
                // Available days - assuming it's stored as a comma-separated string
                if (user.available_days) {
                    const availableDays = user.available_days.split(',');
                    availableDays.forEach(day => {
                        const checkboxId = `day-${day.toLowerCase().substring(0, 3)}`;
                        const checkbox = document.getElementById(checkboxId);
                        if (checkbox) checkbox.checked = true;
                    });
                }
            }
            
            // Profile picture
            if (user.profile_picture) {
                let pictureSrc = '';
                if (user.profile_picture.startsWith('http')) {
                    pictureSrc = user.profile_picture;
                } else {
                    const path = user.profile_picture.startsWith('/') ? 
                        user.profile_picture.substring(1) : user.profile_picture;
                    pictureSrc = `{{ url("storage") }}/${path}`;
                }
                
                profileImagePreview.src = pictureSrc;
                profileImagePreview.classList.remove('d-none');
                profileImagePlaceholder.classList.add('d-none');
            }
            
            // Hide loading spinner and show form content
            formLoadingSpinner.style.display = 'none';
            formContent.style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('حدث خطأ أثناء تحميل بيانات المستخدم. الرجاء المحاولة مرة أخرى.');
            }
            formLoadingSpinner.style.display = 'none';
            formContent.style.display = 'block';
        });
    });
    
    // Handle form submission
    const updateProfileForm = document.getElementById('updateProfileForm');
    const updateProfileBtnInModal = document.querySelector('#updateProfileModal #updateProfileBtn');
    
    updateProfileBtnInModal.addEventListener('click', function() {
        // Show loading state
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>جاري الحفظ...';
        
        // Get the form data
        const formData = new FormData(updateProfileForm);
        
        // Convert available_days checkboxes to a comma-separated string
        const availableDays = [];
        document.querySelectorAll('input[name="available_days[]"]:checked').forEach(checkbox => {
            availableDays.push(checkbox.value);
        });
        if (availableDays.length > 0) {
            formData.set('available_days', availableDays.join(','));
        }
        
        // Convert checkbox values to 0/1
        ['field_training_available'].forEach(field => {
            const checkbox = document.getElementById(field);
            formData.set(field, checkbox && checkbox.checked ? "1" : "0");
        });
        
            ['test_preparation'].forEach(field => {
            const checkbox = document.getElementById(field);
            formData.set(field, checkbox && checkbox.checked ? "on" : "off");
        });



        // Remove password fields if they are empty
        if (!formData.get('current_password') && !formData.get('new_password')) {
            formData.delete('current_password');
            formData.delete('new_password');
            formData.delete('new_password_confirmation');
        }
        
        // Get the token from localStorage
        const token = localStorage.getItem('token');
        if (!token) {
            if (typeof toastr !== 'undefined') {
                toastr.error('يرجى تسجيل الدخول أولاً');
            }
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-save me-1"></i>حفظ التغييرات';
            return;
        }
        
        // Ensure we have the user ID
        if (!currentUserId) {
            if (typeof toastr !== 'undefined') {
                toastr.error('لم يتم العثور على معرف المستخدم. الرجاء تحديث الصفحة والمحاولة مرة أخرى.');
            }
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-save me-1"></i>حفظ التغييرات';
            return;
        }
        
        // Make the API call to update the user
        fetch(`/api/user/update/${currentUserId}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData // FormData will automatically set the correct Content-Type with boundaries for file uploads
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw { 
                        status: response.status, 
                        response: err 
                    };
                });
            }
            return response.json();
        })
        .then(data => {
            const modal = bootstrap.Modal.getInstance(updateProfileModal);
            modal.hide();
            
            if (data.message) {
                // Show success message
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000"
                    };
                    toastr.success(data.message);
                } else {
                    alert(data.message);
                }
                
                // Refresh the profile page to show updated information
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else if (data.error) {
                throw new Error(data.error + (data.message ? ': ' + data.message : ''));
            }
        })
        .catch(error => {
            console.error('Error updating profile:', error);
            
            // Handle validation errors
            if (error.status === 422 && error.response) {
                const errors = error.response.message;
                
                // Clear previous error messages
                document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // Display new error messages
                for (const field in errors) {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.innerText = errors[field][0];
                        
                        input.parentNode.appendChild(feedback);
                    }
                }
                
                // Show a general error message
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "5000"
                    };
                    toastr.error('يرجى تصحيح الأخطاء في النموذج');
                }
            } else {
                // Show general error
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "5000"
                    };
                    
                    // Get the error message
                    let errorMessage = 'حدث خطأ أثناء تحديث البيانات';
                    if (error.response && error.response.error) {
                        errorMessage += ': ' + error.response.error;
                    } else if (error.message) {
                        errorMessage += ': ' + error.message;
                    }
                    
                    toastr.error(errorMessage);
                } else {
                    alert('حدث خطأ أثناء تحديث البيانات');
                }
            }
        })
        .finally(() => {
            // Reset button state
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-save me-1"></i>حفظ التغييرات';
        });
    });
});
</script> 