@extends('app')

@section('content')
<div class="container py-5">
    <div class="text-center my-5">
        <h1 class="display-5 fw-bold text-primary mb-3">تحديث الملف الشخصي</h1>
        <p class="lead text-muted">يمكنك تحديث معلومات ملفك الشخصي من هنا</p>
        <button type="button" class="btn btn-lg btn-primary rounded-pill shadow px-5 mt-3" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
            <i class="fas fa-user-edit me-2"></i>تحديث الملف الشخصي
        </button>
    </div>
</div>

<!-- Include the modal partial -->
@include('update-modal')
@endsection
