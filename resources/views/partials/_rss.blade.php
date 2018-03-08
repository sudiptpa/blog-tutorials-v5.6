<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
    <head>
        <meta charset="utf-8">
        <meta property="op:markup_version" content="v1.0">
        <meta property="fb:article_style" content="default"/>
        <link rel="canonical" href="{{ route('app.blog.view', ['slug' => $blog->slug]) }}">
        <title>{{ $blog->name }}</title>
    </head>
    <body>
    <article>
        <header>
            <h1>{{  $blog->name  }}</h1>
            <h2> {{ $blog->excerpt }}</h2>
            <h3 class="op-kicker">
                PHP <!-- Replace with your category name-->
            </h3>
            <address>
                Sujip Thapa <!-- Replace with your author name-->
            </address>
            <time class="op-published" dateTime="$blog->published_at->format('c') }}">{{ $blog->published_at->format('M d Y, h:i a') }}</time>
            <time class="op-modified" dateTime="{{ $blog->updated_at->format('c') }}">{{ $blog->updated_at->format('M d Y, h:i a') }}</time>
        </header>

        {{ $blog->content }}

        <footer>
        <aside>
            A short footer note for your each Instant Articles.
        </aside>
        <small>© Copyright {{ date('Y') }}</small>
        </footer>
    </article>
    </body>
</html>
