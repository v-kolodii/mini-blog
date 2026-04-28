<article class="post-card">
    {if $post.image}
        <a href="/post/{$post.id}" class="post-card__image">
            <img src="{$post.image}" alt="{$post.title}">
        </a>
    {/if}

    <h3 class="post-card__title">
        <a href="/post/{$post.id}">{$post.title}</a>
    </h3>

    <div class="post-card__meta">
        <time datetime="{$post.published_at}">
            {$post.published_at|date_format:"%B %e, %Y"}
        </time>
        {if isset($post.views_count)}
            <span>·</span>
            <span>{$post.views_count} views</span>
        {/if}
    </div>

    <p class="post-card__excerpt">{$post.description}</p>

    <a href="/post/{$post.id}" class="post-card__more">Continue reading</a>
</article>
