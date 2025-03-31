        <div id="main_img_bar">
            <img src="./img/main_img.png">
        </div>
        <div id="main_content">
            <div id="latest">
                <h4>최근 게시글</h4>
                <ul>
<!-- 최근 게시 글 DB에서 불러오기 -->
<?php
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from board order by num desc limit 5";
    $result = mysqli_query($con, $sql);

    if (!$result)
        echo "게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!";
    else
    {
        while( $row = mysqli_fetch_array($result) )
        {
            $regist_day = substr($row["regist_day"], 0, 10);
            $num = $row["num"];
?>
                <li>
                    <a href="board_view.php?num='<?=$num?> '&page=1">
                        <span><?=$row["subject"]?></span>
                        <span><?=$row["name"]?></span>
                        <span><?=$regist_day?></span>
                    </a>
                </li>
<?php
        }
    }
?>
            </div>
            <!-- 즐겨찾기 기능 -->
            <div id="point_rank">
                <h4>자주가는 사이트</h4>
                <ul>
                    <li><a href="http://www.naver.com">네이버</a></li>
                    <li><a href="http://www.daum.net">다음</a></li>
                    <li><a href="https://github.com/peterchokr">교수님 깃 허브</a></li>
                    <li><a href="https://yportal.ync.ac.kr/login/Login.do">영남이공대학교 종합포털</a></li>
                    <li><a href="https://lms.ync.ac.kr">영남이공대학교 LMS</a></li>                    

<!-- 포인트 랭킹 표시하기 -->
<!-- <?php
    $rank = 1;
    $sql = "select * from members order by point desc limit 5";
    $result = mysqli_query($con, $sql);

    if (!$result)
        echo "회원 DB 테이블(members)이 생성 전이거나 아직 가입된 회원이 없습니다!";
    else
    {
        while( $row = mysqli_fetch_array($result) )
        {
            $name  = $row["name"];        
            $id    = $row["id"];
            $point = $row["point"];
            $name = mb_substr($name, 0, 1)." * ".mb_substr($name, 2, 1);
?>
                <li>
                    <span><?=$rank?></span>
                    <span><?=$name?></span>
                    <span><?=$id?></span>
                    <span><?=$point?></span>
                </li>
<?php
            $rank++;
        }
    }

    mysqli_close($con);
?> -->
                </ul>
            </div>
        </div>