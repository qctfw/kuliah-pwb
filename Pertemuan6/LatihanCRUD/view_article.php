<?php
include "koneksi.php";

$perintah = "SELECT * FROM articles ORDER BY articleID DESC";
$hasil = mysqli_query($connection, $perintah);

echo "<h2>List Artikel</h2>";
echo "<br>";
echo "<ul>";

while ($row = mysqli_fetch_array($hasil)) {
    echo "<li>$row[1] &nbsp;$row[2] &nbsp; $row[waktu] &nbsp;";
    echo "<a href=\"edit_article.php?articleID=$row[0]\">Edit</a>&nbsp";
    echo "<a href=\"delete_article.php?articleID=$row[0]\">Hapus</a></li><br>";
}
echo ("</ul>");
echo "<br><a href=\"add_article.php\">Tambah</a>";
