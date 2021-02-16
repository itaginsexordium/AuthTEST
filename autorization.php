<?


# генерация токена
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}



# Соединямся с БД
$link=mysqli_connect("localhost", "root", "root","church_school");


if(isset($_POST['submit']))
{

    # Вытаскиваем  запись, у которой логин равняеться введенному
    $querry="SELECT id, password_ FROM users WHERE username='".($_POST['login'])."' LIMIT 1";
    $query = mysqli_query($link,$querry)or die("ошибка".mysqli_error($link));

    $data = $query->fetch_assoc();



    # Сравниваем пароли
    if($data['password_'] === ($_POST['password']))
    {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));






        # Записываем в БД новый хеш  авторизации
        mysqli_query($link,"UPDATE users SET user_hash='".$hash."' WHERE id='".$data['id']."'");
        # Ставим куки
        setcookie("id", $data['id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);



        # Переадресовываем на страницу проверки нашего скрипта
        header("Location: Check_Auth.php"); exit();
    }
    else
    {
        echo "Вы ввели неправильный логин/пароль";
    }
}

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/AdminInPutStyles.css">
    <title>CMS</title>
</head>
<body>
<div id="admin_wrapper">
    <div id="admin_panel">
        <div id="label">
            Логин/Пароль
        </div>
        <form action="" method="post" >
            <input id="item" type="text" name="login">
            <input id="item" type="text" name="password">
            <input id="btn" name="submit" type="submit" value="Войти">
        </form>
    </div>

</div>


</body>
</html>

