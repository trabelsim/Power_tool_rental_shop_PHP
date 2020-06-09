<!DOCTYPE html>
<html>
<head>
<!--Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>KaTra</title>
</head>
<body>
    <div style="text-align:center;">
    <h2 style="text-align:center; margin-bottom:50px;;">Panel administratora</h2>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/index.php" role="button">Strona główna</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/users/users.php" role="button">Użytkownicy</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/workers/workers.php" role="button">Pracownicy</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/narzedzia/narzedzia.php" role="button">Narzędzia</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/orders.php" role="button">Zamówienia</a>

    </div>
    <?php
        // powitanie
        $name = $_POST['inputLogin'];
        echo "<h3 style='color:blue; text-align:right' >$name</h3>";
    ?>
    <br><br>
    <hr>
    
    <?php

        // deklaracja zmiennych na potrzeby łączenia się z bazą danych
        $dns = "mysql:host=localhost;dbname=projekt_db";
        $username = "root";
        $password = "mysql";


        // łączenie z bazą danych
        // w przypadku niepowodzenia, błąd zostanie wyświetlony na stronie
        try{
            $db = new PDO($dns,$username,$password);


        }catch(Exception $e){
            $error_message = $e->getMessage();
            echo "<p>Error message : $error_message</p>";

        }


        // powitanie
        $name = $_POST['inputLogin'];
        echo "<h3 style='color:blue; text-align:right;' >$name</h3>";

        // ZAPYTANIE - Wyświetl userów z bazy danych
        $wys_users = "SELECT * FROM users";

        // ZAPYTANIE - Wyświetl tylko wybrane przez ID
        $id_user_selected = $_GET['id'];
        $pokaz_wybrany_user = "SELECT * FROM `users` WHERE `user_id` =".$id_user_selected;


        // pobieranie danych o narzędziach
        $statement = $db->prepare($wys_users);

        // pobieranie user po id
        $statement2 = $db->prepare($pokaz_wybrany_user);
        // wykonanie zapytania i wdrożenie
        $statement->execute();
        $statement2->execute();
        while($user = $statement2->fetch()){
            $user_id =  $user['user_id'] ;
            $login = $user['login'];
            $pass =  $user['pass'];
            $user_name = $user['user_name'];
            $user_lastname = $user['user_lastname'];
            $phone_num = $user['telephone_num'];
        }
    ?>


    <h3 style="text-align:center;">Użytkownicy</h3>
    <hr>
    <br>
    <div>
        <form action="send_modify.php" method="post">
        <label for="new_user" style="margin-left:200px;margin-bottom:50px;">Edytuj użytkownik</label>
            <div class="form-row" id="new_user">
                <div class="form-group col-md-2" style="margin-left:200px;">
                    <label for="login_input">Login użytkownika</label>
                    <input pattern=".{3,}" value="<?php echo $login ?>" required title="Minimum 3 znaki" type="text" class="form-control" id="login_input" name="login_input" placeholder="Login użytkownika">
                </div>
                <div class="form-group col-md-2" style="margin-left:50px;">
                    <label for="pass_input">Hasło</label>
                    <input type="text" value="<?php echo $pass ?>" class="form-control" id="pass_input" name="pass_input" placeholder="hasło">
                </div>
                <div class="form-group col-md-2" style="margin-left:50px;">
                    <label for="name_input">Imię</label>
                    <input pattern=".{3,}" value="<?php echo $user_name ?>" required title="Minimum 3 znaki" type="text" class="form-control" id="name_input" name="name_input" placeholder="Imię użytkownika">
                </div>
                <div class="form-group col-md-2" style="margin-left:50px;">
                    <label for="lastname_input">Nazwisko</label>
                    <input type="text" value="<?php echo $user_lastname ?>" class="form-control" id="lastname_input" name="lastname_input" placeholder="Nazwisko użytkownika">
                </div>
                <div class="form-group col-md-2" style="margin-left:1015px;">
                    <label for="phone_input">Numer telefonu</label>
                    <input type="float" value="<?php echo $phone_num ?>" class="form-control" id="phone_input" name="phone_input" placeholder="Komórkowy/Stacjonarny">
                </div>
                <input type="hidden" name="user_id" value=<?php echo $user_id ?>>
                </div>
                <div style="margin-left:1500px;">
                    <button style="margin-right:50px;" type="submit" name="add_element_button" id="add_element_button" formaction="users.php" class="btn btn-primary mb-2" >Wróc</button>
                    <button type="submit" name="add_element_button" id="add_element_button" class="btn btn-primary mb-2" >Modyfikuj</button>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <br>
    <div>
        <div style="text-align:center;margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num</th>
                    <th scope="col">Login</th>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">Numer telefonu</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
                <?php
                    while($user = $statement->fetch()){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $user['user_id'] .'</td>';
                        echo "<td style='text-align:center;'>".$user['login'].'</td>';
                        echo "<td style='text-align:center;'>". $user['user_name'].'</td>';
                        echo "<td style='text-align:center;'>". $user['user_lastname'].'</td>';
                        echo "<td style='text-align:center;'>". $user['telephone_num'].'</td>';
                        echo "<td style='text-align:center;'>". "<a href='modif_client.php?id=".$user['user_id']."'>" ."Zmień". "</a>" .
                        "<a href='usun_client.php?id=".$user['user_id']."'>" ."  Usuń". "</a>"
                       ."</td>";

                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>


</body>
</html>