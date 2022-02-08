<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");
if (!$con) {
    die('Could not connect');
}

mysqli_query($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age) VALUES ('Karina', 'Suwandi', '29')");
mysqli_query($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age) VALUES ('Glenn', 'Gandari', '32')");
mysqli_close($con);
