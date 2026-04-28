<article>
    {if $post.image}
        <a href="/post/{$post.id}">
            <img src="{$post.image}" alt="{$post.title}">
        </a>
    {/if}

    <h3><a href="/post/{$post.id}">{$post.title}</a></h3>

    <time datetime="{$post.published_at}">
        {$post.published_at|date_format:"%B %e, %Y"}
    </time>

    <p>{$post.description}</p>

    <a href="/post/{$post.id}">Continue reading</a>
</article>
