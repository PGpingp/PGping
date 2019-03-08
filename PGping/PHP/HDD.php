<?php

if ($_GET['id'] != ''){
    $puntero = fopen('HardDiskSerial.txt', 'r');
    while(!feof($puntero)){
        $base = explode('|', fgets($puntero));
        if($base[0] == $_GET['id']){
            fclose($puntero);
            $checksum = 0;
            for ($i=24; $i<35; $i++) {
                $checksum += $_GET['id'] * $i;
            }
            echo 'OK|'.$base[1].'|'.$checksum;
            exit;
        }
    }
    fclose($puntero);
    echo "<error>비정상적인 접근입니다.</error>";
}else{
    echo "<error>비정상적인 접근입니다.</error>";
}

?>