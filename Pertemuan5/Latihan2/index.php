<?php
$a = 123; // variable global
function Test()
{
    global $a; // variable local
    echo "Nilai A dalam fungsi = $a \n";
}
Test();
echo "Nilai A luar fungsi = $a \n";
