<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p>{{ $data['name'] }}, Вы добавлены в качестве пользователя сайта <a href="https://b1nk.kz/" target="_blank">b1nk.kz</a></p>
<p>Для того, чтобы зайти на сайт введите в адресной строке b1nk.kz/admin или пройдите по <a href="https://b1nk.kz/admin" target="_blank">ссылке</a></p>
Данные для входа:
<ul>
    <li><b>E-mail:</b> {{ $data['email'] }}</li>
    <li><b>Пароль:</b> {{ $data['password'] }}</li>
</ul>
<b>Внимание: настоятельно рекомендуем выданный пароль в личном кабинете.</b>
</body>
</html>