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
                header("location:http://localhost");
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
            header("location:http://localhost");
        }
    ?>

        <div class="position-absolute top-50 start-50 translate-middle">
            <h1>Hoşgeldin <?php echo $_SESSION["kullanici_adi"] ?></h1>
            <h3><a href="?&cikis" class="text-danger">Çıkış</a></h3>
        </div>
    <?php
    }
    ?>

</body>

</html>
