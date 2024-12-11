<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Feedback</title>
    <link href="assets/css/pages/login.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('assets/img/empty-elegant-background-with-copy-space.jpg');
            background-size: cover;
            background-position: center center;
            position: relative;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding-bottom: 36px;
        }

        .animation {
            animation: fadeIn 1.0s ease;
        }

        .btn-custom {
            font-size: 1rem;
            text-transform: uppercase;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            background-color: #0c3483 !important;
            border-color: #0c3483 !important;
            color: white;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            background-color: #a2b6df !important;
            border-color: #a2b6df !important;
        }

        .card-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }

        .extra-info ul {
            list-style-type: none;
            padding-left: 0;
            margin-left: 0;
            text-align: center;
        }

        .extra-info li {
            margin-bottom: 8px;
            text-align: center;
            line-height: 1.5;
        }

        .extra-info h3 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .btn-custom {
                width: 100%;
                padding: 10px;
            }

            .card-container {
                padding: 15px;
            }
        }
    </style>
</head>

<body class="bg-dark text-white d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">

    <!-- Image -->
    <img src="assets/icons/index_logo.png" alt="Logo Sistem Feedback" class="mb-4 " style="max-width: 120px;">

    <!-- Card Container -->
    <div class="card-container animation">
        <h1 class="text-center text-dark">Selamat Datang di Sistem Feedback PT XYZ</h1>
        <br>
        <p class="text-muted text-center">
            Kami hadir untuk membantu Anda memberikan masukan, saran, atau laporan secara efisien. Tingkatkan komunikasi
            dan kolaborasi melalui platform kami.
        </p>
        <br>
        <div class="text-center mb-3">
            <a href="login.php" class="btn btn-custom"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
        </div>
        <br><br>
        <div class="extra-info text-dark">
            <h3>Kenapa Memilih Sistem Feedback?</h3>
            <ul>
                <li><i class="fa fa-check-circle"></i> Mudah digunakan oleh semua kalangan.</li>
                <li><i class="fa fa-check-circle"></i> Memastikan semua feedback dikelola dengan baik.</li>
                <li><i class="fa fa-check-circle"></i> Respons cepat terhadap saran dan laporan.</li>
            </ul>

        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>

</html>
