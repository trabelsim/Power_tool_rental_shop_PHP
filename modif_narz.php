<!DOCTYPE html>
<html>
<head>
<!--Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>KaTra</title>
</head>
<body>
    <h2 style="text-align:center;">Wypożyczalnia elektronarzędzi</h2>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/index.php" role="button">Login</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/users.php" role="button">Użytkownicy</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/narzedzia.php" role="button">Narzędzia</a>
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
        echo "<h3 style='color:blue; text-align:right' >$name</h3>";

        // ZAPYTANIE - Wyświetl narzędzia z bazy danych
        $wys_narz = "SELECT * FROM elements";

        // ZAPYTANIE - Dodaj narzędzie do bazy danych
        $dodaj_narz = "INSERT INTO `elements`(`element_id`, `element_name`, `element_description`, `availability`) VALUES (:NAMEIN,:DESCIN,:AVAIL)";
        
        // zmienne do modyfikacji
        $id_element_selected = $_GET['id'];
        $pokaz_wybrane= "SELECT * FROM elements WHERE element_id=".$id_element_selected;
        // pobieranie danych o narzędziach
        $statement = $db->prepare($wys_narz);
        $statement2 = $db->prepare($dodaj_narz);
        $statement3= $db->prepare($pokaz_wybrane);

        // wykonanie zapytania i wdrożenie
        $statement->execute();
        $statement3->execute();
        while($element = $statement3->fetch()){
            $id_x =  $element['element_id'] ;
            $name_x = $element['element_name'];
            $desc_x =  $element['element_description'];
            if($element['availability']==1) $avail_x="checked=true";
            else $avail_x = "";
        }
    ?>
    <br><br>
    <hr>
    <h3 style="text-align:center;">Narzędzia</h3>

    <div>
        <div style="margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num</th>
                    <th scope="col">Przedmiot</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Dostępność</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
                <?php
                    while($element = $statement->fetch()){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $element['element_id'] .'</td>';
                        echo "<td style='text-align:center;'>". $element['element_name'].'</td>';
                        echo "<td style='text-align:center;'>". $element['element_description'].'</td>';
                        if($element['availability'] == '1')
                            echo "<td style='text-align:center;'>". "Dostępny" .'</td>';
                        else{
                            echo "<td style='text-align:center;'>". "Niedostępny" .'</td>';
                            }
                        echo "<td style='text-align:center;'>". "<a href='modif_narz.php?id=".$element['element_id']."'>" ."Edit". "</a>" .
                             "<a href='usun_narz.php?id=".$element['element_id']."'>" ."  Delete". "</a>"
                            ."</td>";
                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>
<hr><br>
    <div>
        <form action="send_req2_mod.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-4" style="margin-left:200px;">
                    <label for="element_input_name">Dodaj urządzenie</label>
                    <input type="text" value="<?php echo $name_x ?>" class="form-control" id="element_input_name" name="element_input_name" placeholder="Nazwa urządzenia">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" <?php echo $avail_x ?> class="form-check-input" id="availability_input" name="availability_input" style="vertical-align:bottom; position:relative;margin-left:20px;margin-top:40px;">
                    <label class="form-check-label" for="availability_input" style="display:inline-block;">Urządzenie jest dostępne</label>
                </div>
                <div class="form-group col-md-6" style="margin-left:200px;">
                    <textarea type="text" class="form-control" id="element_input_desc" name="element_input_desc" rows="3" placeholder="Opis urządzenia"><?php echo $desc_x ?></textarea>
                </div>
                <div style="margin-left:200px;">
                    <button type="submit" name="modify_element_button" id="modify_element_button" class="btn btn-primary mb-2" >Modyfikuj</button>
                </div>
                <input type="hidden" name="element_id" value=<?php echo $id_x ?>>
            </div>
        </form>
    </div>
</body>
</html>
