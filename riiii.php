    <?php
    // DBの接続
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    if (!empty($_POST)) {
      // フォームが送信された時、データを登録したい
    $sql = 'INSERT INTO `seacret` SET `website`=?,
                                    `email`=?,
                                    `id`=?,
                                    `password`=?,
                                    `detail`=?';  //NOW関数と言って現時点の時間を自動に入れてくれる
    $data = array($_POST['website'],$_POST['email'], $_POST['id'], $_POST['password'], $_POST['detail']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // url直接クリックをコードで
    header('Location: riiii.php');
    exit();
    }



    // SQLの実行（つぶやきの取得）
    // 更新した順に書き換える方法
    $sql = 'SELECT * FROM `seacret` WHERE 1 ORDER BY `code` DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // postsデータ全件を格納する配列を空で用意
    $seacret = array();

    while (true) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            break;
        }

        // 表示用にposts配列へ入れる
        $seacret[] = $record;
    }

    // var_dump($seacret);
    $c = count($seacret);

    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

<form action="riiii.php" method="post">
          <h1>Organize</h1>
          <p>Website
          <input type="text" name="website"></p>
          <p>Email
          <input type="email" name="email"></p>
          <p>ID
          <input type="text" name="id"></p>
          <p>Password
          <input type="text" name="password"></p>
          <p>Details
          <textarea name="detail" cols="40" rows="5"></textarea>
          </p>
          <button type="submit">Post!</button>
          <hr>


    <?php for($i=0;$i<$c;$i++) { ?>
        <p>
          <?php echo $seacret[$i]['website']; ?><br>
          <span>
            <?php echo $seacret[$i]['email']; ?>
            <?php echo $seacret[$i]['id']; ?>
            <?php echo $seacret[$i]['password']; ?>
            <?php echo $seacret[$i]['detail']; ?>

          </span>
        </p>
        <hr>
    <?php } ?>

    </form>
</body>
</html>