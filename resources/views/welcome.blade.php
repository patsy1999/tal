<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Tal System Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4f0fb 100%);
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .hero {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            margin-top: 3rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="25" cy="25" r="3" fill="%23e0e7ff"/><circle cx="75" cy="25" r="3" fill="%23e0e7ff"/><circle cx="50" cy="50" r="3" fill="%23e0e7ff"/><circle cx="25" cy="75" r="3" fill="%23e0e7ff"/><circle cx="75" cy="75" r="3" fill="%23e0e7ff"/></svg>');
            background-size: 100px;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 4rem;
            text-align: center;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .logo {
            height: 120px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
            line-height: 1.2;
        }

        .tagline {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--gray);
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.5;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .feature {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            text-align: center;
        }

        .feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.1);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .feature p {
            color: var(--gray);
            line-height: 1.6;
            margin: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
            min-width: 180px;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(to right, rgba(79, 70, 229, 0.1), rgba(245, 158, 11, 0.1));
            filter: blur(60px);
            z-index: 0;
        }

        .decoration-1 {
            top: -100px;
            left: -100px;
        }

        .decoration-2 {
            bottom: -100px;
            right: -100px;
        }

        /* Developer Watermark */
        .watermark {
            position: fixed;
            bottom: 15px;
            right: 15px;
            font-size: 13px;
            color: rgba(79, 70, 229, 0.6);
            z-index: 100;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        .watermark:hover {
            color: var(--primary-dark);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
            transform: translateY(-2px);
        }

        .watermark a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .watermark i {
            color: var(--secondary);
            font-size: 14px;
        }

        .watermark span {
            font-weight: 500;
        }

        /* Animation for watermark */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        .watermark:hover {
            animation: pulse 1.5s infinite;
        }

        .watermark i {
            margin-right: 5px;
        }

        /* Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .logo {
            animation: float 4s ease-in-out infinite;
        }

        .logo:nth-child(2) {
            animation-delay: 0.5s;
        }

        @media (max-width: 768px) {
            .content {
                padding: 2rem 1rem;
            }

            h1 {
                font-size: 2.2rem;
            }

            .tagline {
                font-size: 1.2rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
                margin-bottom: 1rem;
            }

            .logos {
                gap: 1.5rem;
            }

            .logo {
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>

            <div class="content">
                <div class="logos">
                    <img src="/images/sweet.png" alt="Sweet Logo" class="logo">
                    <img src="/images/g.png" alt="African Logo" class="logo">
                </div>

                <h1>Welcome to Tal System Management</h1>
                <p class="tagline">Streamline your inventory control with our powerful stock management solution designed for efficiency and growth under Maintenance Department</p>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="feature-title">Inventory Management</h3>
                        <p>Track all your products with real-time stock levels and automated alerts for low inventory</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Smart Analytics</h3>
                        <p>Get valuable insights into your stock movement, sales trends, and product performance</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="feature-title">Automated Alerts</h3>
                        <p>Receive instant notifications for low stock, expiring items, and important inventory events</p>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="/login" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </a>
                    <a href="/register" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Developer Watermark -->
    <div class="watermark">
        <a href="https://zaidaliqui.netlify.app/" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-code"></i>
            <span>Developed by Tal System Team</span>
        </a>
    </div>

    <script>
        // Add a simple animation to the watermark on hover
        document.querySelector('.watermark').addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.05)';
        });

        document.querySelector('.watermark').addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>
