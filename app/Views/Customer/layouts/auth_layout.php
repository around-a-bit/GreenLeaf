<!DOCTYPE html>
<html>

<head>
    <title>Customer Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .auth-box h3 {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <?= $this->renderSection('content') ?>

</body>

</html>