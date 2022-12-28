<?php
$bdhost = 'localhost';

$bdname = '';
$bduser = 'root';
$bdpass = '';

$connection = new mysqli($bdhost, $bduser, $bdpass, $bdname);
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS sportsmeny (fio VARCHAR(16), e_mail VARCHAR(16), tel INT(11), data_rozhdeniya VARCHAR(16), vozrast INT(2), data_i_vermia_registr DATETIME, nomer_pasporta INT(4), sred_mesto INT(10), biografia TEXT, videoprezent LONGBLOB)");
echo "Всё ок!";
?>
