@extends('app')

@section('content')
<div class="container">
    <h1>البحث عن المدربين</h1>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

 
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- نموذج الفلاتر -->
    <form id="filter-form" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="years_of_experience">سنوات الخبرة</label>
                <input type="number" id="years_of_experience" class="form-control" placeholder="سنوات الخبرة">
            </div>
            <div class="col-md-3">
                <label for="training_type">نوع التدريب</label>
                <input type="text" id="training_type" class="form-control" placeholder="نوع التدريب">
            </div>
            <div class="col-md-3">
                <label for="car_type">نوع السيارة</label>
                <input type="text" id="car_type" class="form-control" placeholder="نوع السيارة">
            </div>
            <div class="col-md-3">
                <label for="language">اللغة</label>
                <input type="text" id="language" class="form-control" placeholder="اللغة">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="rating">التقييم</label>
                <input type="number" id="rating" class="form-control" step="0.1" min="0" max="5" placeholder="التقييم">
            </div>
            <div class="col-md-3">
                <label for="age">العمر</label>
                <input type="number" id="age" class="form-control" placeholder="العمر">
            </div>
            <div class="col-md-3">
                <label for="session_duration">مدة الجلسة</label>
                <input type="number" id="session_duration" class="form-control" placeholder="مدة الجلسة (دقائق)">
            </div>
            <div class="col-md-3">
                <label for="session_price">سعر الجلسة</label>
                <input type="number" id="session_price" class="form-control" placeholder="سعر الجلسة">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="session_time">وقت الجلسة</label>
                <input type="text" id="session_time" class="form-control" placeholder="وقت الجلسة">
            </div>
            <div class="col-md-3">
                <label for="field_training_available">التدريب في الميدان</label>
                <select id="field_training_available" class="form-control">
                    <option value="">اختر</option>
                    <option value="1">نعم</option>
                    <option value="0">لا</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="test_preparation">التحضير للاختبار</label>
                <input type="text" id="test_preparation" class="form-control" placeholder="التحضير للاختبار">
            </div>
            <div class="col-md-3">
                <label for="license_type">نوع الرخصة</label>
                <input type="text" id="license_type" class="form-control" placeholder="نوع الرخصة">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="special_training_programs">البرامج التدريبية الخاصة</label>
                <input type="text" id="special_training_programs" class="form-control" placeholder="البرامج التدريبية الخاصة">
            </div>
            <div class="col-md-3">
                <label for="location">الموقع</label>
                <input type="text" id="location" class="form-control" placeholder="الموقع">
            </div>
            <div class="col-md-3">
                <label for="distance">المسافة (كم)</label>
                <input type="number" id="distance" class="form-control" placeholder="المسافة">
            </div>
            <div class="col-md-3">
                <label for="latitude">خط العرض</label>
                <input type="text" id="latitude" class="form-control" placeholder="خط العرض">
            </div>
            <div class="col-md-3">
                <label for="longitude">خط الطول</label>
                <input type="text" id="longitude" class="form-control" placeholder="خط الطول">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">بحث</button>
    </form>

    <!-- عرض نتائج البحث -->
    <div id="users-list">
        <!-- سيتم ملء هذه المنطقة بعد استلام البيانات -->
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
 document.getElementById('filter-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    let formData = new FormData(this);
let formDataObject = {};
formData.forEach((value, key) => {
    formDataObject[key] = value;
});

try {
    let response = await axios.post('http://127.0.0.1:8000/api/users', formDataObject, {
        headers: {
            'Content-Type': 'application/json'
        }
    });

        let data = response.data;
console.log(data);

        if (data.success) {
            let usersList = document.getElementById('users-list');
            usersList.innerHTML = '';

            if (data.users.length > 0) {
                data.users.forEach(user => {
                    let userElement = document.createElement('div');
                    userElement.classList.add('user');
                    userElement.innerHTML = `
                        <h5>${user.name}</h5>
                        <p>السنوات من الخبرة: ${user.years_of_experience}</p>
                        <p>التقييم: ${user.rating}</p>
                        <p>الموقع: ${user.location}</p>
                    `;
                    usersList.appendChild(userElement);
                });
                toastr.success('تم العثور على المدربين بنجاح!');
            } else {
                usersList.innerHTML = '<p>لا توجد نتائج مطابقة.</p>';
                toastr.info('لا توجد نتائج مطابقة للبحث.');
            }
        } else {
            toastr.error('فشل في جلب البيانات');
        }
    } catch (err) {
        toastr.error('حدث خطأ في جلب البيانات');
    }
});


</script>
@endpush
