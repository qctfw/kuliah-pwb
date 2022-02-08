<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

$hasil = mysqli_query($con, "select * from tbl_mhs");
while ($data = mysqli_fetch_row($hasil)) {
    echo "$data[0] $data[1] $data[2]<br>";
}
