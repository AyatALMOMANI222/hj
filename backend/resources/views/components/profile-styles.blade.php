<style>
    /* Container Height */
    .container-fluid {
        min-height: 100vh;
        height: 100vh;
        padding-bottom: 2rem;
        overflow-y: auto;
        overflow-x: hidden;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        margin: 0;
        width: 100%;
    }

    .row {
        margin: 0;
        padding: 20px;
        width: 100%;
    }

    body {
        overflow: hidden;
    }

    /* Profile Image Styles */
    .profile-image-container {
        width: 150px;
        height: 150px;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Card Styles */
    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Info Card Styles */
    .info-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-card:hover {
        background-color: #f8f9fa !important;
        border-color: rgba(0, 0, 0, 0.1);
    }

    /* Badge Styles */
    .badge {
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Contact Item Styles */
    .contact-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .contact-item:hover {
        background-color: #f8f9fa;
    }

    .contact-item i {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .profile-image-container {
            width: 120px;
            height: 120px;
        }

        .badge {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
    }

    /* Loading Animation */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    [id^="user"]:empty::before,
    [id^="center"]:empty::before {
        content: "Loading...";
        display: inline-block;
        color: #ccc;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
        border-radius: 4px;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style> 