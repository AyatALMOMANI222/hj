<style>
.notification-page-container {
    background-color: #f8f9fa;
    min-height: calc(100vh - 60px);
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #2575fc, #6a11cb);
}

/* Notification Cards */
.notification-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    margin-bottom: 1rem;
    overflow: hidden;
    transition: all 0.25s ease;
}

.notification-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

.notification-card.unread {
    border-right: 4px solid #2575fc;
    background-color: rgba(37, 117, 252, 0.03);
}

.notification-card .card-body {
    padding: 1.25rem;
    position: relative;
}

.notification-card .card-footer {
    background-color: #f8f9fa;
    padding: 0.75rem 1.25rem;
    font-size: 0.85rem;
    color: #6c757d;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 1rem;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2575fc;
    font-size: 1.05rem;
}

.notification-text {
    font-size: 0.95rem;
    color: #495057;
    margin-bottom: 0.5rem;
}

.notification-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    color: #6c757d;
    font-size: 0.85rem;
}

.notification-action-btn {
    padding: 0.25rem 0.75rem;
    font-size: 0.85rem;
    border-radius: 20px;
}

.notification-badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #2575fc;
    border: 2px solid white;
}

/* Sidebar Filters */
.filter-options .form-check-label {
    cursor: pointer;
    padding: 0.25rem 0;
    width: 100%;
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    background-color: #f0f2f5 !important;
}

.loading-animation {
    display: inline-flex;
    align-items: center;
}

.spinner-grow {
    width: 1rem;
    height: 1rem;
    margin: 0 0.1rem;
}

/* Animation Effects */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.notification-card {
    animation: fadeIn 0.3s ease-out;
    animation-fill-mode: both;
}

/* Add delay to each card for sequential animation */
.notification-card:nth-child(1) { animation-delay: 0.05s; }
.notification-card:nth-child(2) { animation-delay: 0.1s; }
.notification-card:nth-child(3) { animation-delay: 0.15s; }
.notification-card:nth-child(4) { animation-delay: 0.2s; }
.notification-card:nth-child(5) { animation-delay: 0.25s; }
.notification-card:nth-child(6) { animation-delay: 0.3s; }
.notification-card:nth-child(7) { animation-delay: 0.35s; }
.notification-card:nth-child(8) { animation-delay: 0.4s; }
.notification-card:nth-child(9) { animation-delay: 0.45s; }
.notification-card:nth-child(10) { animation-delay: 0.5s; }

/* Empty/Error States */
.empty-state-icon, .error-state-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 1.5rem;
}

/* Priority Indicators */
.priority-indicator {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-left: 5px;
}
.priority-high { background-color: #dc3545; }
.priority-medium { background-color: #ffc107; }
.priority-low { background-color: #28a745; }

/* Responsive Adjustments */
@media (max-width: 768px) {
    .notification-icon {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
        margin-left: 0.75rem;
    }
    
    .notification-title {
        font-size: 1rem;
    }
    
    .notification-text {
        font-size: 0.9rem;
    }
    
    .notification-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .notification-card .card-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .notification-card .card-footer .btn-group {
        width: 100%;
    }
}
</style> 