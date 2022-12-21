<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="/make_hash">
        @csrf
        <input type="text" name="password" id="password" placeholder="パスワードを入力">
        <input type="submit" value="生成">
    </form>
    @php
        echo Session::get('message');
    @endphp
</body>
</html>