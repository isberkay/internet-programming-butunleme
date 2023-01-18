<?php 

ob_start();
session_start();

require 'baglan.php';

if(isset($_POST['kayit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_again = @$_POST['password_again'];
    $md5 = md5($password);
    if(!$username){
        echo "Lütfen kullanıcı adı girin";
    }elseif(!$password || !$password_again){
        echo "Lütfen şifrenizi giriniz";
    }elseif($password != $password_again){
        echo "Girdiğiniz şifreler birbirleriyle aynı değil";
    }
    else{
        //veritabanı kayıt
        $sorgu = $db->prepare('INSERT INTO users SET user_name = ?, user_password = ?');
        $ekle = $sorgu->execute([
            $username, $md5
        ]);
        if($ekle){
            echo "kayıt başarıyla gerçekleşti, yönlendiriliyorsunz";
            header('Refresh:2; login/index.php');
        }else{
            echo "bir hata oluştu";
        }
    }
}

if(isset($_POST['giris'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!$username){
        echo "şifrenizi girin";
    }else{
        $kullanici_sor = $db->prepare('SELECT * FROM users WHERE user_name = ? AND user_password = ?');
        $kullanici_sor ->execute([
            $username, $md5
        ]);

        $say = $kullanici_sor->rowCount();
        if($say==1){
            $_SESSION['username'] = $username;
            echo "başarıyla giriş yaptınız";
            header('Refresh:2; index.php');
        }else{
            echo "bir hata oluştu tekrar deneyin";
        }
    }
}

?>