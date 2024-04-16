<?php
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。

$id = $_GET["id"];
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM sawa_an_table09 WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v  =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
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
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
<body class="bg-blue-100">
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-3xl font-bold ms:mt-20 mt-10 mb-8">アンケート更新</h1>
        <form id="surveyForm" method="POST" action="insert.php" class="space-y-4">
            <label class="flex flex-col">
                <span>名前:</span>
                <input type="text" name="name"  value="<?=$v["name"]?>" required 
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>
            <label class="flex flex-col">
                <span>メールアドレス:</span>
                <input type="email" name="email" value="<?=$v["email"]?>" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>
            <label class="flex flex-col">
                <span>年齢:</span>
                <select name="age" id="age" value="<?=$v["age"]?>" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="20～39歳">20～39歳</option>
                    <option value="40～59歳">40～59歳</option>
                    <option value="60歳以上">60歳以上</option>

                </select>
            </label>
            <label class="flex flex-col">
                <span>満足度:</span>
                <select id="satisfaction" name="satisfaction" value="<?=$v["satisfaction"]?>" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">選択してください</option>
                    <option value="5">5 (大変満足)</option>
                    <option value="4">4 (満足)</option>
                    <option value="3">3 (普通)</option>
                    <option value="2">2 (やや不満)</option>
                    <option value="1">1 (不満足)</option>
                </select>
            </label>
            <label class="flex flex-col">
                <span>コメント:</span>
                <textarea name="naiyou" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?=$v["naiyou"]?></textarea>
            </label>
            <input type="hidden" name="id" value="<?=$v["id"]?>" >
            <input type="submit" value="送信"
                class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>
    </div>

<!-- Main[End] -->

<script>
    // 特定のIDに基づいてselect要素を選択
    var ageValue = "<?=$v["age"]?>"; // PHPで取得した年齢の値を設定
    // 年齢の値に基づいて選択を設定
    document.getElementById('age').value = ageValue;

    // 特定のIDに基づいてselect要素を選択
    var satisfactionValue = "<?=$v["satisfaction"]?>"; // PHPで取得した満足度の値を設定
    // 年齢の値に基づいて選択を設定
    document.getElementById('satisfaction').value = satisfactionValue;

</script>

</body>
</html>



