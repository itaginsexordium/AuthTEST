<?php


class DB_Connector

{

    protected $servername;
    protected $username;
    protected $password;
    protected $database;
    protected $link;


    protected $query;
    protected $res;


    public function __construct($servername, $username, $password, $database)
    {
        $this->link = mysqli_connect($this->servername = $servername,
            $this->username = $username,
            $this->password = $password,
            $this->database = $database
        ) or die ("Ошибка:  " . mysqli_error($this->link));
    }


}


?>