<a href="../Logout"><button>로그아웃</button></a><br/>
<?php

    // 세션 시작
    // session_start(); //include roomlist.php 에도 session_start 있음
    include('roomlist.php');

    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    echo "<br/><br/>이름은 {$name}이고 아이디는 {$id}이야.<br/>";

?>

<form method='post' action='../Room/'>
    room_id 입력 : <input type='text' name='room_id'/> <input type='submit' value='room 입장'/>
</form>