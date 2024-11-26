@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet"> --}}

    <style>
        body {
            margin: 0;
            height: 100vh;
            background-image: url('{{ public_path('certificate/serti-bg.png') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
        }

        .certificate-container {
            position: relative;
            width: 100%;
            height: auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            margin: 0 auto;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .certificate-number {
            position: absolute;
            font-family: 'Poppins', sans-serif;
            left: 46%;
            top: 24.3%;
            transform: translate(-50%, -50%);
            font-size: 22px;
            font-weight: 400;
            letter-spacing: 4px;
            color: #333;
            width: 100%;
        }

        @font-face {
            font-family: 'Great Vibes';
            src: url('{{ public_path('fonts/Great_Vibes/GreatVibes-Regular.ttf') }}') format('truetype');
        }

        .name-people {
            position: absolute;
            left: 50%;
            top: 46%;
            transform: translate(-50%, -50%);
            font-size: 42px;
            font-weight: 500;
            letter-spacing: 3px;
            color: #3b3a3a;
            line-height: 25px;
            font-family: 'Great Vibes', cursive;
            /* Menggunakan font Great Vibes */
        }

        .course-title {
            position: absolute;
            top: 60%;
            left: 49%;
            transform: translate(-50%, -50%);
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            /* Menggunakan Poppins untuk judul kursus */
            font-weight: 700;
            color: #555;
        }

        .qr-code .verifikasi {
            position: absolute;
            right: 12%;
            bottom: 13.6%;
            font-size: 11px;
            color: #000000;
            font-family: 'Poppins', sans-serif;
        }

        .qr-code .link {
            position: absolute;
            right: 12%;
            bottom: 11.5%;
            font-size: 11px;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        .qr-code .valid {
            position: absolute;
            right: 12%;
            bottom: 9.4%;
            font-size: 9px;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        .date {
            position: absolute;
            left: -33.9%;
            bottom: 29%;
            font-family: 'Poppins', sans-serif;
            /* Menggunakan Poppins untuk tanggal */
            font-weight: 700;
            font-size: 11px;
            color: #333;
            width: 100%;
        }

        .qr-code img {
            width: 55px !important;
            position: absolute;
            right: 12.4%;
            bottom: 17%;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="certificate-number" style="margin-left: 20px" id="code">{{ $userCourse->certificate->code }}</div>
        <div class="name-people" id="username">{{ $userCourse->user->name }}</div>
        <div class="course-title d-flex justify-content-center text-center" id="course_title">
            {{ $userCourse->course->title }}</div>
        <div class="date" id="date">{{ \Carbon\Carbon::parse($userCourse->created_at)->format('d F Y') }}</div>
        <div class="qr-code">
            <img src="" alt="QR Code">
            <div class="verifikasi"><b>Verifikasi Sertifikat</b></div>
            <div class="link">{{ env('WEB_URL') . '/' . $type . '/pre-download-certificate/' . $slug }}</div>
            <div class="valid"><i>Berlaku hingga
                    {{ \Carbon\Carbon::parse($userCourse->created_at)->addYears(4)->format('d F Y') }}</i></div>
        </div>
    </div>
</body>

</html>
