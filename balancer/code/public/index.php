<?php
session_start();
include "../vendor/autoload.php";

$app = new \IilyukDmitryi\App\App();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Форма проверки emails</title>
    <style>
        form {
            margin: auto;
            width: 50%;
            border: 2px solid black;
            padding: 20px;
            text-align: center;
            background-color: #f2f2f2;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type=text],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php $app->run(); ?>
</body>
</html>

