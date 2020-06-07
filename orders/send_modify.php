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

    $id_zamowienie_selected = (int)($_REQUEST['zamow_id']);
    $modif_zamowienie = "UPDATE reservations SET `client_id`=:CLIENT_ID, `element_id`=:ELEMENT_ID, `from_date`=:FROMDATE, `to_date`=:TODATE , `status`=:STAT WHERE `id`=".$id_zamowienie_selected;

    // pobieranie danych o narzędziach
    $statement_mod = $db->prepare($modif_zamowienie);



    // dodawanie elementów
    $wartosc_client = $_REQUEST['user_input_name'];
    $wartosc_urz = $_REQUEST['element_input_name'];
    $wartosc_status = $_REQUEST['user_input_status'];
    $wartosc_od =$_REQUEST['data_od'];
    $wartosc_do = $_REQUEST['data_do'];

    echo $wartosc_client;
    echo $wartosc_urz;
    echo $wartosc_status;
    echo $wartosc_od;
    echo $wartosc_do;

    if($wartosc_status == "Wypożycz") $wartosc_avail = 1;
    else $wartosc_avail = 0;

    $statement_mod->bindValue(':CLIENT_ID',$wartosc_client,PDO::PARAM_INT);
    $statement_mod->bindValue(':ELEMENT_ID',$wartosc_urz,PDO::PARAM_INT);
    $statement_mod->bindValue(':FROMDATE',$wartosc_od,PDO::PARAM_STR);
    $statement_mod->bindValue(':TODATE',$wartosc_do,PDO::PARAM_STR);
    $statement_mod->bindValue(':STAT',$wartosc_status,PDO::PARAM_INT);
    // $statement_mod->bindValue(':ID_X',$id_element_selected,PDO::PARAM_INT);
    if($statement_mod->execute()){
        echo "Nowy element został wprowadzony";
        $statement_mod->closeCursor();
        header('Location: orders.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>