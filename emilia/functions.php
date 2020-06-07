<?php

    require('admin/sql_connect.php');

//    FUNKCJA DO POBIERANIA DANYCH O NARZĘDZIACH
    function get_elemets($type){
        global $mysqli;

        switch ($type){
            case 'avalible':
                $sql = "SELECT element_id, element_name, element_description, price, image FROM elements WHERE availability = 1";
                break;

            case 'unavalible':
                $sql = "SELECT element_id, element_name, element_description, price, image FROM elements WHERE availability = 0 ";
                break;

            case 'select':
                $sql = "SELECT element_id, element_name FROM elements WHERE availability = 1 ";
                break;

        }


        $result = $mysqli->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }


//  FUNKCJA DO GENEROWANIA TABLICY ZAMÓWIEŃ


    function generate_orders() {
        global $mysqli;

        $sql = "SELECT elements.element_name, users.user_name, users.user_lastname, reservations.cost, reservations.from_date, reservations.to_date FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }


?>