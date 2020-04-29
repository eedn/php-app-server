<a href="../Logout"><button>로그아웃</button></a><br/>
<?php

    // 세션 시작
    session_start();

    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    echo "이름은 {$name}이고 아이디는 {$id}이야.<br/>";

?>
<a href="roomlist.php"><button>룸 목록 보기</button></a><br/>