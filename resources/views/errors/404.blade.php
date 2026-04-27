<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .container {
            max-width: 500px;
            padding: 20px;
        }

        h1 {
            font-size: 120px;
            font-weight: 800;
            letter-spacing: 5px;
            animation: float 3s ease-in-out infinite;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        a {
            display: inline-block;
            padding: 12px 25px;
            background: #fff;
            color: #4f46e5;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        a:hover {
            background: #e0e7ff;
            transform: translateY(-2px);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 80px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>404</h1>
        <h2>Oops! Page not found</h2>
        <p>The page you're looking for doesn't exist or has been moved.</p>
        <a href="/">Go Back Home</a>
    </div>

</body>
</html>