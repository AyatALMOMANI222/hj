@extends('app')

@section('content')
<div class="session-container" dir="rtl">
    <!-- Header Section -->
    <div class="session-header mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-content p-4 rounded-4">
                        <h1 class="session-title mb-2">الجلسات المتاحة</h1>
                        <p class="session-subtitle">اختر التاريخ والوقت المناسب لحجز جلسة تدريب</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="session-content">
        <div class="container">
            <div class="row">
                <!-- Date Selection Column -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-light p-3">
                            <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>اختر التاريخ</h5>
                        </div>
                        <div class="card-body p-3">
                            <div class="date-selection">
                                <label for="sessionDate" class="form-label">التاريخ</label>
                                <input type="date" class="form-control mb-3" id="sessionDate" min="{{ date('Y-m-d') }}">
                                
                                <div class="quick-dates mt-2 mb-3">
                                    <p class="small text-muted mb-2">تاريخ سريع:</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-sm btn-outline-primary quick-date" data-days="0">اليوم</button>
                                        <button class="btn btn-sm btn-outline-primary quick-date" data-days="1">غداً</button>
                                        <button class="btn btn-sm btn-outline-primary quick-date" data-days="7">الأسبوع القادم</button>
                                    </div>
                                </div>

                                <div class="date-info mt-4">
                                    <div class="date-info-item">
                                        <i class="fas fa-clock text-primary"></i>
                                        <span>مدة الجلسة: <span id="sessionTimeDisplay">45</span> دقيقة</span>
                                    </div>
                                    <div class="date-info-item">
                                        <i class="fas fa-hourglass-half text-primary"></i>
                                        <span>وقت الراحة: <span id="breakTimeDisplay">15</span> دقيقة</span>
                                    </div>
                                    <div class="date-info-item">
                                        <i class="fas fa-sun text-primary"></i>
                                        <span>ساعات العمل: <span id="workHoursDisplay">8 صباحاً - 6 مساءً</span></span>
                                    </div>
                                    <div class="date-info-item" id="availableDaysContainer" style="display: none;">
                                        <i class="fas fa-calendar-day text-primary"></i>
                                        <span>الأيام المتاحة: <span id="availableDaysDisplay"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Sessions Column -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-light p-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fas fa-list-alt me-2 text-primary"></i>الجلسات المتاحة</h5>
                            <span class="selected-date-display" id="selectedDateDisplay"></span>
                        </div>
                        <div class="card-body p-3">
                            <div id="loadingState" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">جاري التحميل...</span>
                                </div>
                                <p class="mt-2">جاري البحث عن الجلسات المتاحة...</p>
                            </div>
                            
                            <div id="noSessionsState" class="text-center py-5 d-none">
                                <i class="fas fa-calendar-times text-muted fa-3x mb-3"></i>
                                <h5>لا توجد جلسات متاحة</h5>
                                <p>الرجاء اختيار تاريخ آخر أو التواصل مع المدرب</p>
                            </div>
                            
                            <div id="sessionsContainer" class="d-none">
                                <div class="row session-slots" id="sessionSlots">
                                    <!-- Session slots will be inserted here dynamically -->
                                </div>
                            </div>

                            <div id="bookingConfirmation" class="mt-4 d-none">
                                <hr>
                                <div class="selected-session-info p-3 rounded mb-3">
                                    <h5 class="confirmation-title">تأكيد الحجز</h5>
                                    <div class="selected-session-details" id="selectedSessionDetails"></div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="startingLocation" class="form-label">موقع بدء الجلسة <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="startingLocation" rows="3" placeholder="يرجى إدخال العنوان التفصيلي لنقطة البداية..."></textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="sessionNotes" class="form-label">ملاحظات إضافية</label>
                                    <textarea class="form-control" id="sessionNotes" rows="2" placeholder="أي معلومات إضافية ترغب في إخبار المدرب بها..."></textarea>
                                </div>
                                
                                <div class="text-center">
                                    <button type="button" id="confirmBookingBtn" class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-check-circle me-2"></i>تأكيد الحجز
                                    </button>
                                    <button type="button" id="cancelSelectionBtn" class="btn btn-outline-secondary ms-2">
                                        <i class="fas fa-times me-2"></i>إلغاء
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

@prepend('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .session-container {
        padding: 20px;
        font-family: 'Cairo', sans-serif;
    }

    .session-header .header-content {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }

    .session-title {
        font-weight: 700;
        font-size: 2rem;
    }

    .session-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: none;
    }

    .selected-date-display {
        font-weight: 600;
        color: #4e73df;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    .date-info {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .date-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    .date-info-item i {
        margin-left: 10px;
        width: 20px;
        text-align: center;
    }

    .session-slot {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .session-slot:hover {
        border-color: #4e73df;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .session-slot.selected {
        border-color: #4e73df;
        background-color: rgba(78, 115, 223, 0.05);
    }

    .session-time {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    .session-period {
        display: block;
        font-size: 0.8rem;
        color: #666;
    }

    .selected-session-info {
        background-color: rgba(78, 115, 223, 0.05);
        border: 1px solid rgba(78, 115, 223, 0.2);
        border-radius: 10px;
    }

    .confirmation-title {
        color: #4e73df;
        margin-bottom: 15px;
        font-weight: 600;
    }

    /* Toast Notifications */
    .toast-container {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        width: auto;
        max-width: 90%;
    }

    .toast {
        border-radius: 8px;
        color: white;
        padding: 15px 25px;
        margin-bottom: 10px;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slide-in 0.3s ease-out forwards;
        direction: rtl;
        text-align: right;
    }

    .toast.success {
        background-color: #28a745;
    }

    .toast.error {
        background-color: #dc3545;
    }

    .toast-content {
        display: flex;
        align-items: center;
    }

    .toast-icon {
        margin-left: 12px;
        font-size: 1.2rem;
    }

    .toast-close {
        margin-right: 10px;
        background: none;
        border: none;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .toast-close:hover {
        opacity: 1;
    }

    @keyframes slide-in {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fade-out {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .card {
            background-color: #2a2d3a;
            color: #e0e0e0;
        }
        
        .card-header {
            background: linear-gradient(135deg, #3a3f51, #2a2d3a);
        }
        
        .form-control, .form-select {
            background-color: #3a3f51;
            border-color: #4a5169;
            color: #e0e0e0;
        }
        
        .session-slot {
            border-color: #4a5169;
            background-color: #2a2d3a;
        }
        
        .session-slot:hover {
            background-color: #3a3f51;
        }
        
        .session-slot.selected {
            background-color: rgba(78, 115, 223, 0.15);
        }
        
        .session-time {
            color: #e0e0e0;
        }
        
        .session-period {
            color: #aaa;
        }
        
        .selected-session-info {
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .text-muted {
            color: #b0b0b0 !important;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .session-title {
            font-size: 1.6rem;
        }
        
        .session-subtitle {
            font-size: 1rem;
        }
        
        .toast {
            min-width: 250px;
        }
    }
</style>
@endprepend

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const sessionDateInput = document.getElementById('sessionDate');
    const selectedDateDisplay = document.getElementById('selectedDateDisplay');
    const loadingState = document.getElementById('loadingState');
    const noSessionsState = document.getElementById('noSessionsState');
    const sessionsContainer = document.getElementById('sessionsContainer');
    const sessionSlots = document.getElementById('sessionSlots');
    const bookingConfirmation = document.getElementById('bookingConfirmation');
    const selectedSessionDetails = document.getElementById('selectedSessionDetails');
    const startingLocationInput = document.getElementById('startingLocation');
    const sessionNotesInput = document.getElementById('sessionNotes');
    const confirmBookingBtn = document.getElementById('confirmBookingBtn');
    const cancelSelectionBtn = document.getElementById('cancelSelectionBtn');
    const toastContainer = document.getElementById('toastContainer');
    const trainerId = "{{ $trainer_id ?? 219 }}";
    
    // Storage for bookings data that will be loaded from API
    let trainerSessionData = null;
    let bookings = [];
    
    // Set min date
    sessionDateInput.min = new Date().toISOString().split('T')[0];
    
    // Format date for display
    function formatDate(dateString) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('ar-SA', options);
    }
    
    // Format time for display
    function formatTime(timeString) {
        const time = timeString.split(':');
        let hours = parseInt(time[0]);
        const minutes = time[1];
        
        const period = hours >= 12 ? 'مساءً' : 'صباحاً';
        hours = hours % 12 || 12;
        
        return `${hours}:${minutes} ${period}`;
    }
    
    // Fetch available sessions from API
    function fetchAvailableSessions(date) {
        // Show loading state
        loadingState.classList.remove('d-none');
        sessionsContainer.classList.add('d-none');
        noSessionsState.classList.add('d-none');
        bookingConfirmation.classList.add('d-none');
        
        // Format date for API
        const formattedDate = date.split('T')[0];
        
        // Call API
        fetch(`/api/booking/${trainerId}/${formattedDate}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('API response:', data);
                
                // التحقق من هيكل البيانات
                if (!data.trainer_data || !data.bookings) {
                    console.error('هيكل البيانات غير صحيح:', data);
                    throw new Error('هيكل البيانات غير صحيح');
                }
                
                // التحقق من وجود الحقول المطلوبة
                const requiredFields = ['startHour', 'endHour', 'sessionTime', 'breakTime'];
                const missingFields = requiredFields.filter(field => data.trainer_data[field] === undefined);
                
                if (missingFields.length > 0) {
                    console.error('حقول مفقودة في بيانات المدرب:', missingFields);
                    // تعيين قيم افتراضية إذا كانت البيانات مفقودة
                    trainerSessionData = {
                        startHour: data.trainer_data.startHour || 8,
                        endHour: data.trainer_data.endHour || 18,
                        sessionTime: data.trainer_data.sessionTime || 45,
                        breakTime: data.trainer_data.breakTime || 15
                    };
                } else {
                    // Store trainer data as-is if all fields exist
                    trainerSessionData = data.trainer_data;
                }
                
                // التأكد من أن الحجوزات هي مصفوفة
                bookings = Array.isArray(data.bookings) ? data.bookings : [];
                
                console.log('Processed trainer data:', trainerSessionData);
                console.log('Processed bookings:', bookings);
                
                // Update sidebar info
                updateSidebarInfo(trainerSessionData);
                
                // Hide loading state
                loadingState.classList.add('d-none');
                
                // Get available sessions
                const availableSessions = getAvailableSessions(formattedDate);
                
                // Display sessions
                displaySessions(availableSessions);
            })
            .catch(error => {
                console.error('Error fetching available sessions:', error);
                
                // Hide loading state
                loadingState.classList.add('d-none');
                
                // Show error state
                noSessionsState.classList.remove('d-none');
                noSessionsState.querySelector('h5').textContent = 'حدث خطأ';
                noSessionsState.querySelector('p').textContent = 'لم نتمكن من جلب الجلسات المتاحة. يرجى التحقق من اتصالك بالإنترنت والمحاولة مرة أخرى.';
                
                // Show toast
                showToast(`حدث خطأ أثناء جلب الجلسات المتاحة: ${error.message}`, 'error');
                
                // محاولة استعادة البيانات الافتراضية
                trainerSessionData = {
                    startHour: 8,
                    endHour: 18,
                    sessionTime: 45,
                    breakTime: 15
                };
                
                // إظهار جلسات بناءً على القيم الافتراضية
                if (confirm('هل ترغب في عرض الجلسات المتاحة بناءً على الإعدادات الافتراضية؟')) {
                    const availableSessions = getAvailableSessions(formattedDate);
                    if (availableSessions.length > 0) {
                        displaySessions(availableSessions);
                    }
                }
            });
    }
    
    // Calculate available sessions
    function getAvailableSessions(date) {
        if (!trainerSessionData) return [];
        
        const { startHour, endHour, sessionTime, breakTime, availableDays } = trainerSessionData;
        
        // Convert string values to numbers if needed
        const startHourNum = parseInt(startHour);
        const endHourNum = parseInt(endHour);
        const sessionTimeNum = parseInt(sessionTime);
        const breakTimeNum = parseInt(breakTime);
        
        const availableSessions = [];
        const currentDate = new Date(date);
        
        // Check if selected date is in available days
        if (!isDateAvailable(date, availableDays)) {
            console.log(`Selected day is not in available days:`, availableDays);
            // Display appropriate message for unavailable days
            noSessionsState.classList.remove('d-none');
            sessionsContainer.classList.add('d-none');
            noSessionsState.querySelector('h5').textContent = 'لا يعمل المدرب في هذا اليوم';
            if (availableDays && availableDays.length > 0) {
                noSessionsState.querySelector('p').textContent = `الأيام المتاحة: ${formatAvailableDays(availableDays)}`;
            } else {
                noSessionsState.querySelector('p').textContent = 'يرجى اختيار تاريخ آخر';
            }
            return [];
        }
        
        // Generate all time slots for the day based on startHour, endHour, sessionTime and breakTime
        console.log(`Generating slots from ${startHourNum}:00 to ${endHourNum}:00`);
        
        // Handle case where endHour is less than startHour (e.g., 8:00 to 3:00 next day)
        let adjustedEndHour = endHourNum;
        if (endHourNum < startHourNum) {
            adjustedEndHour = endHourNum + 24;
        }
        
        // Set starting time
        let currentHour = startHourNum;
        let currentMinute = 0;
        
        // Generate all possible slots
        while ((currentHour < adjustedEndHour) || (currentHour === adjustedEndHour && currentMinute === 0)) {
            // Format the start time
            const formattedStartHour = (currentHour % 24).toString().padStart(2, '0');
            const formattedStartMinute = currentMinute.toString().padStart(2, '0');
            const startTimeString = `${formattedStartHour}:${formattedStartMinute}:00`;
            
            // Calculate end time
            let endHour = currentHour;
            let endMinute = currentMinute + sessionTimeNum;
            
            // Adjust if session ends in the next hour
            if (endMinute >= 60) {
                endHour += Math.floor(endMinute / 60);
                endMinute = endMinute % 60;
            }
            
            // Format the end time
            const formattedEndHour = (endHour % 24).toString().padStart(2, '0');
            const formattedEndMinute = endMinute.toString().padStart(2, '0');
            const endTimeString = `${formattedEndHour}:${formattedEndMinute}:00`;
            
            // Skip this slot if it extends beyond the end hour
            const slotEndHour = endHour % 24;
            const endTimeReached = 
                (endHourNum > startHourNum && slotEndHour > endHourNum) || 
                (endHourNum < startHourNum && slotEndHour > endHourNum && slotEndHour < startHourNum);
                
            if (endTimeReached) {
                console.log(`Skipping slot that extends beyond end time: ${startTimeString} - ${endTimeString}`);
                break;
            }
            
            console.log(`Generated slot: ${startTimeString} - ${endTimeString}`);
            
            // Check if this slot overlaps with any existing bookings
            const isBooked = bookings.some(booking => {
                try {
                    if (booking.date !== date) return false;
                    
                    // Parse booking times
                    const [bookStartHour, bookStartMinute] = booking.startTime.split(':').map(Number);
                    const [bookEndHour, bookEndMinute] = booking.endTime.split(':').map(Number);
                    
                    // Calculate break time end after the booking
                    let breakEndHour = bookEndHour;
                    let breakEndMinute = bookEndMinute + breakTimeNum;
                    
                    // Adjust if break ends in the next hour
                    if (breakEndMinute >= 60) {
                        breakEndHour += Math.floor(breakEndMinute / 60);
                        breakEndMinute = breakEndMinute % 60;
                    }
                    
                    // Parse slot times
                    const [slotStartHour, slotStartMinute] = startTimeString.split(':').map(Number);
                    const [slotEndHour, slotEndMinute] = endTimeString.split(':').map(Number);
                    
                    // Convert to minutes for easier comparison
                    const bookingStartMinutes = bookStartHour * 60 + bookStartMinute;
                    const bookingEndMinutes = bookEndHour * 60 + bookEndMinute;
                    const breakEndMinutes = breakEndHour * 60 + breakEndMinute;
                    const slotStartMinutes = slotStartHour * 60 + slotStartMinute;
                    const slotEndMinutes = slotEndHour * 60 + slotEndMinute;
                    
                    // Check for overlap with booking + break time
                    const hasOverlap = (
                        (slotStartMinutes < breakEndMinutes && slotEndMinutes > bookingStartMinutes)
                    );
                    
                    if (hasOverlap) {
                        const formattedBreakEnd = `${breakEndHour.toString().padStart(2, '0')}:${breakEndMinute.toString().padStart(2, '0')}:00`;
                        console.log(`Slot ${startTimeString}-${endTimeString} overlaps with booking ${booking.startTime}-${booking.endTime} including break time until ${formattedBreakEnd}`);
                    }
                    
                    return hasOverlap;
                } catch (error) {
                    console.error("Error checking booking overlap:", error, booking);
                    return false;
                }
            });
            
            // If not booked, add this slot to available sessions
            if (!isBooked) {
                availableSessions.push({
                    start: startTimeString,
                    end: endTimeString,
                    date: date
                });
            }
            
            // Move to the next time slot (session time + break time)
            currentMinute += sessionTimeNum + breakTimeNum;
            if (currentMinute >= 60) {
                currentHour += Math.floor(currentMinute / 60);
                currentMinute = currentMinute % 60;
            }
        }
        
        console.log(`Generated ${availableSessions.length} available slots`);
        return availableSessions;
    }
    
    // Display available sessions
    function displaySessions(availableSessions) {
        // Clear previous sessions
        sessionSlots.innerHTML = '';
        
        if (availableSessions.length === 0) {
            sessionsContainer.classList.add('d-none');
            noSessionsState.classList.remove('d-none');
            return;
        }
        
        noSessionsState.classList.add('d-none');
        sessionsContainer.classList.remove('d-none');
        
        // Create session slots
        availableSessions.forEach((session, index) => {
            const sessionStart = formatTime(session.start);
            const sessionEnd = formatTime(session.end);
            
            const slot = document.createElement('div');
            slot.className = 'col-md-6 col-lg-4';
            slot.innerHTML = `
                <div class="session-slot" data-index="${index}">
                    <div class="session-time">
                        ${sessionStart}
                        <span class="session-period">إلى ${sessionEnd}</span>
                    </div>
                    <div class="session-duration mt-2">
                        <i class="fas fa-clock text-primary me-1"></i>
                        <span>${trainerSessionData.sessionTime} دقيقة</span>
                    </div>
                </div>
            `;
            
            // Add slot to container
            sessionSlots.appendChild(slot);
            
            // Add click event to slot
            const slotElement = slot.querySelector('.session-slot');
            slotElement.addEventListener('click', () => selectSession(session, slotElement, index));
        });
    }
    
    // Select a session for booking
    function selectSession(session, slotElement, index) {
        // Remove selection from all slots
        document.querySelectorAll('.session-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Add selection to clicked slot
        slotElement.classList.add('selected');
        
        // Show booking confirmation
        bookingConfirmation.classList.remove('d-none');
        
        // Display selected session details
        const sessionDay = formatDate(session.date);
        const sessionStart = formatTime(session.start);
        const sessionEnd = formatTime(session.end);
        
        selectedSessionDetails.innerHTML = `
            <div class="mb-2"><i class="fas fa-calendar-day me-2 text-primary"></i> <strong>التاريخ:</strong> ${sessionDay}</div>
            <div class="mb-2"><i class="fas fa-clock me-2 text-primary"></i> <strong>الوقت:</strong> ${sessionStart} إلى ${sessionEnd}</div>
            <div><i class="fas fa-user me-2 text-primary"></i> <strong>رقم المدرب:</strong> ${trainerId}</div>
        `;
        
        // Scroll to booking confirmation
        bookingConfirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Store selected session data
        bookingConfirmation.dataset.session = JSON.stringify({
            date: session.date,
            time: session.start,
            end_time: session.end,
            trainer_id: trainerId
        });
    }
    
    // Toast notification function
    function showToast(message, type) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        // Create content
        const content = document.createElement('div');
        content.className = 'toast-content';
        
        // Create icon
        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        icon.innerHTML = type === 'success' 
            ? '<i class="fas fa-check-circle"></i>' 
            : '<i class="fas fa-exclamation-circle"></i>';
        
        // Create message
        const text = document.createElement('div');
        text.textContent = message;
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'toast-close';
        closeBtn.innerHTML = '&times;';
        closeBtn.onclick = function() {
            removeToast(toast);
        };
        
        // Assemble toast
        content.appendChild(icon);
        content.appendChild(text);
        toast.appendChild(content);
        toast.appendChild(closeBtn);
        
        // Add to container
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            removeToast(toast);
        }, 5000);
    }
    
    // Remove toast with animation
    function removeToast(toast) {
        toast.style.animation = 'fade-out 0.3s forwards';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
    
    // Event listener for date change
    sessionDateInput.addEventListener('change', function() {
        const selectedDate = this.value;
        
        if (!selectedDate) return;
        
        // Display selected date
        selectedDateDisplay.textContent = formatDate(selectedDate);
        
        // Fetch available sessions
        fetchAvailableSessions(selectedDate);
    });
    
    // Event listener for booking confirmation
    confirmBookingBtn.addEventListener('click', function() {
        // Get selected session
        const sessionData = JSON.parse(bookingConfirmation.dataset.session);
        
        // Get location and notes
        const startingLocation = startingLocationInput.value.trim();
        const notes = sessionNotesInput.value.trim();
        
        // Validate location
        if (!startingLocation) {
            showToast('يرجى إدخال موقع بدء الجلسة', 'error');
            startingLocationInput.focus();
            return;
        }
        
        // Prepare booking data
        const bookingData = {
            ...sessionData,
            starting_location: startingLocation,
            notes: notes,
            day: new Date(sessionData.date).toLocaleDateString('ar-SA', { weekday: 'long' })
        };
        
        // Get token
        const token = localStorage.getItem('token');
        
        if (!token) {
            showToast('يرجى تسجيل الدخول أولاً', 'error');
            return;
        }
        
        // Show loading state
        confirmBookingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جارِ الحجز...';
        confirmBookingBtn.disabled = true;
        
        // Log booking data
        console.log('Booking data:', bookingData);
        
        // Make real API call to book the session
        fetch('/api/booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(bookingData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Reset button
            confirmBookingBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>تأكيد الحجز';
            confirmBookingBtn.disabled = false;
            
            // Show success message
            showToast('تم حجز الجلسة بنجاح!', 'success');
            
            // Reset form
            startingLocationInput.value = '';
            sessionNotesInput.value = '';
            bookingConfirmation.classList.add('d-none');
            
            // Deselect all slots
            document.querySelectorAll('.session-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            
            // Refresh available sessions to reflect new booking
            const selectedDate = sessionDateInput.value;
            fetchAvailableSessions(selectedDate);
        })
        .catch(error => {
            console.error('Error booking session:', error);
            
            // Reset button
            confirmBookingBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>تأكيد الحجز';
            confirmBookingBtn.disabled = false;
            
            // Show error
            showToast('حدث خطأ أثناء حجز الجلسة', 'error');
        });
    });
    
    // Event listener for cancel button
    cancelSelectionBtn.addEventListener('click', function() {
        // Hide booking confirmation
        bookingConfirmation.classList.add('d-none');
        
        // Deselect all slots
        document.querySelectorAll('.session-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Reset form
        startingLocationInput.value = '';
        sessionNotesInput.value = '';
    });
    
    // Set default date to today and trigger change event
    const today = new Date().toISOString().split('T')[0];
    sessionDateInput.value = today;
    
    // Add click event to quick date buttons
    document.querySelectorAll('.quick-date').forEach(button => {
        button.addEventListener('click', function() {
            const daysToAdd = parseInt(this.dataset.days);
            const date = new Date();
            date.setDate(date.getDate() + daysToAdd);
            
            // Format date as YYYY-MM-DD
            const formattedDate = date.toISOString().split('T')[0];
            sessionDateInput.value = formattedDate;
            
            // Trigger change event
            const changeEvent = new Event('change');
            sessionDateInput.dispatchEvent(changeEvent);
        });
    });
    
    // Trigger change event to load today's sessions
    const changeEvent = new Event('change');
    sessionDateInput.dispatchEvent(changeEvent);

    // Check if selected date is in available days
    function isDateAvailable(date, availableDays) {
        if (!availableDays || !Array.isArray(availableDays) || availableDays.length === 0) {
            return true; // If no available days specified, all days are available
        }
        
        const weekday = new Date(date).toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
        console.log(`Checking if ${weekday} is in`, availableDays.map(d => d.toLowerCase()));
        return availableDays.map(d => d.toLowerCase()).includes(weekday);
    }
    
    // Format weekday names in Arabic
    function formatAvailableDays(days) {
        if (!days || !Array.isArray(days)) return '';
        
        const dayTranslations = {
            'sunday': 'الأحد',
            'monday': 'الإثنين',
            'tuesday': 'الثلاثاء',
            'wednesday': 'الأربعاء',
            'thursday': 'الخميس',
            'friday': 'الجمعة',
            'saturday': 'السبت'
        };
        
        return days.map(day => dayTranslations[day.toLowerCase()] || day)
            .join('، ');
    }
    
    // Format time for sidebar display
    function formatHourDisplay(hour) {
        if (hour === 0) return '12 صباحاً';
        if (hour === 12) return '12 ظهراً';
        
        if (hour < 12) return `${hour} صباحاً`;
        return `${hour - 12} مساءً`;
    }
    
    // Update sidebar info with trainer data
    function updateSidebarInfo(trainerData) {
        // Update session time
        document.getElementById('sessionTimeDisplay').textContent = trainerData.sessionTime || 45;
        
        // Update break time
        document.getElementById('breakTimeDisplay').textContent = trainerData.breakTime || 15;
        
        // Update work hours
        const startHourDisplay = formatHourDisplay(trainerData.startHour || 8);
        const endHourDisplay = formatHourDisplay(trainerData.endHour || 18);
        document.getElementById('workHoursDisplay').textContent = `${startHourDisplay} - ${endHourDisplay}`;
        
        // Update available days
        if (trainerData.availableDays && Array.isArray(trainerData.availableDays) && trainerData.availableDays.length > 0) {
            document.getElementById('availableDaysContainer').style.display = 'flex';
            document.getElementById('availableDaysDisplay').textContent = formatAvailableDays(trainerData.availableDays);
        } else {
            document.getElementById('availableDaysContainer').style.display = 'none';
        }
    }
});
</script>

@endsection 