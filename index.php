<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book My Turf</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #4895ef;
            --success: #4cc9f0;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 10px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7fb;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
            text-align: center;
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                              url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }

        .hero {
            max-width: 800px;
            padding: 3rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        h1 {
            color: var(--primary-dark);
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        p {
            color: var(--gray);
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            line-height: 1.8;
        }

        .btn-enter {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 3rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-enter:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

    </style>
</head>
<body>
    <div class="hero">
        <h1>Book My Turf</h1>
        <p>Discover and book the perfect sports turf in your area — anytime, anywhere. Explore top facilities for your favorite games, check real-time availability, and enjoy a smooth, hassle-free booking experience.</p>
        <a href="login.php" class="btn-enter">Enter</a>
    </div>
</body>
</html>