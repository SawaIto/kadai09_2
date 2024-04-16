<?php
//1.  DB接続します
include("funcs.php");
$pdo = db_conn();


//２．データ登録SQL作成
$sql = "SELECT * FROM sawa_an_table09";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$jason = json_encode($values, JSON_UNESCAPED_UNICODE);
//JSONに値を渡す場合に使う
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/range.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <title>アンケートフォーム</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }

    td {
      border-bottom: 1px solid red;
      padding-left: 5px;
      padding-right: 10px;
      margin-left: 10px;
    }

    th {
      background-color: red;
      color: white;

    }
  </style>

</head>
<header class="">
  <?php include 'header.php'; ?>
</header>

<body id="main">
  <!-- Head[Start] -->
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">データ登録</a>
        </div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->


  <!-- Main[Start] -->
  <div class="flex flex-col md:flex-row justify-center">
    <div class="w-full container jumbotron">
      <table class="ml-8 mt-5">
        <tr>
          <th>ID</th>
          <th>名前</th>
          <th>メールアドレス</th>
          <th>年齢</th>
          <th>満足度</th>
          <th>内容</th>
          <th>登録日時</th>
        </tr>
        <?php foreach($values as $v){ ?>

            <tr>
            <td><?= h($v["id"]) ?> </td>
            <td><?= h($v["name"]) ?> </td>
            <td><?= h($v["email"]) ?> </td>
            <td><?= h($v["age"]) ?> </td>
            <td><?= h($v["satisfaction"]) ?> </td>
            <td><?= h($v["naiyou"]) ?> </td>
            <td><?= h($v["indate"]) ?> </td>
            <td><a href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
            <td><a href="delete.php?id=<?=h($v["id"])?>">削除</a></td>

          </tr>
        <?php } ?>
      </table>
    </div>
    <!-- 満足度で円グラフを作成し表示 -->
    <div class="w-80 mb-8 md:mb-0 md:mr-8 mx-auto">
      <canvas id="satisfactionChart"></canvas>
    </div>
  </div>
  <!-- Main[End] -->

  <script>
// JSONデータを受け取る
const jsonData = <?php echo $jason; ?>;
const satisfactionData = jsonData.map(item => item.satisfaction);
const satisfactionCounts = {};
satisfactionData.forEach(satisfaction => {
  satisfactionCounts[satisfaction] = (satisfactionCounts[satisfaction] || 0) + 1;
});

const chartData = {
  labels: Object.keys(satisfactionCounts),
  datasets: [{
    data: Object.values(satisfactionCounts),
    backgroundColor: [
      '#FF6384',
      '#36A2EB',
      '#FFCE56',
      '#8BC34A',
      '#9C27B0'
    ]
  }]
};

const ctx = document.getElementById('satisfactionChart').getContext('2d');
new Chart(ctx, {
  type: 'pie',
  data: chartData
});
</script>
</body>

</html>