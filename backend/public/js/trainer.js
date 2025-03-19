// Global Constants
const STORAGE_BASE_URL = 'http://127.0.0.1:8000/storage/';

document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const elements = {
        currentDate: document.getElementById('currentDate'),
        filterForm: document.getElementById('filterForm'),
        trainersContainer: document.getElementById('trainersContainer'),
        loadingState: document.querySelector('.loading-state'),
        resultsContainer: document.querySelector('.results-container'),
        noResultsState: document.querySelector('.no-results-state'),
        errorState: document.querySelector('.error-state')
    };

    // Set current date
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    elements.currentDate.textContent = today.toLocaleDateString('ar-SA', options);

    // Handle form submission
    elements.filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        searchTrainers();
    });

    // Handle form reset
    elements.filterForm.addEventListener('reset', function() {
        setTimeout(() => {
            searchTrainers();
        }, 10);
    });

    // Search for trainers function
    function searchTrainers() {
        showLoadingState();
        
        // Get the form data
        const formData = new FormData(elements.filterForm);
        const searchParams = {};
        
        // Convert FormData to object and filter out empty values
        for (const [key, value] of formData.entries()) {
            if (value) {
                searchParams[key] = value;
            }
        }
        
        // Get token for authenticated requests (if needed)
        const token = localStorage.getItem('token');
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
        
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        // Make API request
        fetch('/api/users', {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(searchParams)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Received trainers data:', data);
            if (data.success && data.users) {
                displayTrainers(data.users);
            } else {
                throw new Error(data.message || 'Failed to fetch trainers');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showErrorState(error);
        });
    }

    // Display trainers in the UI
    function displayTrainers(trainers) {
        if (!trainers || trainers.length === 0) {
            showNoResultsState();
            return;
        }
        
        // Show results container
        elements.resultsContainer.style.display = 'block';
        elements.noResultsState.style.display = 'none';
        elements.errorState.style.display = 'none';
        elements.loadingState.style.display = 'none';
        
        // Generate trainer cards HTML
        const trainersHTML = trainers.map(trainer => generateTrainerCard(trainer)).join('');
        elements.trainersContainer.innerHTML = trainersHTML;
    }

    // Generate HTML for a trainer card
    function generateTrainerCard(trainer) {
        // Prepare trainer avatar
        const avatarUrl = trainer.profile_picture ? 
            (trainer.profile_picture.startsWith('http') ? 
                trainer.profile_picture : 
                STORAGE_BASE_URL + (trainer.profile_picture.startsWith('/') ? 
                    trainer.profile_picture.substring(1) : 
                    trainer.profile_picture)) : 
            `${STORAGE_BASE_URL}images/default-avatar.png`;
            
        // Prepare rating stars
        const rating = trainer.rating || 0;
        const fullStars = Math.floor(rating);
        const halfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        
        const starsHTML = 
            '<i class="fas fa-star"></i>'.repeat(fullStars) +
            (halfStar ? '<i class="fas fa-star-half-alt"></i>' : '') +
            '<i class="far fa-star"></i>'.repeat(emptyStars);
            
        // Prepare features and specifications as badges
        const featuresBadges = [];
        
        if (trainer.training_type) {
            const trainingTypeLabels = {
                'beginner': 'مبتدئ',
                'advanced': 'متقدم',
                'highway_driving': 'قيادة طرق سريعة',
                'city_driving': 'قيادة في المدينة'
            };
            featuresBadges.push(`<span class="info-badge"><i class="fas fa-graduation-cap"></i>${trainingTypeLabels[trainer.training_type] || trainer.training_type}</span>`);
        }
        
        if (trainer.car_type) {
            featuresBadges.push(`<span class="info-badge"><i class="fas fa-car"></i>${trainer.car_type}</span>`);
        }
        
        if (trainer.years_of_experience) {
            featuresBadges.push(`<span class="info-badge"><i class="fas fa-briefcase"></i>${trainer.years_of_experience} سنوات خبرة</span>`);
        }
        
        if (trainer.language) {
            featuresBadges.push(`<span class="info-badge"><i class="fas fa-language"></i>${trainer.language}</span>`);
        }
        
        // Create card HTML
        return `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card trainer-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="${avatarUrl}" 
                                 alt="${trainer.name || 'مدرب'}" 
                                 class="trainer-image me-3"
                                 onerror="this.src='${STORAGE_BASE_URL}images/default-avatar.png'">
                            <div>
                                <h5 class="trainer-name mb-1">${trainer.name || 'مدرب'}</h5>
                                <div class="rating-stars">${starsHTML} ${rating ? `<span class="ms-1">(${rating})</span>` : ''}</div>
                            </div>
                        </div>
                        
                        <div class="trainer-info mb-3">
                            <div><i class="fas fa-map-marker-alt text-danger me-2"></i>${trainer.location || trainer.address || 'غير محدد'}</div>
                            <div><i class="fas fa-phone text-success me-2"></i>${trainer.phone || 'غير محدد'}</div>
                            <div><i class="fas fa-envelope text-primary me-2"></i>${trainer.email || 'غير محدد'}</div>
                        </div>
                        
                        <div class="trainer-features mb-3">
                            ${featuresBadges.join('')}
                        </div>
                        
                        <button onclick="viewTrainerProfile(${trainer.id})" class="view-profile-btn mt-2">
                            <i class="fas fa-user me-2"></i>عرض الملف الشخصي
                        </button>
                        <button onclick="bookTrainingSession(${trainer.id})" class="book-session-btn mt-2">
                            <i class="fas fa-calendar-check me-2"></i>حجز جلسة تدريب
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // UI state functions
    function showLoadingState() {
        elements.loadingState.style.display = 'flex';
        elements.resultsContainer.style.display = 'none';
        elements.noResultsState.style.display = 'none';
        elements.errorState.style.display = 'none';
    }

    function showNoResultsState() {
        elements.loadingState.style.display = 'none';
        elements.resultsContainer.style.display = 'none';
        elements.noResultsState.style.display = 'flex';
        elements.errorState.style.display = 'none';
    }

    function showErrorState(error) {
        elements.loadingState.style.display = 'none';
        elements.resultsContainer.style.display = 'none';
        elements.noResultsState.style.display = 'none';
        elements.errorState.style.display = 'flex';
        
        // Add specific error message if available
        let errorMessage = 'حدث خطأ أثناء البحث عن المدربين';
        if (error && error.message) {
            errorMessage += `: ${error.message}`;
        }
        elements.errorState.querySelector('p').textContent = errorMessage;
    }

    // Load trainers on initial page load
    searchTrainers();
});

// Function to view trainer profile
function viewTrainerProfile(trainerId) {
    window.location.href = `/trainer/${trainerId}`;
}

// Function to book training session with a trainer
function bookTrainingSession(trainerId) {
    // Check if user is logged in
    const token = localStorage.getItem('token');
    if (!token) {
        if (typeof toastr !== 'undefined') {
            toastr.warning('يرجى تسجيل الدخول أولاً لحجز جلسة تدريب');
        } else {
            alert('يرجى تسجيل الدخول أولاً لحجز جلسة تدريب');
        }
        return;
    }
    
    // Redirect to booking page or open booking modal
    window.location.href = `/book-session/${trainerId}`;
} 