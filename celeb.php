    <?php
      // １．データベースに接続する
    $dsn = 'mysql:dbname=phpkiso;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
  // POSTでデータが送信された時のみSQLを実行する
    if (!empty($_POST)) {
      //一件取得するためのフォーム `code`=?,`nickname`=?
    $sql = 'SELECT * FROM `celeb` WHERE `country`=? and
                                        `sex`=?';
    // $data = array($_GET['search_code']);
    $data[] = $_POST['search_country'];
    $data[] = $_POST['search_sex'];

    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);


    $a = array();    // データを取得する
    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      $a[] = $rec;
    }
}
    $c = count($a);
    ?>

      </div>

    <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Crowded</title>

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
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i>Crowded State</span></a>
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
        <form action="celeb.php" method="post">
          <!-- name -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="name" class="form-control" id="validate-text" placeholder="Your Name" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- shop name -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="restaurant" class="form-control" id="validate-text" placeholder="Shop Name" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- where -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="place" class="form-control" id="validate-text" placeholder="Where" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- crowded -->
          <div class="form-group">
            <div class="input-group">
                <select name="crowded" class="form-control" id="validate-text" placeholder="Crowded State" required>
                <option value="●●●">並んでいる●●●</option>
                <option value="●●○">混雑している●●○</option>
                <option value="●○○">空いている●○○</option>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
              </select>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>Input</button>
      </form>
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
                      <h2><a href="#"></a>
                            <?php echo 'Name:  ' . $a[$i]['name']; ?><br>
                            <?php echo 'Gender:  ' . $a[$i]['sex']; ?><br>
                            <?php echo 'Birth Year:  ' . $a[$i]['age']; ?><br>
                          <span><?php echo 'Country:  ' . $a[$i]['country']; ?><br>
                          <?php echo 'Comment:  ' . $a[$i]['comment']; ?></span><br>
                      </h2>
                    </div>
                </div>
            </article>
          <?php }
?>

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



