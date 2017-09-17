    <?php
    // DBの接続
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');



    // SQLの実行（つぶやきの登録）
    var_dump($_POST);
    // empty関数 ()の中に指定した配列が要素を持つかどうか
    // 空ならtrue
    // !emptyは空じゃないとき１を返す
    echo '<br>';
    echo !empty($_POST);

    if (!empty($_POST)) {
      // フォームが送信された時、データを登録したい
    $sql = 'INSERT INTO `posts` SET `nickname`=?,
                                    `comment`=?,
                                    `created`=NOW()';  //NOW関数と言って現時点の時間を自動に入れてくれる
    $data = array($_POST['nickname'], $_POST['comment']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // url直接クリックをコードで
    header('Location: bbs_no_css.php');
    exit();
    }



    // SQLの実行（つぶやきの取得）
    $sql = 'SELECT * FROM `posts` WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // postsデータ全件を格納する配列を空で用意
    $posts = array();

    while (true) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            break;
        }

        // 表示用にposts配列へ入れる
        $posts[] = $record;
    }

    // var_dump($posts);
    $c = count($posts);

    ?>
    <!DOCTYPE html>
    <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>セブ掲示版</title>
    </head>
    <body>
      <form method="post" action=""> <!--自分自身に返したい場合はactionが空でいい-->
        <p><input type="text" name="nickname" placeholder="nickname"></p>
        <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
        <p><button type="submit" >つぶやく</button></p>
      </form>
      <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
      <?php for($i=0;$i<$c;$i++) { ?>
        <!-- 繰り返されるHTMLエリア -->
        <!-- <h1>ほげ</h1> -->
        <p>
          <?php echo $posts[$i]['nickname']; ?><br>
          <span>
            <?php echo $posts[$i]['comment']; ?>
          </span>
        </p>
        <hr>
      <?php } ?>

    </body>
    </html>












