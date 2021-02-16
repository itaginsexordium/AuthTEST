
<?php
include ('/DB/DB_Connector.php');
class Auth_adminNOTWORK extends DB_Connector{
    public function authAdmin($login,$password){
        if (isset($_POST['submit'])){
            # Вытаскиваем  запись, у которой логин равняеться введенному
        $this->query="select * from users u where username='$login' and password_='$password';";
        $ress=mysqli_query($this->link,$this->query)or die('ошибка запроса в бд'.mysqli_error($this->link));
        $this->res=mysqli_fetch_assoc($ress);
            # Сравниваем пароли
        if ($this->res['password_']===$_POST['password']){
        $hash=md5($this->generateCode(10));
            # Записываем в БД новый хеш  авторизации
        mysqli_query($this->link,"update users set user_hash='".$hash."' where id='".$this->res['id']."' ");
        #ERROR O KURWA
        setcookie("id",$this->res['id'],time()+60*60*24*30);
        setcookie("hash",$hash,time()+60*60*24*30);
            # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: Check_Auth.php");exit();
        }else{
            echo "неправильный логин или пароль";
            }
        }
    }



    #случайная строка для токена
    function generateCode($length=6){
        $words="abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code="";
        $clen= strlen($words)-1;
        while (strlen($code)<$length){
            $code.=$words[mt_rand(0,$clen)];
        }
        return $code;
    }

}



$auth=new Auth_adminNOTWORK("localhost","root","root","church_school");
$auth->authAdmin($_POST['login'],$_POST['password']);
?>


