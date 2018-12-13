<?php
$flag = 'gxnnctf{***************************}';
require_once('config.php');
$conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
if($conn->connect_error){
    die("Connect failed:".$conn->connect_error);
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(preg_match('#sleep|benchmark|floor|rand|count|select|from|\(|\)|time|date|sec|day#is',$id))
        die('Don\'t hurt me :-(');
    $sql = "select username from user where id = ".$id;
    $result = $conn->query($sql);
    if($result){
        $row = $result->fetch_array();
    }else{
        echo mysqli_error($conn);
        die();
    }
    echo('hello '.$row['username'].'<br>');
    $username = $row['username'];
    if($username === 'guest'){
        $ip = @$_SERVER['HTTP_X_FORWARDED_FOR']!="" ? $_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
        if(preg_match('#sleep|benchmark|floor|rand|count|select|from|\(|\)|time|date|sec|day#is',$ip)){
            die('Don\' hack me');
        }
        if(!empty($ip)){
            echo 'you from '.$ip.' , I remembered it.<br>';
            $conn->query("insert into logs(ip) values('$ip')");
        }
        $result = $conn->query("select username from user where id =".$id);
        $row = $result->fetch_array();
        $username = $row['username'];
        if($username === 'admin'){
            var_dump($_GET['backdoor']);
            if(isset($_GET['backdoor'])&&$_GET['backdoor']==='Melonrind'){
                echo 'you find the backdoor!!!<br>';
                die($flag);
            }else{
                echo "you are so great,but you don\'t have backdoor,so continue to challenge :(";
            }
        }else{
            echo "but i don\'t waiting for you ";
        }
    }else{
        echo 'emmmmm';
    }
}else{
    echo 'welcome to gxnnctf2018!<br>';
    echo 'i filtered everything,so have a good time :)';
}


