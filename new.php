    <?php
      // １．データベースに接続する
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // if文の中に入っていると$seacretが出るときと出ないときとできてしまうからif文から出して定義することで解決
    $seacret = array();
    if (!empty($_POST)) {
      //一件取得するためのフォーム `code`=?,`nickname`=?
    $sql = 'SELECT * FROM `seacret` WHERE `email`= ?';
    // $data = array($_GET['search_code']);
    $data[] = $_POST['search_email'];
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);


    // データを取得する
    while (true) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
        $seacret[] = $rec;
    }
}
    $c = count($seacret);
    ?>

    <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Organaize</title>

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
              <a class="navbar-brand" href="#page-top">
                <span class="strong-title"><i class="fa fa-linux"></i> ID & PASSWORD</span></a>
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
        <form action="new.php" method="POST">
          <!-- search -->
          <div class="form-group">
            <div class="input-group">
                <input type="email" name="search_email" class="form-control" id="validate-text" placeholder="Email" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>Search</button>
        </form>
      </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">
          <form action="risawata.php" method="">
            <button type="submit" class="btn btn-primary col-xs-12">Input</button>
            </form>
          <?php
          for($i=0;$i<$c;$i++) { ?>
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
                          <span><?php echo 'id:  ' . $seacret[$i]['id']; ?><br>
                          <?php echo 'password:  ' . $seacret[$i]['password']; ?></span><br>
                        <?php echo 'detail:  ' . $seacret[$i]['detail']; ?>
                      </h2>
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



