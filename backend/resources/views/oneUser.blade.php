@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <!-- Profile Content Component -->
        @include('components.profile-content')
    </div>
</div>

<!-- Include custom CSS -->
@push('styles')
    @include('components.profile-styles')
@endpush

<!-- Include custom JavaScript -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Global Constants
    const STORAGE_BASE_URL = 'http://127.0.0.1:8000/storage/';

    document.addEventListener('DOMContentLoaded', function() {
        // Get token from localStorage
        const token = localStorage.getItem('token');
        
        // Get user ID from URL path
        const pathSegments = window.location.pathname.split('/');
        const userId = pathSegments[pathSegments.length - 1];

        console.log('User ID:', userId); // Debug log

        if (!token) {
            window.location.href = '/login';
            return;
        }

        if (!userId) {
            showError('User ID not found in URL');
            return;
        }

        // Fetch user data using Axios
        axios.get(`/api/user/profile/${userId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('API Response:', response.data); // Debug log
            
            if (response.data && response.data.user) {
                updateProfileData(response.data.user);
            } else {
                console.error('Invalid response structure:', response.data); // Debug log
                showError('Invalid response from server');
            }
        })
        .catch(error => {
            console.error('Error details:', {
                message: error.message,
                response: error.response?.data,
                status: error.response?.status
            });
            
            let errorMessage = 'Error loading user data. ';
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                errorMessage += error.response.data.message || `Server responded with status ${error.response.status}`;
            } else if (error.request) {
                // The request was made but no response was received
                errorMessage += 'No response received from server';
            } else {
                // Something happened in setting up the request
                errorMessage += error.message;
            }
            
            showError(errorMessage);
        });
    });

    function showError(message) {
        console.error('Showing error:', message); // Debug log
        
        // Create error alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mx-4 mt-4';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>
                    <h4 class="alert-heading mb-1">Error</h4>
                    <p class="mb-0">${message}</p>
                </div>
            </div>
        `;

        // Insert alert at the top of the content
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);

        // Hide all profile sections
        document.querySelectorAll('.card').forEach(card => {
            card.style.display = 'none';
        });
    }

    function updateProfileData(user) {
        console.log('Updating profile with data:', user); // Debug log
        
        // Update all profile fields with user data
        document.getElementById('userName').textContent = user.name || 'N/A';
        document.getElementById('userEmail').textContent = user.email || 'N/A';
        document.getElementById('userPhone').textContent = user.phone || 'N/A';
        document.getElementById('userRole').textContent = user.role || 'N/A';
        document.getElementById('userAddress').textContent = user.address || 'N/A';
        document.getElementById('userWhatsapp').textContent = user.whatsapp || 'N/A';
        document.getElementById('userLanguage').textContent = user.language || 'N/A';
        
        // Update profile picture if exists
        if (user.profile_picture) {
            // Check if the profile picture already has a full URL
            if (user.profile_picture.startsWith('http')) {
                document.getElementById('profilePicture').src = user.profile_picture;
            } else {
                // Handle various path formats
                const picturePath = user.profile_picture.startsWith('/') ? 
                    user.profile_picture.substring(1) : user.profile_picture;
                document.getElementById('profilePicture').src = STORAGE_BASE_URL + picturePath;
            }
        } else {
            // Use default image from asset helper
            const defaultImagePath = document.getElementById('profilePicture').getAttribute('data-default') || 
                                   document.getElementById('profilePicture').src;
            document.getElementById('profilePicture').src = defaultImagePath;
        }

        // Update additional fields based on role
        if (user.role === 'instructor') {
            document.getElementById('experience').textContent = user.years_of_experience ? `${user.years_of_experience} years` : 'N/A';
            document.getElementById('trainingType').textContent = user.training_type || 'N/A';
            document.getElementById('carType').textContent = user.car_type || 'N/A';
        } else if (user.role === 'training_center') {
            document.getElementById('centerName').textContent = user.center_name || 'N/A';
            document.getElementById('centerLocation').textContent = user.center_location || 'N/A';
        }
console.log(user.profile_picture);

        // Show role-specific sections
        const sections = document.querySelectorAll('[data-role]');
        sections.forEach(section => {
            if (section.dataset.role === user.role) {
                section.classList.remove('d-none');
            } else {
                section.classList.add('d-none');
            }
        });
    }
</script>
@endpush
