    <?php
    // DBの接続
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

     if (!empty($_GET['type']) && ($_GET['type'] == 'delete')) {
    // $sql = 'DELETE FROM `posts` WHERE `id`='.$_GET['id'];
    // UPDATE文
    $sql = 'UPDATE `seacret` SET `delete_flag`=1 WHERE `code`='.$_GET['code'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    header('Location: risawata.php');
    exit();
    }

    if (!empty($_POST)) {
      // フォームが送信された時、データを登録したい
       $sql = 'INSERT INTO `seacret` SET `name`=?,
                                    `website`  =?,
                                    `email`    =?,
                                    `id`       =?,
                                    `password` =?,
                                    `detail`   =?';  //NOW関数と言って現時点の時間を自動に入れてくれる
    $data = array($_POST['name'], $_POST['website'], $_POST['email'], $_POST['id'], $_POST['password'], $_POST['detail']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // url直接クリックをコードで
    header('Location: risawata.php');
    exit();
    }



    // SQLの実行（つぶやきの取得）
    // 更新した順に書き換える方法
    $sql = 'SELECT * FROM `seacret` WHERE `delete_flag`=0 ORDER BY `code` DESC';
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
  <meta charset="UTF-8">
  <title>管理</title>

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
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i> ID & PASSWORD</span></a>
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
        <form action="risawata.php" method="post">
          <!-- name -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" id="validate-text" placeholder="name" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- website -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="website" class="form-control" id="validate-text" placeholder="website" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- email -->
          <div class="form-group">
            <div class="input-group">
              <input type="email" name="email" class="form-control" id="validate-text" placeholder="email" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- id -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="id" class="form-control" id="validate-text" placeholder="id" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- password -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="password" class="form-control" id="validate-text" placeholder="password" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- detail -->
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="detail" id="validate-length" placeholder="detail" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>Input</button>
      </form>
    </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">
               <form action="new.php" method="">
            <button type="submit" class="btn btn-primary col-xs-12">Search</button>
            </form>
          <?php for($i=0;$i<$c;$i++) { ?>
            <article class="timeline-entry">
                <div class="timeline-entry-inner">
                    <div class="timeline-icon bg-success">
                        <i class="entypo-feather"></i>
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="timeline-label">
                      <h2><a href="#"></a>
                            <?php echo 'Name:  ' . $seacret[$i]['name']; ?><br>
                            <?php echo 'Web site:  ' . $seacret[$i]['website']; ?><br>
                            <?php echo 'Email:  ' . $seacret[$i]['email']; ?><br>
                          <span><?php echo 'ID:  ' . $seacret[$i]['id']; ?><br>
                          <?php echo 'password:  ' . $seacret[$i]['password']; ?></span></h2>
                        <?php echo 'detail:  ' . $seacret[$i]['detail']; ?><br>
                        <p><a href="risawata.php?type=delete&code=<?php echo $seacret[$i]['code'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></p>

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



