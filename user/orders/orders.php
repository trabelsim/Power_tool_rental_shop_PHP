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
        <h2 style="text-align:center;">Wypożyczalnia elektronarzędzi</h2>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/user/index.php" role="button">Strona główna</a>
        <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/user/orders/orders.php" role="button">Moje zamówienia</a>
    </div>
    <?php

        // deklaracja zmiennych na potrzeby łączenia się z bazą danych
        $dns = "mysql:host=localhost;dbname=projekt_db";
        $username = "root";
        $password = "mysql";

    $login_uzytkownika = 2; //<---------------------- TUTAJ TRZEBA WPROWADZIĆ ID UŻYTKOWNIKA PRZEKIEROWANY PRZEZ SESJE

        // łączenie z bazą danych
        // w przypadku niepowodzenia, błąd zostanie wyświetlony na stronie
        try{
            $db = new PDO($dns,$username,$password);


        }catch(Exception $e){
            $error_message = $e->getMessage();
            echo "<p>Error message : $error_message</p>";

        }
        $wys_user = "SELECT * FROM users ORDER BY login";
        $wys_narz = "SELECT * FROM elements";

        $wys_zamowienia = 'SELECT reservations.id, elements.element_name as element_name,
                            users.user_lastname as user_lastname ,users.user_name as user_name ,
                            reservations.from_date, reservations.to_date , elements.price as element_cost,
                            reservations.status
                            FROM reservations
                            INNER JOIN elements ON reservations.element_id = elements.element_id
                            INNER JOIN users ON reservations.client_id = users.user_id
                            WHERE reservations.status=-0 OR reservations.status=1 AND reservations.client_id='
                            .$login_uzytkownika.' ORDER BY reservations.id DESC';

        $statement2 = $db->prepare($wys_narz);
        $statement = $db->prepare($wys_zamowienia);
        $statement3 = $db->prepare($wys_user);

        $statement->execute();
        $statement2->execute();
        $statement3->execute();

    ?>
    <br><br>
    <hr>
    <h3 style="text-align:center;">Moje zamówienia</h3>
    <div style="text-align:left;">
        <a style="text-align:center; margin-left:200px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/user/orders/orders.php" role="button">Aktywne</a>
        <a style="text-align:center; margin-left:50px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/user/orders/history/history.php" role="button">Historia</a>
    </div>
    <div>
        <div style="margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num zamówienia</th>
                    <th scope="col">Przedmiot</th>
                    <th scope="col">Użytkownik</th>
                    <th scope="col">Od (data)</th>
                    <th scope="col">Do (data)</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
                <?php
                    while($element = $statement->fetch()){
                        $data_init = strtotime(substr($element['from_date'],0,10));
                        $data_end = strtotime(substr($element['to_date'],0,10));
                        $koszt = (($data_end-$data_init)/60/60/24)*$element['element_cost'];
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $element['id'] .'</td>';
                        echo "<td style='text-align:center;'>". $element['element_name'].'</td>';
                        // echo "<td style='text-align:center;'>"."<img src=".'"img/'. $element['image'] . '"'. 'width="100" height="100" />'.'</td>';
                        echo "<td style='text-align:center;'>". $element['user_name']. ' '. $element['user_lastname'].'</td>';
                        echo "<td style='text-align:center;'>".$element['from_date'].'</td>';
                        echo "<td style='text-align:center;'>".$element['to_date'].'</td>';
                        echo "<td style='text-align:center;'>".$koszt.'</td>';
                        // zamówienie start
                        if($element['status'] == 0){
                            echo "<td style='text-align:center;'>".'Zarezerwowane'.'</td>';
                        }
                        elseif($element['status'] == 1){
                            echo "<td style='text-align:center;'>".'Wypożyczone'.'</td>';
                        }elseif($element['status'] == 2){
                            echo "<td style='text-align:center;'>".'Zwrócone'.'</td>';
                        }elseif($element['status'] == -1){
                            echo "<td style='text-align:center;'>".'Rezygnacja (rez)'.'</td>';
                        }elseif($element['status'] == -2){
                            echo "<td style='text-align:center;'>".'Anulowanie (wyp)'.'</td>';
                        }
                        echo "<td style='text-align:center;'>"."<a href='remove_order.php?id=".$element['id']."'>" ."  Anuluj". "</a>"
                            ."</td>";
                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>
<hr><br>
</body>
</html>