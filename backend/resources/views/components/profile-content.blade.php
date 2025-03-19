<!-- Profile Header -->
<div class="col-12 mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-center">
                <div class="profile-image-container me-md-4 mb-3 mb-md-0">
                    <img id="profilePicture" 
                         src="{{ asset('images/default-avatar.png') }}" 
                         data-default="{{ asset('images/default-avatar.png') }}"
                         alt="Profile Picture" 
                         class="rounded-circle profile-image">
                </div>
                <div class="text-center text-md-start">
                    <h2 id="userName" class="mb-1 fw-bold">Loading...</h2>
                    <p id="userRole" class="text-muted mb-2">Loading...</p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-primary"><i class="fas fa-envelope me-1"></i> <span id="userEmail">Loading...</span></span>
                        <span class="badge bg-success"><i class="fas fa-phone me-1"></i> <span id="userPhone">Loading...</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instructor Specific Section -->
<div class="col-12 col-lg-8 mb-4" data-role="instructor">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h4 class="mb-0">Professional Information</h4>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-12 col-sm-6">
                    <div class="info-card bg-light p-3 rounded">
                        <h6 class="text-muted mb-2">Experience</h6>
                        <p id="experience" class="mb-0 fw-bold">Loading...</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="info-card bg-light p-3 rounded">
                        <h6 class="text-muted mb-2">Training Type</h6>
                        <p id="trainingType" class="mb-0 fw-bold">Loading...</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="info-card bg-light p-3 rounded">
                        <h6 class="text-muted mb-2">Car Type</h6>
                        <p id="carType" class="mb-0 fw-bold">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Training Center Specific Section -->
<div class="col-12 col-lg-8 mb-4" data-role="training_center">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h4 class="mb-0">Center Information</h4>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="info-card bg-light p-3 rounded">
                        <h6 class="text-muted mb-2">Center Name</h6>
                        <p id="centerName" class="mb-0 fw-bold">Loading...</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-card bg-light p-3 rounded">
                        <h6 class="text-muted mb-2">Location</h6>
                        <p id="centerLocation" class="mb-0 fw-bold">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Information -->
<div class="col-12 col-lg-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h4 class="mb-0">Contact Information</h4>
        </div>
        <div class="card-body p-4">
            <div class="contact-item mb-3">
                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                <span id="userAddress">Loading...</span>
            </div>
            <div class="contact-item mb-3">
                <i class="fab fa-whatsapp text-success me-2"></i>
                <span id="userWhatsapp">Loading...</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-language text-info me-2"></i>
                <span id="userLanguage">Loading...</span>
            </div>
        </div>
    </div>
</div> 