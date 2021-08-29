<div class="menu">
    <ul class="list">
        <li class="header">ГЛАВНОЕ МЕНЮ</li>
        <li>
            <a href="/admin">
                <i class="material-icons">home</i>
                <span>Home</span>
            </a>
        </li>
        @role('admin')
            <li>
                <a href="/admin/users">
                    <i class="material-icons">people</i>
                    <span>Пользователи</span>
                </a>
            </li>
            <li>
                <a href="/admin/roles">
                    <i class="material-icons">security</i>
                    <span>Роли</span>
                </a>
            </li>
        @endrole
        {{--<li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="fa fa-language" aria-hidden="true"></i>
                <span>Мультиязычность</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="/admin/language">Доступные языки</a>
                </li>
                <li>
                    <a href="/admin/language-interface">Интерфейс</a>
                </li>
            </ul>
        </li>--}}
        <li>
            <a href="/admin/seo">
                <i class="material-icons">trending_up</i>
                <span>SEO</span>
            </a>
        </li>
        <li>
            <a href="/admin/config">
                <i class="material-icons">settings</i>
                <span>Конфиг</span>
            </a>
        </li>
        <li>
            <a href="/admin/news">
                <i class="material-icons">content_copy</i>
                <span>Новости</span>
            </a>
        </li>
        <li>
            <a href="/admin/logs">
                <i class="material-icons">date_range</i>
                <span>Логи</span>
            </a>
        </li>
    </ul>
</div>
