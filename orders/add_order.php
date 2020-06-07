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


    $dodaj_narz = "INSERT INTO elements ( element_name, element_description, price , image ,availability) VALUES (:NAMEIN,:DESCIN,:PRICE,:IMG_X,:AVAIL)";
    $dodaj_zam = "INSERT INTO reservations (client_id, element_id, from_date, to_date, price, status) VALUES (:CLIENT,:ELEMENT,:OD,:DO,:PRICE,:STAT)";

    $pobierz_id_elementu = "SELECT element_id FROM `elements` WHERE element_name =:ELEM";

    $pobierz_id_user = "SELECT user_id FROM users WHERE login=:USERX";
    // dodawania zamówienia
    $statement = $db->prepare($dodaj_zam);
    // pobieranie id elementu
    $statement2 = $db->prepare($pobierz_id_elementu);
    // pobieranie id usera
    $statement3 = $db->prepare($pobierz_id_user);



    // pobieranie nazwy elementu i przetworzenie na ID zgodnie z wymogami tabeli
    $wartosc_name = $_REQUEST['element_input_name'];
    $statement2->bindValue(':ELEM',$wartosc_name,PDO::PARAM_STR);
    $statement2->execute();
    while($element = $statement2->fetch()){
        $id_elementu =  $element['element_id'];
        echo $id_elementu;
    }

    // pobieranie nazwy użytkownika i przetworzenie na ID
    $wartosc_user = $_REQUEST['user_input_name'];
    $statement3->bindValue(':USERX',$wartosc_user,PDO::PARAM_STR);
    $statement3->execute();
    while($user = $statement3->fetch()){
        $id_user = $user['user_id'];
        echo $id_user;
    }


    $wartosc_status =$_REQUEST['user_input_status'];


    $wartosc_od =$_REQUEST['data_od'];


    $wartosc_do =$_REQUEST['data_do'];



    $wartosc_price = 10;

    if($wartosc_status == "Wypożycz") $wartosc_status = 1;
    else $wartosc_status = 0;

    if($statement->bindValue(':CLIENT',$id_user,PDO::PARAM_INT)){
        echo "id usera ".$id_user;
    }
    if($statement->bindValue(':ELEMENT',$id_elementu,PDO::PARAM_INT)){
        echo " id elementu ".$id_elementu;
    }
    if($statement->bindValue(':OD',$wartosc_od,PDO::PARAM_STR)){
        echo "od ".$wartosc_od;
    }
    if($statement->bindValue(':DO',$wartosc_do,PDO::PARAM_STR)){
        echo "do ".$wartosc_do;
    }
    if($statement->bindValue(':PRICE',$wartosc_price, PDO::PARAM_INT)){
        echo "cena ".$wartosc_price;
    }
    if($statement->bindValue(':STAT',$wartosc_status, PDO::PARAM_INT)){
        echo "status ".$wartosc_status;
    }
    if($statement->execute()){
        echo "Nowy element został wprowadzony";
        $statement->closeCursor();
        header('Location:orders.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>