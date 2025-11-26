<?php
// Opsional: jika ingin redirect otomatis ke home setelah beberapa detik
// header("refresh:5;url=home.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>404 Not Found</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        body {
            background: #f6f9ff;
        }

        .notfound {
            margin-top: 10%;
            text-align: center;
        }

        .notfound h1 {
            font-size: 120px;
            font-weight: 700;
            color: #4154f1;
        }

        .notfound h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #012970;
        }
    </style>
</head>

<body>

    <div class="container notfound">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p class="mb-4">Maaf, halaman yang Anda cari tidak tersedia atau sudah dihapus.</p>

        <a href="index.php" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
        </a>
    </div>

</body>

</html>