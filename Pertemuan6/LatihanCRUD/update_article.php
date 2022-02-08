<?php
include "koneksi.php";

$time = date("d M Y, H:i");

$update = "UPDATE articles SET judul='$title', penulis='$author', lead='$abstraksi', content='$content', waktu='$time' WHERE articleID ='$ID'";
$hasil = mysqli_query($connection, $update);

if ($hasil) {
    echo "Artikel berhasil di update<br>";
    echo "<a href=\"view_article.php\">List</a>";
} else {
    echo "Artikel gagal di update";
}
