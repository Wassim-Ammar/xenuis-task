<!-- resources/views/cv.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #555;
            margin-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 30px;
        }

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-info div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="section contact-info">
        <h2>Contact Information</h2>
        <div><strong>Name:</strong> {{ $user['name'] }} {{ $user['surname'] }}</div>
        <div><strong>Mobile:</strong> {{ $user['mobile'] }}</div>
        <div><strong>Address:</strong> {{ $user['address'] }}</div>
        <div><strong>Email:</strong> {{ $user['email'] }}</div>
    </div>

    <h2>Experiences</h2>
    <ul>
        @foreach ($experiences as $experience)
            <li>
                {{ $experience['title'] }}
                {{ \Carbon\Carbon::parse($experience['start_date'])->format('d/m/Y') }} - {{  \Carbon\Carbon::parse($experience['end_date'])->format('d/m/Y') }}
            </li>
        @endforeach
    </ul>

    <h2>Education</h2>
    <ul>
        @foreach ($educations as $edu)
            <li>
                {{ $edu['title'] }} 
                {{ \Carbon\Carbon::parse($edu['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($edu['end_date'])->format('d/m/Y')}}
            </li>
        @endforeach
    </ul>
</body>
</html>
