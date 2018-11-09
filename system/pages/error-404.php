<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 404</title>
    <style>
        body {
            margin: 0;
        }
        .container {
            width: 100%;
            height: 100%;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container img {
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?= public_path('error.svg') ?>">
    </div>
</body>
</html>