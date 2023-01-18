<?php 

try{
    $db = new PDO("mysql:host=localhost; dbname=kayit; charset=utf8", 'root','mysql123');
    //echo "Veritanı bağlantısı başarılı";
}
catch(Exception $e)
{
    echo $e->getMessage();
}

?>