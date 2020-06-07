<?php
    require('functions.php');
?>
<!doctype html>
<html lang="pl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Wypożyczalnia KATRA</title>
</head>
<body>
    <!--header-->
    <header>
        <div class="container h-75 d-flex aligm-items-center">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-primary text-center font-weight-bold"> WYPOŻYCZALNIA ELEKTRONARZĘDZI</h1>
                    <h1 class="text-danger text-center font-weight-bold display-2"> KATRA</h1>
                </div>
                <div class="col-12">
                    <div class="row mt-5 d-flex" >
                        <button class="btn btn-primary btn-lg col-lg-3 col-md-6 col-sm-12 m-4 font-weight-bold">ZALOGUJ SIĘ</button>
                        <button class="btn btn-primary btn-lg col-lg-3 col-md-6 col-sm-12 m-4 font-weight-bold">ZAREJESTRUJ SIĘ</button>
                    </div>
                </div>
            </div>

        </div>
    </header>


    <div class="row">
        <div class="col-12">
            <h5 class="text-center text-danger">Tylko użytkownicy posiadający konto mogą korzystać z wypożyczalni!</h5>

        </div>
    </div>


    <!--oferta-->
    <section id="avalible">
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center p-5 font-weight-bold">DOSTĘPNE NARZĘDZIA</h2>
                </div>
            </div>

            <div class="row">


                <?php
                    $rows=get_elemets('avalible');

                    foreach ($rows as $r) {
                        echo '<div class="col-lg-3 col-md-6 col-sm-12" mt-3>';
                        echo '<div class="card">';
                        echo '<img src="naimg/'.$r['image'].'" class="card-img-top" alt="Oferta">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title text-center font-weight-bold">'.$r['element_name'].'</h5>';
                        echo '<p class="text-center">'.$r['element_description'].'</p>';
                        echo '<p class="text-center font-weight-bold">'.$r['price'].'zł/dzień</p>';
                        echo '<button class="btn btn-primary col-12 font-weight-bold" onclick="reserve('.$r['element_id'].')">Wypożycz</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                ?>
            </div>

        </div>


    </section>



    <section id="unavalible">
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center p-5 font-weight-bold">OBECNIE ZAREZERWOWANE</h2>

                </div>
            </div>

            <div class="row">


                <?php
                $rows=get_elemets('unavalible');

                foreach ($rows as $r) {
                    echo '<div class="col-lg-3 col-md-6 col-sm-12" mt-3>';
                    echo '<div class="card">';
                    echo '<img src="naimg/'.$r['image'].'" class="card-img-top" alt="Oferta">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-center font-weight-bold">'.$r['element_name'].'</h5>';
                    echo '<p class="text-center">'.$r['element_description'].'</p>';
                    echo '<p class="text-center font-weight-bold">'.$r['price'].'zł/dzień</p>';
                    echo '<button class="btn btn-danger col-12 font-weight-bold" disabled>NIEDOSTĘPNE</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                ?>
            </div>


        </div>


    </section>

    <section id="reservation">
        <div class="container-fluid">
            <h1 class="text-center p-5 font-weight-bold">ZAREZERWUJ</h1>
            <div class="row">
                <div class="col-12 d-flex justify-content-center p-5">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="login">Login</label>
                                    <input type="text" class="form-control" login="login" id="login" placeholder="Login" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pass">Hasło</label>
                                    <input type="password" class="form-control" pass="pass" id="pass" placeholder="Hasło" required>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="lements">Narzędzie</label>
                            <select name="narzedzia" class="form-control" id="narzedzia">

                                <?php
                                    $rows = get_elemets("select");

                                    foreach ($rows as $r) {
                                        echo'<option value="'.$r['element_id'].'">'.$r['element_name'].'</option>';
                                    }
                                ?>


                            </select>
                        </div>

                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label for="date">Termin</label>
                                    <input type="date" class="form-control" name="date" id="date" required>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="days">Dni</label>
                                    <input type="number" class="form-control" name="days" id="days" min="1" max="14">
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <h5 class="text-center text-danger p-5 font-weight-bold">Maksymalny czas wypożyczenia to 14 dni!</h5>
                            </div>
                        </div>

                        <div class="col-12">
                            <input type="submit" value="WYPOŻYCZ" class="btn btn-primary col-12 font-weight-bold">
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </section>

    <footer>
        <div class="col-12">
            <h6 class="text-center font-weight-bold p-1">Projekt zaliczeniowy przedmiotu BAZY DANYCH na Politechnice Wrocławskiej: Emilia Kalińska, Maroine Trabelsi.</h6>
        </div>
    </footer>



<!-- Optional JavaScript -->
    <script src="js/script.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>