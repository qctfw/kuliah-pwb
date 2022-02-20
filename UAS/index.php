<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Logistik</title>
</head>
<body>
    <h1>DATA LOGISTIK LEMBAR KERJA SISWA (LKS)</h1>
    <p>Programmer: Azhar At Zauhar Dripana</p>

    <p>Menu</p>
    <ul>
        <li><a href="?menu=input">Input Stock</a></li>
        <li><a href="?menu=distribution">Distribusi</a></li>
        <li><a href="?menu=check">Cek Stock</a></li>
    </ul>

    <?php
        if (isset($_GET['menu'])) {
            $menu = $_GET['menu'];
            $url = 'partials/' . $menu . '.php';
            if (file_exists($url)) {
                require_once $url;
                echo <<<JS
                <script>
                    let activeMenu = document.querySelector('a[href="?menu=$menu"]');
                    activeMenu.parentElement.innerHTML = "<b>" + activeMenu.textContent + "</b>";
                    activeMenu.remove();
                </script>
                JS;
            }
            else {
                echo <<<HTML
                <p><b>Menu tidak tersedia</b>. Silahkan pilih menu yang tersedia diatas.</p>
                HTML;
            }
        }
        else {
            echo <<<HTML
            <h2>Silahkan pilih menu diatas.</h2>
            HTML;
        }
    ?>
</body>
</html>