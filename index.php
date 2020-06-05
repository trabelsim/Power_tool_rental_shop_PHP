<!DOCTYPE html>
<html>
<head>
<!--Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>KaTra</title>
</head>
<body class="text-center">
    <h2>Wypożyczalnia elektronarzędzi</h2>
    <img src="img/top.jpg" alt="-" width=1100 height="300">
    <br><br>
    <?php
        // powitanie
          
        $message = "Witamy na naszej stronie!";
        echo "<h3>$message</h3>";
    ?>
    <hr>
    <h3>Zaloguj się</h3>
    <form id="log_form" action="narzedzia.php" class="form-inline" method="POST">
        <!-- pole do login : dane przechowywane są w inputLogin -->
        <label for="inputLogin" class="sr-only">Login</label>
        <input type="text" name="inputLogin" class="form-control" placeholder="Login użytkownika" required autofocus>
        <br>
        <!-- pole do hasła : dane są przechowywane w inputPassword -->
        <label for="inputPassword" class="sr-only">Hasło</label>
        <input type="password" name="inputPassword" class="form-control" placeholder="Hasło" required>
        <br><br>
        <button class="btn btn-lg btn-primary btn-block mr-1" type="submit">
            Login
        </button>

    </form>
</body>
</html>