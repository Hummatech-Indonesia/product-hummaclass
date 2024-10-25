<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-image: url('{{ public_path('certificate/serti-bg.png') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            /* Memusatkan teks */
        }

        h1 {
            font-size: 24px;
            margin: 10px 0;
            /* Jarak atas dan bawah */
        }

        .name-people {
            font-family: "Great Vibes", cursive;
            font-size: 18px;
            margin: 5px 0;
        }

        .course-title {
            font-size: 16px;
            margin: 5px 0;
        }

        .date {
            font-size: 14px;
            margin: 5px 0;
        }

        .qr-code {
            margin-top: 20px;
        }

        .verifikasi,
        .link,
        .valid {
            font-size: 14px;
            margin: 5px 0;
        }

        img {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <h1>12202410250002</h1>
    <div class="name-people" id="username">Mohamad Arif</div>
    <div class="course-title" id="course_title">Belajar Membuat Aplikasi Kognitif</div>
    <div class="date" id="date"><b></b></div>
    <div class="qr-code">
        <img src="{{ asset('assets/img/certificate/qr.png') }}" alt="QR Code">
        <div class="verifikasi"><b>Verifikasi Sertifikat</b></div>
        <div class="link">class.hummatech.com/sertifikat/example</div>
        <div class="valid"><i>Berlaku hingga 28 Agustus 2024</i></div>
    </div>
</body>

</html>
