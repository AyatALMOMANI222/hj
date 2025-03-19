@extends('app')

@section('title', 'الرئيسية')

@push('head')
<style>
    /* Custom Styles for Home Page */
    :root {
        --primary-gradient: linear-gradient(45deg, #2575fc, #6a11cb);
        --secondary-gradient: linear-gradient(45deg, #6a11cb, #2575fc);
        --success-gradient: linear-gradient(45deg, #28a745, #20c997);
        --hero-gradient: linear-gradient(135deg, #1e3c72, #2a5298, #6a11cb);
    }

    /* Hide elements on login and register pages */
    body[data-page="login"] .notification-icon,
    body[data-page="login"] .drawer-toggle,
    body[data-page="register"] .notification-icon,
    body[data-page="register"] .drawer-toggle {
        display: none !important;
    }

    /* General Styles */
    html, body {
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
    }

    .container {
        width: 100%;
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
    }

    .section {
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
    }

    .section-title {
        margin-bottom: 3rem;
        position: relative;
        font-weight: 700;
    }

    .section-title:after {
        content: "";
        display: block;
        width: 80px;
        height: 4px;
        background: var(--primary-gradient);
        margin: 0.8rem auto 0;
        border-radius: 2px;
    }

    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Hero Section */
    .hero {
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        display: flex;
        align-items: center;
        background: var(--hero-gradient);
        position: relative;
        color: white;
        text-align: right;
    }

    .hero:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255, 255, 255, 0.05)" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,138.7C672,139,768,181,864,197.3C960,213,1056,203,1152,176C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom center;
        background-size: 100% auto;
        opacity: 0.6;
        z-index: 1;
    }

    .hero-content {
        width: 100%;
        max-width: 100%;
        position: relative;
        z-index: 2;
        padding: 3rem 0;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        opacity: 0.9;
        text-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    /* Animated shapes for visual interest */
    .shape {
        position: absolute;
        opacity: 0.06;
        z-index: 0;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: #fff;
        top: -150px;
        right: -150px;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: #fff;
        bottom: -100px;
        left: -100px;
    }

    /* Animated floating circles */
    .floating-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
        animation: float 6s ease-in-out infinite;
    }

    .floating-circle-1 {
        width: 120px;
        height: 120px;
        top: 15%;
        right: 10%;
        animation-delay: 0s;
    }

    .floating-circle-2 {
        width: 80px;
        height: 80px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-circle-3 {
        width: 160px;
        height: 160px;
        top: 30%;
        left: 10%;
        animation-delay: 1s;
    }

    .floating-circle-4 {
        width: 100px;
        height: 100px;
        bottom: 15%;
        left: 20%;
        animation-delay: 3s;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    /* Feature Cards */
    .feature-card {
        border-radius: 15px;
        padding: 2.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.08);
        background: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        text-align: center;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    .feature-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 20px;
        margin-bottom: 1.5rem;
        background: var(--primary-gradient);
        color: white;
        font-size: 2rem;
    }

    .feature-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    /* Stats Section */
    .stats-section {
        width: 100%;
        max-width: 100%;
        background: var(--primary-gradient);
        color: white;
        padding: 4rem 0;
    }

    .stat-item {
        text-align: center;
        padding: 1.5rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Testimonial Slider */
    .testimonial-section {
        background-color: #f8f9fa;
        position: relative;
    }

    .testimonial-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        margin: 1rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .testimonial-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-quote {
        font-size: 1.1rem;
        font-style: italic;
        margin-bottom: 1.5rem;
        color: #555;
        line-height: 1.6;
    }

    .testimonial-author {
        font-weight: 700;
        color: #333;
    }

    .testimonial-role {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* CTA Section */
    .cta-section {
        background: var(--secondary-gradient);
        color: white;
        text-align: center;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
    }

    .cta-subtitle {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .btn-cta {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 50px;
        transition: all 0.3s ease;
        border: 2px solid white;
        background-color: transparent;
        color: white;
    }

    .btn-cta:hover {
        background-color: white;
        color: #6a11cb;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* Trainers Section */
    .trainer-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .trainer-card:hover {
        transform: translateY(-10px);
    }

    .trainer-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .trainer-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        transition: all 0.3s ease;
    }

    .trainer-card:hover .trainer-info {
        padding-bottom: 2rem;
    }

    .trainer-name {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .trainer-specialty {
        font-size: 1rem;
        opacity: 0.9;
    }

    .trainer-rating {
        color: #ffc107;
        margin-top: 0.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.8rem;
        }
        .feature-card {
            padding: 2rem;
        }
        .trainer-card {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 4rem 0;
        }
        .hero-title {
            font-size: 2.2rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
        }
        .cta-title {
            font-size: 2rem;
        }
        .feature-card {
            padding: 1.8rem;
        }
        .stat-number {
            font-size: 2.5rem;
        }
        .stat-label {
            font-size: 1rem;
        }
        .testimonial-card {
            margin: 0.5rem;
        }
        .d-flex.justify-content-center.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }
        .btn-lg {
            width: 100%;
            margin: 0.5rem 0;
        }
    }

    @media (max-width: 576px) {
        .section {
            padding: 3rem 0;
        }
        .hero {
            min-height: 80vh;
        }
        .hero-title {
            font-size: 1.8rem;
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .hero-content {
            padding: 2rem 0;
        }
        .section-title {
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }
        .feature-card {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .feature-title {
            font-size: 1.2rem;
        }
        .testimonial-card {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        .testimonial-quote {
            font-size: 1rem;
        }
        .stat-item {
            padding: 1rem;
        }
        .stat-number {
            font-size: 2rem;
        }
        .stat-label {
            font-size: 0.9rem;
        }
        .trainer-card {
            margin-bottom: 15px;
        }
        .trainer-image {
            height: 250px;
        }
        .trainer-info {
            padding: 1rem;
        }
        .trainer-name {
            font-size: 1.2rem;
        }
        .trainer-specialty {
            font-size: 0.9rem;
        }
        .cta-section {
            padding: 3rem 0;
        }
        .cta-title {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        .cta-subtitle {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .btn-cta {
            padding: 0.6rem 1.5rem;
            font-size: 1rem;
            width: 100%;
        }
        .floating-circle {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 1.5rem;
        }
        .hero-subtitle {
            font-size: 0.9rem;
        }
        .section-title {
            font-size: 1.5rem;
        }
        .feature-card {
            padding: 1.2rem;
        }
        .stat-number {
            font-size: 1.8rem;
        }
        .stat-label {
            font-size: 0.8rem;
        }
        .testimonial-card {
            padding: 1.2rem;
        }
        .testimonial-quote {
            font-size: 0.9rem;
        }
        .trainer-image {
            height: 200px;
        }
        .trainer-info {
            padding: 0.8rem;
        }
        .cta-title {
            font-size: 1.4rem;
        }
        .cta-subtitle {
            font-size: 0.9rem;
        }
        .btn {
            font-size: 0.9rem;
            padding: 0.5rem 1.2rem;
        }
    }

    @media (max-width: 360px) {
        .hero-title {
            font-size: 1.3rem;
        }
        .section-title {
            font-size: 1.3rem;
        }
        .feature-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
        .feature-title {
            font-size: 1.1rem;
        }
        .stat-number {
            font-size: 1.5rem;
        }
        .trainer-image {
            height: 180px;
        }
        .trainer-name {
            font-size: 1.1rem;
        }
    }

    /* Animation Classes */
    .fade-in-up {
        animation: fadeInUp 1s ease both;
    }

    .fade-in {
        animation: fadeIn 1s ease both;
    }

    .fade-in-right {
        animation: fadeInRight 1s ease both;
    }

    .fade-in-left {
        animation: fadeInLeft 1s ease both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 30px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translate3d(30px, 0, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translate3d(-30px, 0, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    /* Footer Styles */
    .footer {
        width: 100%;
        max-width: 100%;
        position: relative;
        overflow: hidden;
        color: #fff;
    }

    .footer-top {
        width: 100%;
        max-width: 100%;
        background: #222;
        padding: 5rem 0 4rem;
        position: relative;
    }

    .footer-top:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--primary-gradient);
    }

    .footer-widget {
        margin-bottom: 1.5rem;
    }

    .footer-title {
        position: relative;
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
    }

    .footer-title:after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50px;
        height: 2px;
        background: var(--primary-gradient);
    }

    .footer-desc {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 1.5rem;
        line-height: 1.7;
    }

    .social-links {
        display: flex;
        gap: 10px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--primary-gradient);
        color: #fff;
        transform: translateY(-3px);
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        padding-right: 15px;
        display: inline-block;
    }

    .footer-links a:before {
        content: "\f105";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        right: 0;
        top: 2px;
        color: #2575fc;
    }

    .footer-links a:hover {
        color: #fff;
        padding-right: 20px;
    }

    .contact-item {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-start;
    }

    .contact-item i {
        color: #2575fc;
        margin-left: 12px;
        margin-top: 5px;
    }

    .contact-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    .footer-bottom {
        width: 100%;
        max-width: 100%;
        background: #1a1a1a;
        padding: 1.5rem 0;
        font-size: 0.9rem;
    }

    .copyright {
        margin: 0;
        color: rgba(255, 255, 255, 0.7);
    }

    .footer-bottom-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .footer-bottom-links li {
        margin-right: 1.5rem;
    }

    .footer-bottom-links li:last-child {
        margin-right: 0;
    }

    .footer-bottom-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-bottom-links a:hover {
        color: #fff;
    }

    @media (max-width: 767px) {
        .footer-top {
            padding: 4rem 0 2rem;
        }
        
        .footer-title {
            margin-bottom: 1rem;
        }
        
        .footer-bottom-links {
            justify-content: center;
            margin-top: 1rem;
        }
        
        .footer-bottom-links li {
            margin: 0 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="floating-circle floating-circle-1"></div>
    <div class="floating-circle floating-circle-2"></div>
    <div class="floating-circle floating-circle-3"></div>
    <div class="floating-circle floating-circle-4"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto text-center">
                <h1 class="hero-title fade-in-up">ابدأ رحلتك التدريبية مع أفضل المدربين</h1>
                <p class="hero-subtitle fade-in-up">منصة متكاملة لتدريب القيادة بأعلى معايير الجودة والاحترافية</p>
                <div class="d-flex justify-content-center gap-3 fade-in">
                    <a href="/trainers" class="btn btn-lg btn-primary px-4 rounded-pill">ابحث عن مدرب</a>
                    <a href="/register" class="btn btn-lg btn-outline-light px-4 rounded-pill">تسجيل جديد</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title text-center">لماذا تختارنا؟</h2>
        <div class="row">
            <!-- Feature 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="feature-title">مدربون محترفون</h3>
                    <p>نخبة من المدربين المعتمدين بخبرات عالية وسجل حافل من النجاحات</p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="feature-title">جدولة مرنة</h3>
                    <p>احجز جلساتك التدريبية في الأوقات التي تناسبك وفق جدول زمني مرن</p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-road"></i>
                    </div>
                    <h3 class="feature-title">تدريب عملي</h3>
                    <p>تدريب عملي مكثف على الطرق الحقيقية وفي ظروف قيادة متنوعة</p>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">السلامة أولاً</h3>
                    <p>أعلى معايير السلامة وتدريب خاص على القيادة الآمنة وتجنب المخاطر</p>
                </div>
            </div>
            
            <!-- Feature 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="feature-title">شهادات معتمدة</h3>
                    <p>الحصول على شهادات معتمدة بعد إتمام التدريب بنجاح</p>
                </div>
            </div>
            
            <!-- Feature 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="feature-title">دعم مستمر</h3>
                    <p>فريق دعم متكامل جاهز للإجابة على استفساراتك على مدار الساعة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number">+<span class="counter">5000</span></div>
                    <div class="stat-label">متدرب ناجح</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number">+<span class="counter">50</span></div>
                    <div class="stat-label">مدرب محترف</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number">+<span class="counter">15000</span></div>
                    <div class="stat-label">ساعة تدريب</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number"><span class="counter">97</span>%</div>
                    <div class="stat-label">نسبة النجاح</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Trainers Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title text-center">نخبة من المدربين</h2>
        <div class="row">
            <!-- Trainer 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="trainer-card">
                    <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5" alt="مدرب القيادة" class="trainer-image">
                    <div class="trainer-info">
                        <h3 class="trainer-name">أحمد محمد</h3>
                        <p class="trainer-specialty">خبرة 15 عام في تدريب القيادة</p>
                        <div class="trainer-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(4.8)</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Trainer 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="trainer-card">
                    <img src="https://images.unsplash.com/photo-1564564321837-a57b7070ac4f" alt="مدرب القيادة" class="trainer-image">
                    <div class="trainer-info">
                        <h3 class="trainer-name">خالد عبدالله</h3>
                        <p class="trainer-specialty">متخصص في تعليم المبتدئين</p>
                        <div class="trainer-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(5.0)</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Trainer 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="trainer-card">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" alt="مدرب القيادة" class="trainer-image">
                    <div class="trainer-info">
                        <h3 class="trainer-name">محمد حسين</h3>
                        <p class="trainer-specialty">خبير قيادة متقدمة وسباقات</p>
                        <div class="trainer-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(4.0)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="/trainers" class="btn btn-outline-primary btn-lg rounded-pill px-4">عرض جميع المدربين</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonial-section">
    <div class="container">
        <h2 class="section-title text-center">آراء المتدربين</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2" alt="صورة المتدرب">
                    </div>
                    <p class="testimonial-quote">
                        "تجربة رائعة جداً! المدربون محترفون والنظام سهل الاستخدام. نجحت في اختبار القيادة من المرة الأولى."
                    </p>
                    <h4 class="testimonial-author">سارة أحمد</h4>
                    <p class="testimonial-role">متدربة</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://images.unsplash.com/photo-1599566150163-29194dcaad36" alt="صورة المتدرب">
                    </div>
                    <p class="testimonial-quote">
                        "البرنامج التدريبي منظم ومتكامل، والمدربين صبورين جداً مع المبتدئين. أنصح به بشدة."
                    </p>
                    <h4 class="testimonial-author">محمد العلي</h4>
                    <p class="testimonial-role">متدرب</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-avatar">
                        <img src="https://images.unsplash.com/photo-1567532939604-b6b5b0db2604" alt="صورة المتدرب">
                    </div>
                    <p class="testimonial-quote">
                        "تعلمت أكثر مما توقعت، ليس فقط في القيادة ولكن في السلامة على الطريق أيضاً. تجربة استثنائية!"
                    </p>
                    <h4 class="testimonial-author">نورة سعد</h4>
                    <p class="testimonial-role">متدربة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section cta-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto text-center">
                <h2 class="cta-title">مستعد لبدء رحلتك نحو القيادة الآمنة؟</h2>
                <p class="cta-subtitle">سجل الآن واحصل على جلسة تدريبية مجانية</p>
                <a href="/register" class="btn btn-cta">سجل الآن</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-title">منصة تدريب القيادة</h4>
                        <p class="footer-desc">منصة متخصصة في تقديم خدمات تدريب القيادة بأعلى معايير الجودة والاحترافية، نجمع بين أفضل المدربين وأحدث الأساليب لتأهيل السائقين الجدد.</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-title">روابط سريعة</h4>
                        <ul class="footer-links">
                            <li><a href="/">الرئيسية</a></li>
                            <li><a href="/trainers">المدربون</a></li>
                            <li><a href="/about">عن المنصة</a></li>
                            <li><a href="/contact">اتصل بنا</a></li>
                            <li><a href="/faq">الأسئلة الشائعة</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6 mb-5 mb-lg-0">
                    <div class="footer-widget">
                        <h4 class="footer-title">خدماتنا</h4>
                        <ul class="footer-links">
                            <li><a href="#">تدريب المبتدئين</a></li>
                            <li><a href="#">تدريب متقدم</a></li>
                            <li><a href="#">اختبارات القيادة</a></li>
                            <li><a href="#">القيادة الآمنة</a></li>
                            <li><a href="#">استشارات القيادة</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <h4 class="footer-title">تواصل معنا</h4>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-building"></i>
                                <p>شركة الحاج للتدريب</p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>المملكة الأردنية الهاشمية، عمان</p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <p>+962787005454</p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <p>info@alhaj-training.com</p>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <p>السبت - الخميس: 9 صباحاً - 6 مساءً</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright">جميع الحقوق محفوظة &copy; {{ date('Y') }} منصة تدريب القيادة</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="footer-bottom-links">
                        <li><a href="#">سياسة الخصوصية</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

@endsection

@push('head')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counter
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.getAttribute('data-target');
                const data = +counter.innerText;
                
                const time = value / speed;
                
                if (data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setTimeout(animate, 20);
                } else {
                    counter.innerText = value;
                }
            }
            
            // Set data-target attribute and start at 0
            counter.setAttribute('data-target', counter.innerText);
            counter.innerText = '0';
            
            // Start animation when element comes into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animate();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            observer.observe(counter);
        });
        
        // Animate elements when they come into view
        const fadeElements = document.querySelectorAll('.fade-in, .fade-in-up, .fade-in-left, .fade-in-right');
        
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add animation delay based on index for staggered effect
                    const index = Array.from(fadeElements).indexOf(entry.target);
                    entry.target.style.animationDelay = `${index * 0.1}s`;
                    entry.target.style.visibility = 'visible';
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        fadeElements.forEach(el => {
            el.style.visibility = 'hidden';
            fadeObserver.observe(el);
        });
    });
</script>
@endpush
