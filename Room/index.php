<?php

    // 세션 시작
    session_start();

    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    echo "이름은 {$name}이고 아이디는 {$id}이야.<br>";
    echo "Room에 온걸 환영해.";

?>