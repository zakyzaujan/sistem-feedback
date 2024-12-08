<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Feedback</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: linear-gradient(to top, #09203f 0%, #537895 100%);
            background-size: cover;
            position: relative;
            color: white;
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            animation: fadeIn 1.5s ease;
        }

        h1, p, .btn-container, footer, .extra-info, .carousel {
            position: relative;
            z-index: 1;
            margin: 10px auto;
            max-width: 800px;
        }

        h1 {
            font-size: 2.8rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
            padding: 0 15px;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-custom {
            font-size: 1rem;
            text-transform: uppercase;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            background: white;
            color: #09203f;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .extra-info {
            margin-top: 50px;
            padding: 0 15px;
        }

        .extra-info h3 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .extra-info ul {
            text-align: left;
            margin: 20px auto;
            max-width: 700px;
            font-size: 1rem;
            list-style-type: disc;
            padding-left: 20px;
        }

        .extra-info ul li {
            margin-bottom: 15px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            .btn-custom {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            .extra-info h3 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 0.9rem;
            }

            .btn-custom {
                font-size: 0.8rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <img src="assets/icons/index_logo.png" alt="Logo Sistem Feedback" style="max-width: 100px; margin-bottom: 20px;">
    <h1>Selamat Datang di Sistem Feedback PT Xyz</h1>
    <p>
        Kami hadir untuk membantu Anda memberikan masukan, saran, atau laporan 
        secara efisien. Tingkatkan komunikasi dan kolaborasi melalui platform kami.
    </p>
    <div class="btn-container">
        <a href="login.php" class="btn btn-custom"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
    </div>
    <div class="extra-info">
        <h3>Kenapa Memilih Sistem Feedback?</h3>
        <ul>
            <li>Mudah digunakan oleh semua kalangan</li>
            <li>Memastikan semua feedback dikelola dengan baik</li>
            <li>Respons cepat terhadap saran dan laporan</li>
        </ul>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
