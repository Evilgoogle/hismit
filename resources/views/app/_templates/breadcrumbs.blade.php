<div class="breadcrumbs-container">
    <ul class="breadcrumbs">
        <li><a href="/">Главная</a></li>

        @if (isset($breadcrumbs) && !empty($breadcrumbs))
            <?php
            $result = '';
            $breadcrumbs = (array)$breadcrumbs;
            $keys_url = array_keys($breadcrumbs);
            $end_url = end($keys_url);
            foreach ($breadcrumbs as $url => $text) {
                $result .= "<li>";
                $result .= isset($url) && !empty($url) && ($end_url != $url) ? "<a href='". $url ."'>". $text ."</a>" : $text;
                $result .= "</li>";
            }
            ?>

            {!! $result !!}
        @endif
    </ul>
</div>
