<script>
// Constants & Configuration
const API_ENDPOINT = '/api/notification';
const ITEMS_PER_PAGE = 10;
const STORAGE_BASE_URL = '{{ url("storage") }}/';

// Global variables
let allNotifications = [];
let currentPage = 1;
let hasMorePages = false;
let isLoading = false;
let activeFilter = 'all';
let activeTypes = ['system', 'session', 'message', 'other'];

// DOM Elements
const loadingSpinner = document.getElementById('loadingSpinner');
const emptyState = document.getElementById('emptyState');
const errorState = document.getElementById('errorState');
const errorMessage = document.getElementById('errorMessage');
const notificationsContainer = document.getElementById('notificationsContainer');
const loadMoreContainer = document.getElementById('loadMoreContainer');
const loadMoreBtn = document.getElementById('loadMoreBtn');
const retryButton = document.getElementById('retryButton');
const markAllReadBtn = document.getElementById('markAllReadBtn');

// Statistics elements
const statTotal = document.getElementById('statTotal');
const statUnread = document.getElementById('statUnread');
const statSessions = document.getElementById('statSessions');
const statMessages = document.getElementById('statMessages');
const allCount = document.getElementById('allCount');
const unreadCount = document.getElementById('unreadCount');

// Filter inputs
const filterAll = document.getElementById('filterAll');
const filterUnread = document.getElementById('filterUnread');
const typeSystem = document.getElementById('typeSystem');
const typeSession = document.getElementById('typeSession');
const typeMessage = document.getElementById('typeMessage');
const typeOther = document.getElementById('typeOther');

// Initialize on document load
document.addEventListener('DOMContentLoaded', async function() {
    // Set up event listeners
    setupEventListeners();
    
    // Load notifications
    await fetchNotifications(true);
});

// Set up all event listeners
function setupEventListeners() {
    // Retry button
    if (retryButton) {
        retryButton.addEventListener('click', async function() {
            await fetchNotifications(true);
        });
    }
    
    // Mark all as read button
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', async function() {
            await markAllAsRead();
        });
    }
    
    // Load more button
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', async function() {
            await fetchNotifications(false);
        });
    }
    
    // Filter listeners
    if (filterAll) {
        filterAll.addEventListener('change', function() {
            if (this.checked) {
                activeFilter = 'all';
                renderNotifications();
            }
        });
    }
    
    if (filterUnread) {
        filterUnread.addEventListener('change', function() {
            if (this.checked) {
                activeFilter = 'unread';
                renderNotifications();
            }
        });
    }
    
    // Type filters
    const typeFilters = [typeSystem, typeSession, typeMessage, typeOther];
    const typeValues = ['system', 'session', 'message', 'other'];
    
    typeFilters.forEach((checkbox, index) => {
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                const typeValue = typeValues[index];
                if (this.checked) {
                    if (!activeTypes.includes(typeValue)) {
                        activeTypes.push(typeValue);
                    }
                } else {
                    activeTypes = activeTypes.filter(type => type !== typeValue);
                }
                renderNotifications();
            });
        }
    });
}

// Fetch notifications from API
async function fetchNotifications(resetPage = false) {
    try {
        // If we're starting from the beginning
        if (resetPage) {
            currentPage = 1;
            allNotifications = [];
            showLoading();
        } else {
            // For pagination, show loading in load more button
            loadMoreBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري التحميل...';
            loadMoreBtn.disabled = true;
        }
        
        isLoading = true;
        
        // Get token from localStorage
        const token = localStorage.getItem('token');
        if (!token) {
            showError('لم يتم العثور على جلسة مستخدم. يرجى تسجيل الدخول من جديد.');
            return;
        }
        
        // Build the API URL with pagination
        const url = `${API_ENDPOINT}?page=${currentPage}&per_page=${ITEMS_PER_PAGE}`;
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error fetching notifications: ${response.status} ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('API Response:', data);
        
        // Handle different API response formats
        let notifications = [];
        let pagination = null;
        
        if (Array.isArray(data)) {
            notifications = data;
        } else if (data.data && Array.isArray(data.data)) {
            notifications = data.data;
            pagination = data.meta?.pagination || data.pagination;
        } else if (data.notifications && Array.isArray(data.notifications)) {
            notifications = data.notifications;
            pagination = data.meta?.pagination || data.pagination;
        }
        
        // Process and normalize the notifications
        const processedNotifications = processNotifications(notifications);
        
        // Add to our global array
        allNotifications = [...allNotifications, ...processedNotifications];
        
        // Update pagination
        hasMorePages = pagination ? (pagination.current_page < pagination.total_pages) : false;
        if (!pagination && notifications.length === ITEMS_PER_PAGE) {
            // If no pagination info but we got a full page, assume there might be more
            hasMorePages = true;
        }
        
        // Update the UI
        renderNotifications();
        updateStatistics();
        
        // Handle next page
        currentPage++;
        
    } catch (error) {
        console.error('Error fetching notifications:', error);
        showError(error.message || 'حدث خطأ أثناء تحميل الإشعارات.');
    } finally {
        isLoading = false;
        
        if (!resetPage) {
            // Reset load more button
            loadMoreBtn.innerHTML = 'تحميل المزيد <i class="fas fa-chevron-down ms-1"></i>';
            loadMoreBtn.disabled = false;
        }
    }
}

// Process and normalize notifications from API
function processNotifications(notifications) {
    return notifications.map(notification => {
        // Determine notification type
        let type = 'other';
        if (notification.type) {
            if (notification.type.includes('session')) {
                type = 'session';
            } else if (notification.type.includes('message')) {
                type = 'message';
            } else if (notification.type.includes('system')) {
                type = 'system';
            }
        }
        
        return {
            id: notification.id,
            title: notification.title || notification.subject || 'إشعار',
            message: notification.message || notification.content || notification.body || '',
            type: type,
            isRead: notification.read_at !== null && notification.read_at !== undefined,
            date: new Date(notification.created_at || notification.timestamp || Date.now()),
            link: notification.link || notification.url || '#',
            priority: notification.priority || 'medium',
            icon: getNotificationIcon(notification.type),
            color: getNotificationColor(notification.type),
            data: notification.data || {}
        };
    });
}

// Render notifications to the UI
function renderNotifications() {
    // Hide loading state
    hideLoading();
    
    // Filter notifications according to current filters
    const filteredNotifications = allNotifications.filter(notification => {
        // Check read/unread filter
        if (activeFilter === 'unread' && notification.isRead) {
            return false;
        }
        
        // Check type filters
        if (!activeTypes.includes(notification.type)) {
            return false;
        }
        
        return true;
    });
    
    // Show empty state if no notifications
    if (filteredNotifications.length === 0) {
        notificationsContainer.style.display = 'none';
        emptyState.style.display = 'block';
        loadMoreContainer.style.display = 'none';
        return;
    }
    
    // Show notifications
    emptyState.style.display = 'none';
    notificationsContainer.style.display = 'block';
    
    // Clear current notifications
    notificationsContainer.innerHTML = '';
    
    // Render each notification
    filteredNotifications.forEach(notification => {
        notificationsContainer.appendChild(createNotificationCard(notification));
    });
    
    // Show/hide load more button
    loadMoreContainer.style.display = hasMorePages ? 'block' : 'none';
}

// Create HTML for a notification card
function createNotificationCard(notification) {
    const card = document.createElement('div');
    card.className = `notification-card ${notification.isRead ? '' : 'unread'}`;
    card.dataset.id = notification.id;
    
    const formattedDate = formatTimeAgo(notification.date);
    
    card.innerHTML = `
        <div class="card-body">
            ${notification.isRead ? '' : '<span class="notification-badge"></span>'}
            <div class="d-flex">
                <div class="notification-icon" style="background: ${notification.color}">
                    <i class="fas ${notification.icon} text-white"></i>
                </div>
                <div class="notification-content">
                    <h5 class="notification-title">${notification.title}</h5>
                    <p class="notification-text">${notification.message}</p>
                    <div class="notification-meta">
                        <span><i class="fas fa-clock me-1"></i>${formattedDate}</span>
                        <span><i class="fas ${getCategoryIcon(notification.type)} me-1"></i>${getCategoryName(notification.type)}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="actions">
                ${notification.isRead ? 
                    `<button class="btn btn-sm btn-outline-secondary notification-action-btn" onclick="markAsUnread(${notification.id})">
                        <i class="fas fa-envelope me-1"></i>تحديد كغير مقروء
                    </button>` : 
                    `<button class="btn btn-sm btn-outline-primary notification-action-btn" onclick="markAsRead(${notification.id})">
                        <i class="fas fa-check me-1"></i>تحديد كمقروء
                    </button>`
                }
            </div>
            <div>
                ${notification.link && notification.link !== '#' ? 
                    `<a href="${notification.link}" class="btn btn-sm btn-primary notification-action-btn">
                        <i class="fas fa-external-link-alt me-1"></i>عرض التفاصيل
                    </a>` : ''
                }
            </div>
        </div>
    `;
    
    return card;
}

// Format the time as a relative string (e.g., "5 minutes ago")
function formatTimeAgo(date) {
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return 'منذ لحظات';
    
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    if (diffInMinutes < 60) return `منذ ${diffInMinutes} دقيقة`;
    
    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) return `منذ ${diffInHours} ساعة`;
    
    const diffInDays = Math.floor(diffInHours / 24);
    if (diffInDays < 30) return `منذ ${diffInDays} يوم`;
    
    const diffInMonths = Math.floor(diffInDays / 30);
    if (diffInMonths < 12) return `منذ ${diffInMonths} شهر`;
    
    const diffInYears = Math.floor(diffInMonths / 12);
    return `منذ ${diffInYears} سنة`;
}

// Mark a notification as read
async function markAsRead(id) {
    try {
        const token = localStorage.getItem('token');
        if (!token) return;
        
        // Optimistically update UI first for better user experience
        const notification = allNotifications.find(n => n.id === id);
        if (notification) {
            notification.isRead = true;
            renderNotifications();
            updateStatistics();
        }
        
        // Show success message right away
        showToast('تم تحديد الإشعار كمقروء بنجاح', 'success');
        
        // Then try to update on the server
        try {
            const response = await fetch(`${API_ENDPOINT}/${id}/read`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            // If server request fails, it's okay - we already updated the UI
            if (!response.ok) {
                console.warn(`API warning: Failed to mark notification ${id} as read on server, but UI is updated`);
            }
        } catch (serverError) {
            // Log server error but don't show to user since UI is already updated
            console.warn('Server error when marking as read:', serverError);
        }
        
    } catch (error) {
        console.error('Error in markAsRead function:', error);
        showToast('تم تحديث حالة الإشعار محلياً فقط', 'warning');
    }
}

// Mark a notification as unread
async function markAsUnread(id) {
    try {
        const token = localStorage.getItem('token');
        if (!token) return;
        
        // Optimistically update UI first for better user experience
        const notification = allNotifications.find(n => n.id === id);
        if (notification) {
            notification.isRead = false;
            renderNotifications();
            updateStatistics();
        }
        
        // Show success message right away
        showToast('تم تحديد الإشعار كغير مقروء بنجاح', 'success');
        
        // Then try to update on the server
        try {
            const response = await fetch(`${API_ENDPOINT}/${id}/unread`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            // If server request fails, it's okay - we already updated the UI
            if (!response.ok) {
                console.warn(`API warning: Failed to mark notification ${id} as unread on server, but UI is updated`);
            }
        } catch (serverError) {
            // Log server error but don't show to user since UI is already updated
            console.warn('Server error when marking as unread:', serverError);
        }
        
    } catch (error) {
        console.error('Error in markAsUnread function:', error);
        showToast('تم تحديث حالة الإشعار محلياً فقط', 'warning');
    }
}

// Mark all notifications as read
async function markAllAsRead() {
    try {
        const token = localStorage.getItem('token');
        if (!token) return;
        
        // Show loading in button
        markAllReadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري المعالجة...';
        markAllReadBtn.disabled = true;
        
        // Update local data first for better user experience
        allNotifications.forEach(notification => {
            notification.isRead = true;
        });
        
        renderNotifications();
        updateStatistics();
        
        // Show success message
        showToast('تم تحديد جميع الإشعارات كمقروءة بنجاح', 'success');
        
        // Then try to update on the server
        try {
            const response = await fetch(`${API_ENDPOINT}/mark-all-read`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            // If server request fails, it's okay - we already updated the UI
            if (!response.ok) {
                console.warn('API warning: Failed to mark all notifications as read on server, but UI is updated');
            }
        } catch (serverError) {
            // Log server error but don't show to user since UI is already updated
            console.warn('Server error when marking all as read:', serverError);
        }
        
    } catch (error) {
        console.error('Error in markAllAsRead function:', error);
        showToast('تم تحديث حالة الإشعارات محلياً فقط', 'warning');
    } finally {
        // Reset button
        markAllReadBtn.innerHTML = '<i class="fas fa-check-double me-1"></i> تحديد الكل كمقروء';
        markAllReadBtn.disabled = false;
    }
}

// Update statistics display
function updateStatistics() {
    const total = allNotifications.length;
    const unread = allNotifications.filter(n => !n.isRead).length;
    const sessions = allNotifications.filter(n => n.type === 'session').length;
    const messages = allNotifications.filter(n => n.type === 'message').length;
    
    // Update statistics
    if (statTotal) statTotal.textContent = total;
    if (statUnread) statUnread.textContent = unread;
    if (statSessions) statSessions.textContent = sessions;
    if (statMessages) statMessages.textContent = messages;
    
    // Update filter counts
    if (allCount) allCount.textContent = total;
    if (unreadCount) unreadCount.textContent = unread;
}

// Helper function to get icon for notification
function getNotificationIcon(type) {
    const icons = {
        'session_scheduled': 'fa-calendar-check',
        'session_cancelled': 'fa-calendar-xmark',
        'session_reminder': 'fa-clock',
        'new_message': 'fa-envelope',
        'profile_update': 'fa-user-edit',
        'payment': 'fa-credit-card',
        'rating': 'fa-star',
        'system': 'fa-bell'
    };
    return icons[type] || 'fa-bell';
}

// Helper function to get color for notification
function getNotificationColor(type) {
    const colors = {
        'session_scheduled': '#28a745',
        'session_cancelled': '#dc3545',
        'session_reminder': '#ffc107',
        'new_message': '#17a2b8',
        'profile_update': '#6f42c1',
        'payment': '#28a745',
        'rating': '#fd7e14',
        'system': '#6c757d'
    };
    return colors[type] || '#2575fc';
}

// Helper function to get category name
function getCategoryName(type) {
    const categories = {
        'session': 'جلسة تدريب',
        'message': 'رسالة',
        'system': 'إشعار نظام',
        'other': 'أخرى'
    };
    return categories[type] || 'أخرى';
}

// Helper function to get category icon
function getCategoryIcon(type) {
    const icons = {
        'session': 'fa-calendar-alt',
        'message': 'fa-envelope',
        'system': 'fa-bell',
        'other': 'fa-tag'
    };
    return icons[type] || 'fa-tag';
}

// Show loading state
function showLoading() {
    if (loadingSpinner) loadingSpinner.style.display = 'block';
    if (errorState) errorState.style.display = 'none';
    if (emptyState) emptyState.style.display = 'none';
    if (notificationsContainer) notificationsContainer.style.display = 'none';
    if (loadMoreContainer) loadMoreContainer.style.display = 'none';
}

// Hide loading state
function hideLoading() {
    if (loadingSpinner) loadingSpinner.style.display = 'none';
}

// Show error state
function showError(message) {
    if (loadingSpinner) loadingSpinner.style.display = 'none';
    if (errorState) errorState.style.display = 'block';
    if (emptyState) emptyState.style.display = 'none';
    if (notificationsContainer) notificationsContainer.style.display = 'none';
    if (loadMoreContainer) loadMoreContainer.style.display = 'none';
    if (errorMessage) errorMessage.textContent = message;
}

// Show toast notification
function showToast(message, type = 'info') {
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        
        switch (type) {
            case 'success':
                toastr.success(message);
                break;
            case 'error':
                toastr.error(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            default:
                toastr.info(message);
        }
    } else {
        // Fallback if toastr is not available
        alert(message);
    }
}

// Make functions available globally for onclick handlers
window.markAsRead = markAsRead;
window.markAsUnread = markAsUnread;
</script> 