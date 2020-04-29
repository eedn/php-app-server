<?php
    //POST로 user_id가 없거나 pw가 없을 경우 예외 처리
    if(!isset($_POST['user_id']) || !isset($_POST['pw'])) die("user_id, pw가 존재하지 않습니다.");

    header('content-type: text/html; charset=utf-8');
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or  
    die( "SQL server에 연결할 수 없습니다.");


    mysqli_query($connect,"SET NAMES UTF8");
    // 데이터베이스 선택
    mysqli_select_db($connect,"tennis");

    // 세션 시작
    session_start();

    $id = $_POST['user_id']; //POST 들어온 id/pw name으로 설정
    $pw = $_POST['pw'];

    $sql = "SELECT pw, name FROM tennis_user WHERE user_id = '$id'";

    $result = mysqli_query($connect, $sql) or die("에러 발생 1");

    $count = mysqli_num_rows($result);

    if($count==0){
        echo "존재하지 않는 아이디입니다.";
    }
    else if($result) // result of sql query
    {
        $row = mysqli_fetch_array($result) or die("에러 발생 2");
        if(is_null($row['pw']))
        {
            echo "Can not find ID";
        }
        else
        {
            if($row['pw'] == $pw)
            {
                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $row['name'];
                echo $_SESSION['name'];
            }
            else
            {
                echo "비밀번호가 틀렸습니다.";
            }
            
        }
    }
    else
    {
        echo mysqli_errno($connect);
    }

    mysqli_close($connect);

?>