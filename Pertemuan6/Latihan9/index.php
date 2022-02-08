<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");
if (!$con) {
    die('Could not connect');
}

mysqli_query($con, "DELETE FROM tbl_mhs WHERE LastName='Yudhoyono'");
