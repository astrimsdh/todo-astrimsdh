<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/sweetalert2.min.css">

    <script src="https://kit.fontawesome.com/882731e2a4.js" crossorigin="anonymous"></script>
    <script src="/assets/jquery-3.7.1.min.js"></script>
    <script src="/assets/sweetalert2.all.min.js"></script>
    <style>
        html, body {
            height: 100%;
        }
        .full-height {
            height: 100vh;
        }
    </style>
    <title>Document</title>
</head>
<body>

    @yield('container')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/script.js"></script>
    @yield('script')
</body>
</html>