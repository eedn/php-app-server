<?php
    // $raw_post_data = file_get_contents('php://input');
    // echo $raw_post_data;

    //POST로 user_id가 없거나 pw나 name이 없을 경우 예외 처리
    if(!isset($_POST['user_id']) || !isset($_POST['pw']) || !isset($_POST['name'])) die("ERROR: user_id, pw, name 중에 하나 이상이 보내지지 않았습니다");

    header('content-type: text/html; charset=utf-8');
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or  
    die( "ERROR: SQL server에 연결할 수 없습니다.");


    mysqli_query($connect,"SET NAMES UTF8");
    // 데이터베이스 선택
    mysqli_select_db($connect,"tennis");

    // 세션 시작
    session_start();

    $id = $_POST['user_id']; //POST 들어온 id,pw,name을 설정
    $pw = $_POST['pw'];
    $name = $_POST['name'];
    
    $sql = "SELECT user_id FROM tennis_user WHERE user_id = '$id'";
    $result = mysqli_query($connect, $sql) or die("ERROR: 에러 발생1");

    $count = mysqli_num_rows($result);

    if($count>=1){ // 아이디 중복 체크
        die("ERROR: 중복된 아이디입니다!");
        exit;
    }

    $sql = "INSERT INTO tennis_user (user_id, pw, name) VALUES ('$id', '$pw', '$name')";
    $result = mysqli_query($connect, $sql) or die("ERROR: 에러 발생2");

    // result of sql query
    if($result)
    {
        echo "1";
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
    }
    else
    {
        die("ERROR: 에러 발생3");
        // echo mysqli_errno($connect);
    }

    mysqli_close($connect);

?>