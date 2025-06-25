<?php
$apiUrl = 'http://app-service/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query(['name' => $name])
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($apiUrl, false, $context);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$response = file_get_contents($apiUrl);
$users = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Flask-MySQL App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
            color: #2a2a2a;
            line-height: 1.6;
            position: relative;
            overflow: hidden;
        }

        .bubble-bg {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            background: rgba(100, 181, 246, 0.15);
            border-radius: 50%;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            100% {
                transform: translateY(-1200px) scale(1.2);
                opacity: 0;
            }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 720px;
            margin: 60px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #003366;
            border-bottom: 2px solid #003366;
            padding-bottom: 6px;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 30px;
        }

        input[type="text"] {
            flex: 1 1 280px;
            padding: 14px 16px;
            border: 2px solid #cfd8dc;
            border-radius: 6px;
            font-size: 16px;
            background-color: #ffffff;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #1565c0;
            outline: none;
            box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.2);
        }

        input[type="submit"] {
            padding: 14px 24px;
            background-color: #1565c0;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        input[type="submit"]:hover {
            background-color: #0d47a1;
            transform: translateY(-2px);
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            background-color: #fefefe;
            padding: 14px 18px;
            margin-bottom: 12px;
            border-left: 5px solid #1565c0;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
        }

        li:hover {
            transform: translateX(6px);
        }

        @media (max-width: 600px) {
            .container {
                margin: 30px 16px;
                padding: 20px;
            }

            form {
                flex-direction: column;
                align-items: stretch;
            }

            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="bubble-bg">
        <?php for ($i = 0; $i < 20; $i++): ?>
            <div class="bubble" style="
                left: <?= rand(0, 100) ?>%;
                width: <?= rand(20, 60) ?>px;
                height: <?= rand(20, 60) ?>px;
                animation-duration: <?= rand(12, 28) ?>s;
                animation-delay: <?= rand(0, 10) ?>s;"></div>
        <?php endfor; ?>
    </div>

    <div class="container">
        <h1>Write your Note Here</h1>
        <form method="post">
            <input type="text" name="name" required placeholder="Enter a name" />
            <input type="submit" value="Submit" />
        </form>

        <h2>Notes List</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
