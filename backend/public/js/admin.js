document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const elements = {
        currentDate: document.getElementById('currentDate'),
        roleFilter: document.getElementById('roleFilter'),
        searchInput: document.getElementById('searchInput'),
        usersTableBody: document.getElementById('usersTableBody'),
        loadingState: document.querySelector('.loading-state'),
        tableContainer: document.querySelector('.table-container'),
        noResultsState: document.querySelector('.no-results-state'),
        errorState: document.querySelector('.error-state'),
        totalCountEl: document.getElementById('totalCount'),
        activeCountEl: document.getElementById('activeCount'),
        inactiveCountEl: document.getElementById('inactiveCount'),
        pagination: document.getElementById('pagination')
    };

    // State management
    const state = {
        allUsers: [],
        filteredUsers: [],
        currentPage: 1,
        usersPerPage: 10,
        isInitialLoad: true,
        searchTerm: '',
        currentRole: 'all'
    };

    // Make fetchUsers accessible globally
    window.adminFunctions = {
        fetchUsers: fetchUsers,
        state: state,
        elements: elements
    };

    // Set current date
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    elements.currentDate.textContent = today.toLocaleDateString('ar-SA', options);

    // Add search input event listener
    elements.searchInput.addEventListener('input', debounce(() => {
        const searchTerm = elements.searchInput.value.trim().toLowerCase();
        filterUsers(searchTerm);
    }, 300));

    // Add role filter event listener
    elements.roleFilter.addEventListener('change', () => {
        state.currentRole = elements.roleFilter.value;
        fetchUsers(state.currentRole);
    });

    // Improved filter function
    function filterUsers(searchTerm) {
        state.searchTerm = searchTerm;
        
        if (!searchTerm) {
            state.filteredUsers = [...state.allUsers];
        } else {
            state.filteredUsers = state.allUsers.filter(user => {
                const searchFields = [
                    user.name,
                    user.email,
                    user.phone,
                    user.center_name
                ].filter(Boolean);
                
                return searchFields.some(field => 
                    String(field).toLowerCase().includes(searchTerm)
                );
            });
        }
        
        state.currentPage = 1;
        renderTableEfficiently();
        updateCounters();
    }

    // Improved fetch function with better error handling
    function fetchUsers(role) {
        showLoadingState();
        const token = localStorage.getItem('token');
        
        if (!token) {
            handleFetchError(new Error('No authentication token found'));
            return;
        }

        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };

        // Use the correct API endpoint from your routes
        const url = role === 'all' ? '/api/user/all' : `/api/user/${role}`;
        
        fetch(url, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    throw new Error('401: Unauthorized');
                } else if (response.status === 403) {
                    throw new Error('403: Forbidden');
                } else if (response.status === 404) {
                    throw new Error('404: Not Found');
                } else {
                    throw new Error(`${response.status}: ${response.statusText}`);
                }
            }
            return response.json();
        })
        .then(data => {
            console.log('Received users data:', data);
            if (data.error) {
                throw new Error(data.message || 'Failed to fetch users');
            }
            state.allUsers = extractUsers(data, role);
            filterUsers(state.searchTerm);
        })
        .catch(error => {
            console.error('Fetch error:', error);
            handleFetchError(error);
        });
    }

    // Improved extract users function
    function extractUsers(response, role = null) {
        console.log('Extracting users from response:', response);
        let users = [];

        try {
            // Handle the specific response format from getUserByType
            if (response.user && Array.isArray(response.user)) {
                users = response.user;
            } else if (response.data && Array.isArray(response.data)) {
                users = response.data;
            } else if (response.users && Array.isArray(response.users)) {
                users = response.users;
            } else if (Array.isArray(response)) {
                users = response;
            } else if (typeof response === 'object' && response !== null) {
                users = [response];
            }

            // Map users and ensure all required fields exist
            return users.map(user => ({
                id: user.id || null,
                name: user.name || null,
                email: user.email || null,
                phone: user.phone || null,
                role: role || user.role || user.type || 'unknown',
                is_active: Boolean(user.is_active || user.status || true), // Default to active if not specified
                profile_picture: user.profile_picture || user.avatar || null,
                center_name: user.center_name || user.centerName || null,
                // Add any additional fields that might be useful
                whatsapp: user.whatsapp || null,
                address: user.address || null,
                location: user.location || null,
                years_of_experience: user.years_of_experience || null,
                rating: user.rating || null
            }));
        } catch (error) {
            console.error('Error extracting users:', error);
            return [];
        }
    }

    // Improved error handling
    function handleFetchError(error) {
        console.error('Error fetching users:', error);
        elements.loadingState.style.display = 'none';
        elements.errorState.style.display = 'flex';
        elements.tableContainer.style.display = 'none';
        
        let errorMessage = 'حدث خطأ أثناء تحميل البيانات';
        
        if (error.message.includes('401')) {
            errorMessage = 'عذراً، يرجى تسجيل الدخول مرة أخرى';
            // Redirect to login page after a short delay
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        } else if (error.message.includes('403')) {
            errorMessage = 'عذراً، ليس لديك صلاحية للوصول إلى هذه البيانات';
        } else if (error.message.includes('404')) {
            errorMessage = 'عذراً، لا يمكن العثور على البيانات المطلوبة';
        } else if (error.message.includes('500')) {
            errorMessage = 'عذراً، حدث خطأ في الخادم';
        }
        
        elements.errorState.querySelector('p').textContent = errorMessage;
    }

    // Improved render function
    function renderTableEfficiently() {
        const hasUsers = state.filteredUsers.length > 0;
        
        // Update display states
        elements.tableContainer.style.display = hasUsers ? 'block' : 'none';
        elements.noResultsState.style.display = hasUsers ? 'none' : 'block';
        elements.errorState.style.display = 'none';
        elements.loadingState.style.display = 'none';

        if (!hasUsers) {
            elements.pagination.innerHTML = '';
            elements.usersTableBody.innerHTML = '';
            return;
        }

        // Calculate page data
        const startIdx = (state.currentPage - 1) * state.usersPerPage;
        const endIdx = startIdx + state.usersPerPage;
        const usersToDisplay = state.filteredUsers.slice(startIdx, endIdx);
        
        // Always update table when filtering
        elements.usersTableBody.innerHTML = generateTableHTML(usersToDisplay, startIdx);
        
        // Update pagination
        const totalPages = Math.ceil(state.filteredUsers.length / state.usersPerPage);
        elements.pagination.innerHTML = generatePaginationHTML(totalPages);
    }
    

    // Simplified counters update
    function updateCounters() {
        const total = state.allUsers.length;
        const active = state.allUsers.filter(user => user.is_active).length;
        
        elements.totalCountEl.textContent = total;
        elements.activeCountEl.textContent = active;
        elements.inactiveCountEl.textContent = total - active;
    }

    // Simplified pagination handler
    elements.pagination.addEventListener('click', (e) => {
        e.preventDefault();
        const pageLink = e.target.closest('.page-link');
        if (!pageLink) return;

        const newPage = parseInt(pageLink.dataset.page);
        if (newPage && newPage !== state.currentPage && newPage > 0) {
            state.currentPage = newPage;
            renderTableEfficiently();
        }
    });

    function showLoadingState() {
        elements.loadingState.style.display = 'flex';
        elements.tableContainer.style.display = 'none';
        elements.noResultsState.style.display = 'none';
        elements.errorState.style.display = 'none';
    }

    function generateTableHTML(users, startIdx) {
        return users.map((user, index) => {
            const roleText = translateRole(user.role);
            const isActive = user.is_active;
            const statusClass = isActive ? 'badge-status-active' : 'badge-status-inactive';
            const statusText = isActive ? 'نشط' : 'غير نشط';
            const avatarUrl = user.profile_picture ? 
                `/storage/${user.profile_picture}` : 
                '/storage/default-avatar.png';

            return `
                <tr class="user-row">
                    <td class="text-center align-middle">${startIdx + index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar">
                                <img src="${avatarUrl}" alt="${user.name || 'User'}" 
                                     class="rounded-circle" width="40" height="40"
                                     onerror="this.src='/storage/default-avatar.png'"
                                     loading="lazy">
                            </div>
                            <div class="user-info">
                                <h6 class="user-name mb-0">${user.name || 'لا يوجد اسم'}</h6>
                                ${user.center_name ? `<small class="text-muted">${user.center_name}</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">${user.email || 'لا يوجد بريد إلكتروني'}</td>
                    <td class="align-middle">${user.phone || 'لا يوجد رقم هاتف'}</td>
                    <td class="align-middle">
                        <span class="badge badge-role">${roleText}</span>
                    </td>
                    <td class="align-middle">
                        <span class="badge ${statusClass}">${statusText}</span>
                    </td>
                    <td class="text-center align-middle">
                        <div class="action-buttons d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-soft-primary btn-icon-text" onclick="viewUser(${user.id})">
                                <i class="fas fa-user-circle me-1"></i>
                                عرض المستخدم
                            </button>
                            <button type="button" class="btn btn-soft-danger btn-icon-text" onclick="deleteUser(${user.id})">
                                <i class="fas fa-user-times me-1"></i>
                                حذف
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function generatePaginationHTML(totalPages) {
        if (totalPages <= 1) return '';

        let html = `
            <li class="page-item ${state.currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${state.currentPage - 1}">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

        for (let i = 1; i <= totalPages; i++) {
            html += `
                <li class="page-item ${state.currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        html += `
            <li class="page-item ${state.currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${state.currentPage + 1}">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

        return html;
    }

    function translateRole(role) {
        const roles = {
            'trainee': 'متدرب',
            'instructor': 'مدرب',
            'training_center': 'مركز تدريب',
            'admin': 'مدير النظام'
        };
        return roles[role] || role;
    }

    // Initial load
    fetchUsers('all');
});

// Debounce helper function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// User actions
function viewUser(userId) {
    // Navigate to user profile page
    window.location.href = `/user/${userId}`;
}

function deleteUser(userId) {
    if (!confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
        return;
    }

    const token = localStorage.getItem('token');
    if (!token) {
        alert('يرجى تسجيل الدخول مرة أخرى');
        window.location.href = '/login';
        return;
    }

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/api/user/${userId}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('غير مصرح لك بالحذف - يرجى تسجيل الدخول مرة أخرى');
            } else if (response.status === 403) {
                throw new Error('ليس لديك صلاحية لحذف المستخدمين');
            } else {
                throw new Error('فشل حذف المستخدم');
            }
        }
        return response.json();
    })
    .then(data => {
        if (data.success || data.message) {
            alert(data.message || 'تم حذف المستخدم بنجاح'); // Show success message
            // Use the global reference to fetch users
            window.adminFunctions.fetchUsers('all');
        }
    })
    .catch(error => {
        console.error('Error deleting user:', error);
        alert(error.message || 'حدث خطأ أثناء حذف المستخدم');
    });
} 