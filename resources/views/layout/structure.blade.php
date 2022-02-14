<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>@yield('title', 'IMP.control')</title>
</head>
<body>
    @yield('content')
    <script src="http://imp_control:7882/resources/js/jQuery%20v3-4-1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="http://imp_control:7882/resources/js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
    @yield('script', '')
</body>
</html>

