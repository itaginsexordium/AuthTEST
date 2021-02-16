<?php
include('../DB/DB_Connector.php');
class Check_Auth extends DB_Connector{
    function Check(){
        if (isset($_COOKIE['id'])and isset($_COOKIE['hash'])){
            $this->query="select * from users WHERE  id='".intval($_COOKIE['id'])."'limit 1";
            $this->res=mysqli_query($this->link,$this->query)or die('ошибка запроса в бд'.mysqli_error($this->link));
        $userData=mysqli_fetch_assoc($this->res);
            if(($userData['user_hash'] !== $_COOKIE['hash']) ||
                ($userData['id'] !== $_COOKIE['id'])){

                setcookie("id", "", time() - 3600*24*30*12);

                setcookie("hash", "", time() - 3600*24*30*12);
                echo "Хм, что-то не получилось";
            }else{
                header("location: ../admin.php");
            }
        }else{
            header("location: ../autorization.php");
        }
    }
}




$s=new Check_Auth("localhost","root","root","church_school");
$s->Check();
?>


