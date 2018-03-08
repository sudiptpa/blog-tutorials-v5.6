<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title>{{ $title }}</title>
    <link>{{ url('/') }}</link>
    <description>
        A short description about your blog.
    </description>
    <language>en-us</language>
    <lastBuildDate>{{ date('c') }}</lastBuildDate>
    @forelse($blogs as $key => $blog)
      <item>
        <title><![CDATA[{{ $blog->name }}]]></title>
        <link>{{ route('app.blog.view', ['slug' => $blog->slug]) }}</link>
        <guid>{{ $blog->guid }}</guid>
        <pubDate>{{ date('c', strtotime($blog->published_at)) }}</pubDate>
        <author>Author Name</author>
        <description><![CDATA[{{ $blog->excerpt }}]]></description>
        <content:encoded>
          <![CDATA[
            @include('partials._rss')
          ]]>
        </content:encoded>
      </item>
    @empty
      <item>No feeds found</item>
    @endforelse
  </channel>
</rss>
