<a href="../Logout"><button>로그아웃</button></a><br/>
<?php

    // 세션 시작
    // session_start(); // include room.php에 session_start() 있음
    include('room.php');

    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    echo "<br/>이름은 {$name}이고 아이디는 {$id}이야.<br/>";
    echo "Room에 온걸 환영해.";

?>
<a href="../CreateRoom"><button>룸생성</button></a><br/>