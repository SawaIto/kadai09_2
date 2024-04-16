<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アンケートフォーム</title>
 <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   </head>
<header class="">
        <?php include 'header.php'; ?>
    </header>
<body class="bg-blue-100">
    <div class="max-w-md mx-auto py-8">
        <h1 class="text-3xl font-bold ms:mt-20 mt-28 mb-8">アンケートフォーム</h1>
        <form id="surveyForm" method="POST" action="insert.php" class="space-y-4">
            <label class="flex flex-col">
                <span>名前:</span>
                <input type="text" name="name" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>
            <label class="flex flex-col">
                <span>メールアドレス:</span>
                <input type="email" name="email" required
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>
            <label class="flex flex-col">
                <span>年齢:</span>
                <select name="age"
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="20～39歳">20～39歳</option>
                    <option value="40～59歳">40～59歳</option>
                    <option value="60歳以上">60歳以上</option>
                </select>
            </label>
            <label class="flex flex-col">
                <span>満足度:</span>
                <select name="satisfaction" id="satisfaction"
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
                <textarea name="naiyou"
                    class="border border-blue-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </label>
            <input type="submit" value="送信"
                class="bg-blue-500 text-white rounded-md px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>
    </div>

    <script>
        function validateForm(event) {
            var form = document.getElementById("surveyForm");
            var inputs = form.getElementsByTagName("input");
            var selects = form.getElementsByTagName("select");
            var isFormValid = true;

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].hasAttribute("required") && !inputs[i].value) {
                    isFormValid = false;
                    break;
                }
            }

            for (var i = 0; i < selects.length; i++) {
                if (selects[i].hasAttribute("required") && !selects[i].value) {
                    isFormValid = false;
                    break;
                }
            }

            if (!isFormValid) {
                alert("すべての項目を入力してください。");
                event.preventDefault(); // デフォルトの動作をキャンセル
            }
        }

        // フォームが送信されたときにバリデーションを実行
        document.getElementById("surveyForm").addEventListener("submit", validateForm);
    </script>
</body>
<footer class="mt-10" >
<?php include 'footer.php'; ?>
</footer>
</html>
