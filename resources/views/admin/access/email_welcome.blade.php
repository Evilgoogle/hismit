<p>{{ $data['name'] }}, Вам предоставлен доступ на сайт <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a></p>
<p>Для того, чтобы зайти на сайт введите в адресной строке {{ url('/admin') }} или пройдите по <a href="{{ url('/admin') }}" target="_blank">ссылке</a></p>
Данные для входа:
<ul>
    <li><b>E-mail:</b> {{ $data['email'] }}</li>
    <li><b>Пароль:</b> {{ $data['password'] }}</li>
</ul>
