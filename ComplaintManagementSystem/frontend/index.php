<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Complaint Management System - AI-Powered Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-color: #667eea;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
            animation: float 20s linear infinite;
        }

        @keyframes float {
            from { background-position: 0 0; }
            to { background-position: 100px 100px; }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 35px;
        }

        .cta-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 80px 0;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .btn-primary-custom {
            background: white;
            color: var(--secondary-color);
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
        }

        .btn-outline-custom:hover {
            background: white;
            color: var(--secondary-color);
        }

        .stats-section {
            padding: 60px 0;
            background: white;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px 0;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .feature-list li i {
            color: var(--secondary-color);
            margin-right: 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(102, 126, 234, 0.95); position: fixed; width: 100%; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-headset me-2" style="font-size: 28px;"></i>
                <span class="fw-bold">SmartComplaint</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-light btn-sm rounded-pill px-4" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Smart Complaint Management System</h1>
                    <p class="lead mb-4">Revolutionize your customer service with AI-powered complaint prioritization. Automatically classify complaints by urgency and ensure critical issues are handled first.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="register.php" class="btn btn-primary-custom btn-hero">
                            <i class="bi bi-person-plus me-2"></i>Get Started Free
                        </a>
                        <a href="login.php" class="btn btn-outline-custom btn-hero">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <i class="bi bi-robot" style="font-size: 250px; opacity: 0.9;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 stat-item">
                    <div class="stat-number">95%</div>
                    <h5>Accuracy</h5>
                    <p class="text-muted">AI-powered classification accuracy</p>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">60%</div>
                    <h5>Faster Response</h5>
                    <p class="text-muted">Average response time improvement</p>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">24/7</div>
                    <h5>Availability</h5>
                    <p class="text-muted">Always-on complaint processing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold mb-3">Powerful Features</h2>
                <p class="lead text-muted">Everything you need to manage complaints efficiently</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            <h4 class="mb-3">AI-Powered Classification</h4>
                            <p class="text-muted">Advanced machine learning algorithms automatically classify complaints as Critical, High, Medium, or Low priority.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <h4 class="mb-3">Real-Time Dashboard</h4>
                            <p class="text-muted">Track all complaints in real-time with intuitive dashboards showing priority levels and status updates.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="mb-3">Secure & Reliable</h4>
                            <p class="text-muted">Enterprise-grade security with role-based access control and encrypted data storage.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h4 class="mb-3">Analytics & Insights</h4>
                            <p class="text-muted">Comprehensive analytics to track complaint trends and improve service quality.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-bell-fill"></i>
                            </div>
                            <h4 class="mb-3">Smart Notifications</h4>
                            <p class="text-muted">Instant alerts for critical complaints ensuring immediate attention to urgent issues.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4 class="mb-3">Multi-User Support</h4>
                            <p class="text-muted">Separate interfaces for customers and administrators with role-based permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold mb-3">How It Works</h2>
                <p class="lead text-muted">Simple, fast, and efficient complaint management</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <ul class="feature-list">
                                <li>
                                    <i class="bi bi-1-circle-fill"></i>
                                    <div>
                                        <strong>Submit Complaint:</strong> Customers submit complaints through an easy-to-use interface
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-2-circle-fill"></i>
                                    <div>
                                        <strong>AI Analysis:</strong> Machine learning model analyzes the complaint content and context
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-3-circle-fill"></i>
                                    <div>
                                        <strong>Auto-Classification:</strong> System automatically assigns priority level (Critical, High, Medium, Low)
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-4-circle-fill"></i>
                                    <div>
                                        <strong>Smart Routing:</strong> Complaints are routed to appropriate teams based on priority
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-5-circle-fill"></i>
                                    <div>
                                        <strong>Track & Resolve:</strong> Real-time tracking until resolution with status updates
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-diagram-3-fill" style="font-size: 300px; background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="display-4 fw-bold mb-4">About the System</h2>
                    <p class="lead mb-4">The Smart Complaint Management System is an innovative solution that combines traditional complaint handling with cutting-edge artificial intelligence.</p>
                    <p class="mb-3">Built using advanced machine learning algorithms, our system can understand the context and urgency of complaints, ensuring that critical issues receive immediate attention while efficiently managing routine requests.</p>
                    <p class="mb-4">Whether you're a small business or a large enterprise, our system scales to meet your needs, improving customer satisfaction and operational efficiency.</p>
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <div class="badge bg-primary p-3 mb-2" style="font-size: 20px;">
                                <i class="bi bi-cpu-fill"></i>
                            </div>
                            <div><small>Machine Learning</small></div>
                        </div>
                        <div class="text-center">
                            <div class="badge bg-success p-3 mb-2" style="font-size: 20px;">
                                <i class="bi bi-code-square"></i>
                            </div>
                            <div><small>Modern Tech Stack</small></div>
                        </div>
                        <div class="text-center">
                            <div class="badge bg-info p-3 mb-2" style="font-size: 20px;">
                                <i class="bi bi-cloud-check-fill"></i>
                            </div>
                            <div><small>Cloud Ready</small></div>
                        </div>
                        <div class="text-center">
                            <div class="badge bg-warning p-3 mb-2" style="font-size: 20px;">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <div><small>Secure</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="display-4 fw-bold mb-4">Ready to Get Started?</h2>
            <p class="lead mb-5">Join hundreds of organizations improving their customer service with AI</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="register.php" class="btn btn-lg btn-primary px-5 py-3 rounded-pill">
                    <i class="bi bi-person-plus me-2"></i>Create Free Account
                </a>
                <a href="login.php" class="btn btn-lg btn-outline-primary px-5 py-3 rounded-pill">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="bi bi-headset me-2"></i>Smart Complaint Management System
                    </h5>
                    <p class="text-white-50">AI-powered complaint prioritization for better customer service.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white-50 text-decoration-none">Features</a></li>
                        <li><a href="#how-it-works" class="text-white-50 text-decoration-none">How It Works</a></li>
                        <li><a href="#about" class="text-white-50 text-decoration-none">About</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Account</h6>
                    <ul class="list-unstyled">
                        <li><a href="register.php" class="text-white-50 text-decoration-none">Register</a></li>
                        <li><a href="login.php" class="text-white-50 text-decoration-none">Login</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-white opacity-25">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2026 Smart Complaint Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const navHeight = document.querySelector('.navbar').offsetHeight;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(102, 126, 234, 1)';
            } else {
                navbar.style.background = 'rgba(102, 126, 234, 0.95)';
            }
        });
    </script>
</body>
</html>
