<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>IMP.CONTROL - Login</title>
</head>
<body>
    <div class="logo_container">
        <a href="public/">
            <img src="assets/logo.svg" alt="">
        </a>
    </div>
    @if (Session::has('error'))
    <div class="text-center container alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <div class="form_container">
        <form action="login" method="POST">
            @csrf
            <div class="log_user">
                <img src="assets/log_user.svg" alt="">
            </div>
            <div class="input_grp">
                <label>Identifiant :</label>
                <input type="text" placeholder="amine par exemple" name="identifiant" required>
            </div>
            <div  class="input_grp">
                <label>Mot de passe :</label>
                <input type="password" placeholder="**********" name="password" required>
            </div>
            <input type="submit" value="Connexion">
        </form>
    </div>
    <script src="http://imp_control:7882/resources/js/jQuery v3-4-1.js"></script>
    <script src="http://imp_control:7882/resources/js/bootstrap.min.js"></script>
</body>
</html>
