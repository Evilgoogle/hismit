<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
              xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>1.00</priority>
    </url>

    <url>
        <loc>{{ url('company/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>

    <url>
        <loc>{{ url('contacts/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.64</priority>
    </url>

    <url>
        <loc>{{ url('/clinics/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($clinics as $c)
        <url>
            <loc>{{ url('/clinics/'.$c->url) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($c->updated_at)) }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ url('/therapy/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($therapies as $t)
        <url>
            <loc>{{ url('/therapy/'.$t->url) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($t->updated_at)) }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ url('/diagnostics/check-up/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/diagnostics/disease/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($diseases as $d)
        <url>
            <loc>{{ url('/diagnostics/disease/'.$d->url) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($d->updated_at)) }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ url('/discounts/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($discounts as $ds)
        <url>
            <loc>{{ url('/discounts/'.$ds->url) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($ds->updated_at)) }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ url('/news/') }}</loc>
        <lastmod>2019-06-14T11:12:00+06:00</lastmod>
        <priority>0.80</priority>
    </url>
    @foreach($news as $n)
        <url>
            <loc>{{ url('/news/'.$n->url) }}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:sP', strtotime($n->updated_at)) }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

</urlset>
