<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Oturum Açma</title>
</head>

<body>
    <?php
    session_start();
    try {

        $_deney = new PDO("mysql:host=localhost;dbname=deney", "root", "");
    } catch (PDOException $e) {
        print $e->getMessage();
    }



    

    if (empty($_SESSION["kullanici_adi"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kullanici_adi = $_POST["kullanici_adi"];
            $sifre = $_POST["sifre"];
            $kullanici_varmi = $_deney->prepare("SELECT * FROM kullanici_ WHERE kullanici_adi=:kullanici_adi &&  sifre=:sifre");
            $kullanici_varmi->execute(array(
                "kullanici_adi" => $kullanici_adi,
                "sifre" => $sifre
            ));

            if ($kullanici_varmi->rowCount() > 0) {
                $kullanici_var = $kullanici_varmi->fetch();
                $_SESSION["kullanici_adi"] = $kullanici_var["kullanici_adi"];
                header("location:http://localhost/insta");
            } else {
                $hata = true;
            }
        }
    ?>
        <form action="" method="post">
            <h1>Giriş</h1>
            <?php
            if (isset($hata)) {
            ?>
                <h4 class="text-center text-danger">Kullanıcı adı ve şifre uyuşmadı</h4>
            <?php
            }
            ?>
            <input type="text" name="kullanici_adi" placeholder="Kullanıcı adı">
            <input type="password" name="sifre" placeholder="Şifre">
            <button type="submit">Giriş</button>
        </form>
    <?php

    } else {

        if (isset($_GET["cikis"])) {
            session_destroy();
            header("location:http://localhost/insta");
        }
    ?>

        <div class="position-absolute top-50 start-50 translate-middle">
            <h1>Hoşgeldin <?php echo $_SESSION["kullanici_adi"] ?></h1>
            <h3><a href="?&cikis" class="text-danger">Çıkış</a></h3>
        </div>
    <?php
    }
    ?>


    <style>
        body {
            background: #231412;
            color: #ffffff;
            position: relative;
            height: 100vh;
            padding: 0%;
            margin: 0%;
        }

        form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #352320;
            padding: 2rem;
            width: 25rem;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;

        }

        input {
            flex: 0 0 auto;
            background: #D27E01;
            color: #ffffff;
            font-size: 1.2rem;
            border-radius: .5rem;
            padding: 1rem 1rem;
            margin: .5rem 0;
            border: none;
            outline: none;
        }

        input::placeholder {
            color: white;
        }

        button {
            flex: 0 0 auto;
            background: #F59A04;
            color: #ffffff;
            border: none;
            border-radius: 2rem;
            font-size: 2rem;
            margin-top: 1rem;
            padding: .5rem;
        }

        h1 {
            font-size: 4rem;
            line-height: 100%;
            text-align: center;
            margin: 0%;
            padding-bottom: 1rem;
        }

        .modalbtn {
            display: none;
        }
    </style>

    <?php if (empty($_SESSION["kullanici_adi"])) {
    ?>
        <button type="button" class="modalbtn" data-bs-toggle="modal" data-bs-target="#bilgilendirme">
        </button>

        <div class="modal fade " id="bilgilendirme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Giriş Bilgisi</h5>
                    </div>
                    <div class="modal-body">
                        <div>
                            Kullanıcı Adı : Mustafa
                        </div>
                        <div>
                            Şifre : 12345
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Devam</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $(".modalbtn").click();
            $(".modalbtn").remove();
        });
    </script>
</body>

</html>