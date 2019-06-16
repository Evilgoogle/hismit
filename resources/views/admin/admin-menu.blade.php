<div class="menu">
    <ul class="list">
        <li class="header">ГЛАВНОЕ МЕНЮ</li>
        <li>
            <a href="/admin">
                <i class="material-icons">home</i>
                <span>Home</span>
            </a>
        </li>
        {{--@role('superadmin')
            <li>
                <a href="/admin/access">
                    <i class="material-icons">security</i>
                    <span>Пользователи и роли</span>
                </a>
            </li>
        @endrole--}}
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
                    <a href="/admin/language_interface">Интерфейс</a>
                </li>
            </ul>
        </li>--}}
        <li>
            <a href="/admin/request-call">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Заявки</span>
            </a>
        </li>
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
            <a href="/admin/block">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                <span>Текста</span>
            </a>
        </li>
        <li>
            <a href="/admin/news">
                <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                <span>Новости</span>
            </a>
        </li>
    </ul>
</div>
