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

    $id_zamowienie = $_GET['id'];
    $delete_zamowienie = "DELETE FROM reservations WHERE id=:ID";

    // // pobieranie danych o narzędziach
    $statement = $db->prepare($delete_zamowienie);

    
    $statement->bindValue(':ID',$id_zamowienie,PDO::PARAM_INT);
    if($statement->execute()){
        echo "Element został usunięty";
        $statement->closeCursor();
        header('Location: orders.php');
    }else{
        echo "Element nie został usunięty";
    }
?>