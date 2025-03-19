<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'عنوان الموقع')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- تضمين مكتبات Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Pusher & Laravel Echo for real-time -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>

    <style>
        .side-drawer {
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            color: white;
            padding: 2rem 1rem;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom Scrollbar for Side Drawer */
        .side-drawer::-webkit-scrollbar {
            width: 6px;
        }

        .side-drawer::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 10px 0;
        }

        .side-drawer::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 8px;
            backdrop-filter: blur(5px);
        }

        .side-drawer::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Firefox scrollbar styling */
        .side-drawer {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.25) rgba(255, 255, 255, 0.1);
        }

        .side-drawer.open {
            transform: translateX(0);
            box-shadow: -5px 0 15px rgba(0,0,0,0.2);
        }

        .drawer-toggle {
            position: fixed;
            right: 20px;
            top: 20px;
            z-index: 1001;
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .drawer-toggle:hover {
            transform: scale(1.05);
        }

        .drawer-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .drawer-link {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .drawer-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .drawer-link.active {
            background: rgba(255,255,255,0.2);
        }

        .drawer-divider {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin: 1rem 0;
        }

        .drawer-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .drawer-profile {
            text-align: center;
            margin-bottom: 2rem;
        }

        .drawer-profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        main {
            transition: margin-right 0.3s ease-in-out;
        }

        main.drawer-open {
            margin-right: 280px;
        }

        @media (max-width: 768px) {
            main.drawer-open {
                margin-right: 0;
            }
        }

        /* Add notification styles */
        .notification-icon {
            position: fixed;
            left: 20px;
            top: 20px;
            z-index: 1001;
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .notification-icon:hover {
            transform: scale(1.05);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .notification-panel {
            position: fixed;
            left: 20px;
            top: 80px;
            width: 360px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 1001;
            display: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .notification-panel.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        .notification-header {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            color: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .notification-list {
            max-height: 420px;
            overflow-y: auto;
            padding: 0;
        }

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item.unread {
            background-color: rgba(37, 117, 252, 0.05);
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2575fc;
        }

        .notification-item .notification-icon {
            position: static;
            width: 46px;
            height: 46px;
            min-width: 46px;
            font-size: 1.1rem;
            border-radius: 12px;
        }

        .notification-content {
            flex-grow: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 6px;
            color: #2575fc;
            font-size: 0.95rem;
            line-height: 1.3;
        }

        .notification-text {
            color: #444;
            font-size: 0.9rem;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .notification-time {
            color: #888;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .notification-time i {
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .notification-empty {
            padding: 40px 20px;
            text-align: center;
            color: #666;
        }
        
        .notification-empty i {
            color: #d0d0d0;
            margin-bottom: 15px;
        }
        
        .notification-empty p {
            color: #888;
            font-size: 0.95rem;
        }
        
        .notification-footer {
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #f0f0f0;
            background: #f9f9f9;
            font-size: 0.85rem;
        }
        
        .notification-footer a {
            color: #2575fc;
            text-decoration: none;
            font-weight: 500;
        }
        
        .notification-loading {
            padding: 40px 20px;
            text-align: center;
        }
        
        .notification-spinner {
            width: 40px;
            height: 40px;
            margin: 0 auto 15px;
            border: 3px solid #f0f0f0;
            border-top: 3px solid #2575fc;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Hide elements on home page */
        body.is-home .notification-icon,
        body.is-home .drawer-toggle,
        body[data-page="login"] .notification-icon,
        body[data-page="login"] .drawer-toggle,
        body[data-page="register"] .notification-icon,
        body[data-page="register"] .drawer-toggle {
            display: none !important;
        }

        /* Hide drawer toggle and notification icon on notifications page */
        body[data-page="notifications"] .drawer-toggle,
        body[data-page="notifications"] .notification-icon {
            display: none !important;
        }
    </style>

    @stack('head')
</head>
<body class="{{ Route::currentRouteName() === 'home' ? 'is-home' : '' }}" data-page="{{ in_array(Route::currentRouteName(), ['login', 'register', 'notifications']) ? Route::currentRouteName() : '' }}">
    <!-- Notification Icon -->
    <button class="notification-icon" onclick="toggleNotifications()" id="notificationButton">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge">0</span>
    </button>

    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h6 class="mb-0 fw-bold">الإشعارات</h6>
            <button class="btn btn-link text-white p-0" onclick="markAllAsRead()">
                <small>تحديد الكل كمقروء</small>
            </button>
        </div>
        
        <!-- Loading State -->
        <div class="notification-loading" id="notificationLoading" style="display: none;">
            <div class="notification-spinner"></div>
            <p class="mb-0 text-muted">جاري تحميل الإشعارات...</p>
        </div>
        
        <!-- Notifications List -->
        <div class="notification-list" id="notificationList">
            <!-- Will be populated dynamically -->
        </div>
        
        <!-- Footer -->
        <div class="notification-footer">
            <a href="/notifications">عرض كل الإشعارات</a>
        </div>
    </div>

    <!-- Side Drawer Toggle Button -->
    <button class="drawer-toggle" onclick="toggleDrawer()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Side Drawer -->
    <div class="side-drawer" id="sideDrawer">
        <div class="drawer-header">
            <h5 class="mb-0">القائمة الرئيسية</h5>
        </div>
        
        <div class="drawer-profile">
            <div class="drawer-profile-image">
                <i class="fas fa-user fa-2x text-white-50"></i>
            </div>
            <h6 class="mb-1" id="drawerUserName">...</h6>
            <small class="text-white-50" id="drawerUserRole">...</small>
        </div>

        <div class="drawer-divider"></div>

        <div class="drawer-content" id="drawerLinks">
            <!-- Links will be populated dynamically -->
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <main id="mainContent">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('sideDrawer');
            const main = document.getElementById('mainContent');
            drawer.classList.toggle('open');
            main.classList.toggle('drawer-open');
        }

        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    return;
                }

                const response = await fetch("/api/user/token/2", {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch user data');
                }

                const user = data.user;
                
                // Update drawer profile
                document.getElementById('drawerUserName').textContent = user.name || 'غير محدد';
                document.getElementById('drawerUserRole').textContent = translateRole(user.role) || 'غير محدد';

                // Handle profile picture in drawer
                const drawerProfileImage = document.querySelector('.drawer-profile-image');
                if (drawerProfileImage) {
                    if (user.profile_picture) {
                        // Create image element if it doesn't exist
                        let imgElement = drawerProfileImage.querySelector('img');
                        if (!imgElement) {
                            imgElement = document.createElement('img');
                            imgElement.className = 'w-100 h-100 rounded-circle';
                            imgElement.alt = user.name || 'User';
                            // Remove existing icon
                            drawerProfileImage.innerHTML = '';
                            drawerProfileImage.appendChild(imgElement);
                        }
                        
                        // Set the image source
                        const storageBaseUrl = window.location.origin + '/storage/';
                        if (user.profile_picture.startsWith('http')) {
                            imgElement.src = user.profile_picture;
                        } else {
                            const picturePath = user.profile_picture.startsWith('/') ? 
                                user.profile_picture.substring(1) : user.profile_picture;
                            imgElement.src = storageBaseUrl + picturePath;
                        }
                    } else {
                        // No profile picture, use icon
                        drawerProfileImage.innerHTML = '<i class="fas fa-user fa-2x text-white-50"></i>';
                    }
                }

                // Generate links based on role
                const drawerLinks = document.getElementById('drawerLinks');
                drawerLinks.innerHTML = ''; // Clear existing links

                // Common links for all users
                drawerLinks.innerHTML += `
                    <a href="/" class="drawer-link">
                        <i class="fas fa-home"></i>
                        الرئيسية
                    </a>
                `;

                // Role-specific links
                switch(user.role) {
                    case 'trainee':
                        drawerLinks.innerHTML += `
                            <a href="/profile" class="drawer-link">
                                <i class="fas fa-user"></i>
                                الملف الشخصي
                            </a>
                            <a href="/trainers" class="drawer-link">
                                <i class="fas fa-chalkboard-teacher"></i>
                                المدربين
                            </a>
                            <a href="/sessions" class="drawer-link">
                                <i class="fas fa-calendar-alt"></i>
                                جلساتي
                            </a>
                        `;
                        break;
                    case 'instructor':
                        drawerLinks.innerHTML += `
                            <a href="/profile" class="drawer-link">
                                <i class="fas fa-user"></i>
                                الملف الشخصي
                            </a>
                            
                            <a href="/schedule" class="drawer-link">
                                <i class="fas fa-calendar-alt"></i>
                                جدولي
                            </a>
                            <a href="/trainees" class="drawer-link">
                                <i class="fas fa-users"></i>
                                المتدربين
                            </a>
                                <a href="/trainers" class="drawer-link">
                                <i class="fas fa-chalkboard-teacher"></i>
                                المدربين
                            </a>
                        `;
                        break;


                        case 'training_center':
                        drawerLinks.innerHTML += `
                            <a href="/profile" class="drawer-link">
                                <i class="fas fa-user"></i>
                                الملف الشخصي
                            </a>
                            
                            <a href="/trainees" class="drawer-link">
                                <i class="fas fa-users"></i>
                                المتدربين
                            </a>
                                <a href="/trainers" class="drawer-link">
                                <i class="fas fa-chalkboard-teacher"></i>
                                المدربين
                            </a>
                        `;
                        break;







                    case 'admin':
                        drawerLinks.innerHTML += `
                            <a href="/admin" class="drawer-link">
                                <i class="fas fa-tachometer-alt"></i>
                                لوحة التحكم
                            </a>
                            <a href="/trainers" class="drawer-link">
                                <i class="fas fa-users"></i>
                                المدربين
                            </a>
                            <a href="/settings" class="drawer-link">
                                <i class="fas fa-cog"></i>
                                الإعدادات
                            </a>
                        `;
                        break;
                }

                // Add logout link for all users
                drawerLinks.innerHTML += `
                    <div class="drawer-divider"></div>
                    <a href="#" onclick="logout()" class="drawer-link text-warning">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </a>
                `;

            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        });

        function translateRole(role) {
            const roles = {
                'admin': 'مدير النظام',
                'trainer': 'مدرب',
                'trainee': 'متدرب'
            };
            return roles[role] || role;
        }

        function logout() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }

        // Highlight active link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const links = document.querySelectorAll('.drawer-link');
            links.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

        // Add notification functions
        let notifications = [];
        let unreadCount = 0;
        let echo = null;

        function toggleNotifications() {
            const panel = document.getElementById('notificationPanel');
            panel.classList.toggle('show');
            
            // Load notifications if we haven't already or if there was an error
            if (notifications.length === 0) {
                fetchNotifications();
            }
        }

        function updateNotificationBadge() {
            const badge = document.getElementById('notificationBadge');
            if (!badge) return; // Ensure element exists
            
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'flex' : 'none';
        }

        function markAllAsRead() {
            // First update UI for better responsiveness
            notifications.forEach(notification => {
                notification.isRead = true;
            });
            unreadCount = 0;
            updateNotificationBadge();
            renderNotifications();
            
            // Then send to server
            markAllAsReadOnServer().catch(error => {
                console.warn("Failed to mark all as read on server, but UI is updated", error);
            });
        }

        function formatTimeAgo(date) {
            try {
                const now = new Date();
                const diff = Math.floor((now - date) / 1000); // difference in seconds

                if (diff < 60) return 'منذ لحظات';
                if (diff < 3600) return `منذ ${Math.floor(diff / 60)} دقيقة`;
                if (diff < 86400) return `منذ ${Math.floor(diff / 3600)} ساعة`;
                if (diff < 2592000) return `منذ ${Math.floor(diff / 86400)} يوم`;
                return date.toLocaleDateString('ar-SA');
            } catch (e) {
                console.error("Error formatting date", e);
                return 'غير معروف';
            }
        }

        function renderNotifications() {
            const list = document.getElementById('notificationList');
            const loadingElement = document.getElementById('notificationLoading');
            
            if (!list || !loadingElement) {
                console.error("Notification elements not found in DOM");
                return;
            }
            
            // Hide loading first
            loadingElement.style.display = 'none';
            
            if (notifications.length === 0) {
                list.innerHTML = `
                    <div class="notification-empty">
                        <i class="fas fa-bell-slash fa-2x"></i>
                        <p class="mb-0">لا توجد إشعارات جديدة</p>
                    </div>
                `;
                return;
            }

            try {
                list.innerHTML = notifications.map(notification => `
                    <div class="notification-item ${notification.isRead ? '' : 'unread'}" 
                         onclick="handleNotificationClick(${notification.id})">
                        <div class="notification-icon" style="background: ${notification.color || '#2575fc'}">
                            <i class="fas ${notification.icon || 'fa-bell'}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${notification.title || 'إشعار جديد'}</div>
                            <div class="notification-text">${notification.message || ''}</div>
                            <div class="notification-time">
                                <i class="fas fa-clock"></i>
                                ${formatTimeAgo(new Date(notification.timestamp))}
                            </div>
                        </div>
                    </div>
                `).join('');
            } catch (e) {
                console.error("Error rendering notifications", e);
                list.innerHTML = `
                    <div class="notification-empty">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                        <p class="mb-0">حدث خطأ أثناء عرض الإشعارات</p>
                    </div>
                `;
            }
        }

        function handleNotificationClick(id) {
            try {
                const notification = notifications.find(n => n.id === id);
                if (!notification) {
                    console.error("Notification not found:", id);
                    return;
                }
                
                if (!notification.isRead) {
                    // First update UI for better responsiveness
                    notification.isRead = true;
                    unreadCount = Math.max(0, unreadCount - 1);
                    updateNotificationBadge();
                    renderNotifications();
                    
                    // Then send to server
                    markNotificationAsRead(id).catch(error => {
                        console.warn("Failed to mark notification as read on server, but UI is updated", error);
                    });
                }
                
                // Handle navigation
                if (notification.link && notification.link !== '#') {
                    window.location.href = notification.link;
                }
            } catch (e) {
                console.error("Error handling notification click", e);
            }
        }

        // Function to add a new notification
        function addNotification(notification) {
            try {
                notifications.unshift({
                    id: notification.id || Date.now(),
                    timestamp: notification.timestamp || new Date(),
                    isRead: notification.isRead || false,
                    title: notification.title || 'إشعار جديد',
                    message: notification.message || '',
                    icon: notification.icon || 'fa-bell',
                    color: notification.color || '#2575fc',
                    link: notification.link || '#'
                });
                
                if (!notification.isRead) {
                    unreadCount++;
                    updateNotificationBadge();
                }
                
                renderNotifications();
                
                // Show toast notification
                try {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-left",
                        "timeOut": "5000"
                    };
                    toastr.info(notification.message, notification.title);
                } catch (e) {
                    console.warn("Toastr not available for notifications", e);
                }
            } catch (e) {
                console.error("Error adding notification", e);
            }
        }

        // Function to fetch notifications from server
        async function fetchNotifications() {
            const loadingElement = document.getElementById('notificationLoading');
            if (loadingElement) {
                loadingElement.style.display = 'block';
            }
            
            const token = localStorage.getItem('token');
            if (!token) {
                console.log('No token found, using mock data');
                setTimeout(() => {
                    useMockNotificationsData();
                    if (loadingElement) {
                        loadingElement.style.display = 'none';
                    }
                }, 500);
                return;
            }
            
            try {
                console.log('Fetching notifications with token');
                
                // Use the correct API endpoint
                const response = await fetch('/api/notification', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                // Hide loading state on completion
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }

                if (!response.ok) {
                    console.error(`API error: ${response.status} ${response.statusText}`);
                    return;
                }

                const data = await response.json();
                console.log('API Response:', data);

                // Handle whatever format the API returns, with flexible parsing
                if (data && (data.success || data.data || data.notifications || Array.isArray(data))) {
                    let notificationsData;
                    
                    // Handle different possible response formats
                    if (Array.isArray(data)) {
                        notificationsData = data;
                    } else if (data.notifications && Array.isArray(data.notifications)) {
                        notificationsData = data.notifications;
                    } else if (data.data && Array.isArray(data.data)) {
                        notificationsData = data.data;
                    } else if (data.data && data.data.notifications && Array.isArray(data.data.notifications)) {
                        notificationsData = data.data.notifications;
                    } else {
                        notificationsData = [];
                        console.error('Could not find notifications array in response:', data);
                    }
                    
                    console.log('Parsed notifications:', notificationsData);
                    
                    if (notificationsData && notificationsData.length > 0) {
                        // Map API response to our frontend format
                        notifications = notificationsData.map(item => {
                            // Print details of each notification for debugging
                            console.log('Processing notification:', item);
                            
                            return {
                                id: item.id || Date.now(),
                                title: item.title || item.subject || 'إشعار جديد',
                                message: item.message || item.content || item.body || item.text || '',
                                timestamp: new Date(item.created_at || item.timestamp || item.date || Date.now()),
                                isRead: item.read_at !== null && item.read_at !== undefined,
                                icon: getNotificationIcon(item.type || item.notification_type),
                                color: getNotificationColor(item.type || item.notification_type),
                                link: item.link || item.url || getNotificationLink(item)
                            };
                        });

                        unreadCount = notifications.filter(n => !n.isRead).length;
                        updateNotificationBadge();
                        renderNotifications();
                        
                        console.log('Notifications processed successfully:', notifications.length);
                    } else {
                        console.log('No notifications found in response');
                        // Empty but valid response
                        notifications = [];
                        unreadCount = 0;
                        updateNotificationBadge();
                        renderNotifications();
                    }
                } else {
                    console.error('Invalid API response format:', data);
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
                // Hide loading state on error
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
                
                const list = document.getElementById('notificationList');
                if (list) {
                    list.innerHTML = `
                        <div class="notification-empty">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                            <p class="mb-0">حدث خطأ أثناء تحميل الإشعارات</p>
                        </div>
                    `;
                }
            }
        }
        
        // Use mock data for testing if API is not available
        function useMockNotificationsData() {
            console.log('Using mock notifications data as fallback');
            notifications = [
                {
                    id: 1,
                    title: 'موعد جلسة تدريب',
                    message: 'لديك جلسة تدريب قيادة غداً الساعة 3:00 مساءً',
                    timestamp: new Date(Date.now() - 1000 * 60 * 30), // 30 minutes ago
                    isRead: false,
                    icon: 'fa-calendar-check',
                    color: '#28a745',
                    link: '/sessions/1'
                },
                {
                    id: 2,
                    title: 'تقييم جديد',
                    message: 'قام أحد المتدربين بتقييم أدائك بـ 5 نجوم',
                    timestamp: new Date(Date.now() - 1000 * 60 * 60 * 3), // 3 hours ago
                    isRead: true,
                    icon: 'fa-star',
                    color: '#fd7e14',
                    link: '/profile'
                },
                {
                    id: 3,
                    title: 'تحديث في الملف الشخصي',
                    message: 'تم تحديث بياناتك الشخصية بنجاح',
                    timestamp: new Date(Date.now() - 1000 * 60 * 60 * 24), // 1 day ago
                    isRead: true,
                    icon: 'fa-user-edit',
                    color: '#6f42c1',
                    link: '/profile'
                }
            ];
            
            unreadCount = notifications.filter(n => !n.isRead).length;
            updateNotificationBadge();
            renderNotifications();
        }

        // Helper function to get appropriate icon based on notification type
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

        // Helper function to get appropriate color based on notification type
        function getNotificationColor(type) {
            const colors = {
                'session_scheduled': '#28a745', // Success green
                'session_cancelled': '#dc3545', // Danger red
                'session_reminder': '#ffc107', // Warning yellow
                'new_message': '#17a2b8', // Info blue
                'profile_update': '#6f42c1', // Purple
                'payment': '#28a745', // Success green
                'rating': '#fd7e14', // Orange
                'system': '#6c757d' // Gray
            };
            return colors[type] || '#2575fc';
        }

        // Helper function to generate appropriate link based on notification
        function getNotificationLink(notification) {
            try {
                if (!notification || !notification.type) return '#';
                
                switch(notification.type) {
                    case 'session_scheduled':
                    case 'session_cancelled':
                    case 'session_reminder':
                        return `/sessions/${notification.data?.session_id || ''}`;
                    case 'new_message':
                        return `/messages/${notification.data?.conversation_id || ''}`;
                    case 'profile_update':
                        return '/profile';
                    case 'payment':
                        return `/payments/${notification.data?.payment_id || ''}`;
                    case 'rating':
                        return `/sessions/${notification.data?.session_id || ''}`;
                    default:
                        return '#';
                }
            } catch (e) {
                console.error("Error getting notification link", e);
                return '#';
            }
        }

        // Function to mark a notification as read
        async function markNotificationAsRead(notificationId) {
            try {
                const token = localStorage.getItem('token');
                if (!token) return;

                console.log(`Marking notification ${notificationId} as read`);
                
                const response = await fetch(`/api/notification/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || 'Failed to mark notification as read');
                }
                
                console.log(`Successfully marked notification ${notificationId} as read`);
            } catch (error) {
                console.error('Error marking notification as read:', error);
                throw error; // Rethrow to handle in the calling function
            }
        }

        // Update markAllAsRead to handle backend
        async function markAllAsReadOnServer() {
            try {
                const token = localStorage.getItem('token');
                if (!token) return;

                console.log('Marking all notifications as read');
                
                const response = await fetch('/api/notification/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || 'Failed to mark all notifications as read');
                }
                
                console.log('Successfully marked all notifications as read');
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
                throw error; // Rethrow to handle in the calling function
            }
        }

        // Initialize Laravel Echo for real-time notifications
        function initializeEcho() {
            const token = localStorage.getItem('token');
            if (!token) return null;

            // Get user ID from token (assuming JWT)
            let userId = null;
            try {
                const tokenParts = token.split('.');
                if (tokenParts.length === 3) {
                    const payload = JSON.parse(atob(tokenParts[1]));
                    userId = payload.sub || payload.id;
                }
            } catch (e) {
                console.error('Error parsing token:', e);
            }

            if (!userId) {
                console.warn('Could not get user ID from token');
                return null;
            }

            console.log('Initializing Echo for user:', userId);

            // Initialize Pusher and Laravel Echo
            window.Pusher = Pusher;
            
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env("PUSHER_APP_KEY") }}',
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                }
            });

            // Listen for notifications on the private user channel
            window.Echo.private(`App.Models.User.${userId}`)
                .notification((notification) => {
                    console.log('Received notification via WebSocket:', notification);
                    handleNewNotification(notification);
                });

            return window.Echo;
        }

        // Handle new notification received via WebSocket
        function handleNewNotification(notification) {
            console.log('Processing real-time notification:', notification);
            
            // Format notification data for our UI
            const formattedNotification = {
                id: notification.id || Date.now(),
                title: notification.title || notification.subject || 'إشعار جديد',
                message: notification.message || notification.body || notification.content || '',
                timestamp: new Date(),
                isRead: false,
                icon: getNotificationIcon(notification.type),
                color: getNotificationColor(notification.type),
                link: notification.link || getNotificationLink(notification)
            };

            // Add notification to list and update UI
            addNotification(formattedNotification);
            
            // Show toast notification
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-left",
                "timeOut": "5000",
                "onclick": function() {
                    if (formattedNotification.link && formattedNotification.link !== '#') {
                        window.location.href = formattedNotification.link;
                    }
                }
            };
            toastr.info(formattedNotification.message, formattedNotification.title);
            
            // Play notification sound
            playNotificationSound();
        }

        // Function to play notification sound
        function playNotificationSound() {
            try {
                const audio = new Audio('/assets/sounds/notification.mp3');
                audio.volume = 0.5;
                audio.play().catch(e => console.warn('Could not play notification sound:', e));
            } catch (e) {
                console.warn('Error playing notification sound:', e);
            }
        }

        // Initialize notifications when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing notification system');
            
            try {
                updateNotificationBadge();
                fetchNotifications();
                
                // Initialize WebSocket connection for real-time notifications
                echo = initializeEcho();
                
                // Close notification panel when clicking outside
                document.addEventListener('click', function(event) {
                    const panel = document.getElementById('notificationPanel');
                    const button = document.getElementById('notificationButton');
                    if (panel && button && !panel.contains(event.target) && !button.contains(event.target)) {
                        panel.classList.remove('show');
                    }
                });
            } catch (e) {
                console.error("Error initializing notification system:", e);
            }
        });

        // Clean up echo on page unload
        window.addEventListener('beforeunload', function() {
            if (echo) {
                echo.disconnect();
            }
        });
    </script>
</body>
</html>

