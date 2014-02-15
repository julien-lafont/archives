<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>{$rss.nom}</title>
        <link>{$rss.url}</link>
        <description>{$rss.desc}</description>
        {foreach from=$articles item=article}
        <item>
            <guid>{$rss.url}billet-{$article.url_id}-{$article.url_title}.htm</guid>
            <title>{$article.title}</title>
            <link>{$rss.url}billet-{$article.url_id}-{$article.url_title}.htm</link>
            <description>{$article.description}</description>
            <pubDate>{$article.created_on|date_format:"%a, %d %b %Y %H:%M:00 %Z"}</pubDate>
        </item>
        {/foreach}
    </channel>
</rss>