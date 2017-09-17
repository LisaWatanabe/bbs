    <?php
    // DBの接続
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

// 削除処理
    if(!empty($_GET['type']) && ($_GET['type'] == 'delete')) {
    // $sql = 'DELETE FROM `posts` WHERE `id`='.$_GET['id'];
    // UPDATE文
    $sql = 'UPDATE `posts` SET `delete_flag`=1 WHERE `id`='.$_GET['id'];

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    header('Location: bbs.php');
    exit();
    }



    if (!empty($_POST)) {
      // フォームが送信された時、データを登録したい
    $sql = 'INSERT INTO `posts` SET `nickname`=?,
                                    `comment`=?,
                                    `interestedin`=?,
                                    `created`=NOW()';  //NOW関数と言って現時点の時間を自動に入れてくれる
    $data = array($_POST['nickname'], $_POST['comment'], $_POST['interestedin']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // url直接クリックをコードで
    header('Location: bbs.php');
    exit();
    }



    // SQLの実行（つぶやきの取得）
    // 更新した順に書き換える方法
    // WHERE 1（全件取得）だった条件をdelete_flag=0（0の時だけ）表示する条件に変える
    $sql = 'SELECT * FROM `posts` WHERE `delete_flag`=0 ORDER BY `created` DESC';
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

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i> Oneline bbs</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <!-- Bootstrapのcontainer -->
  <div class="container">
    <!-- Bootstrapのrow -->
    <div class="row">

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <!-- form部分 -->
        <form action="bbs.php" method="post">
          <!-- nickname -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control" id="validate-text" placeholder="nickname" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- comment -->
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- interested in -->
          <div class="form-group">
          Interested In:
          <select name="interestedin" class="form-control">
            <option value="Sports">Sports</option>
            <option value="Laungage">Laungage</option>
            <option value="Outdoor">Outdoor</option>
            <option value="Music">Music</option>
            <option value="Travel">Travel</option>
          </select>
            </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
        </form>
          <!-- google map -->
          <div class="form-group">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.166734193301!2d123.90378091427468!3d10.328538192626404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a99922464c12c7%3A0x985e9365f445190d!2sMooon+Cafe!5e0!3m2!1sja!2sjp!4v1498452954773" width="360" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
      </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">
          <?php for($i=0;$i<$c;$i++) { ?>
            <article class="timeline-entry">
                <div class="timeline-entry-inner">
                    <div class="timeline-icon bg-success">
                        <i class="entypo-feather"></i>
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="timeline-label">
                      <h2><a href="#">
                            <?php echo $posts[$i]['nickname']; ?></a><br>
                            Interested In:<?php echo $posts[$i]['interestedin']?>
                          <span><?php echo $posts[$i]['created']; ?></span></h2>
                        <p><?php echo $posts[$i]['comment']; ?></p>
                     <!-- localhost/oneline_bbs/bbs.php?type=delete&id=10←消したいid番号 -->
                     <!-- idをそれぞれに割り振りたい場合phpを入れ込む -->
                        <p><a href="bbs.php?type=delete&id=<?php echo $posts[$i]['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></p>
                    </div>
                </div>
            </article>
          <?php } ?>

          <article class="timeline-entry begin">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>
              </div>
          </article>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>



