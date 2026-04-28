{extends file="layout.tpl"}

{block name="title"}{$post.title} — Mini Blog{/block}

{block name="content"}
    <article class="post">
        {if $post.image}
            <div class="post__image">
                <img src="{$post.image}" alt="{$post.title}">
            </div>
        {/if}

        <h1 class="post__title">{$post.title}</h1>

        <div class="post__meta">
            <time datetime="{$post.published_at}">
                {$post.published_at|date_format:"%B %e, %Y"}
            </time>
            <span>·</span>
            <span>{$post.views_count} views</span>
        </div>

        {if $post.categories}
            <div class="post__categories">
                <span class="post__categories-label">In:</span>
                {foreach $post.categories as $category}
                    <a href="/category/{$category.id}" class="post__categories-link">{$category.name}</a>
                {/foreach}
            </div>
        {/if}

        <p class="post__description">{$post.description}</p>

        <div class="post__content">{$post.content nofilter}</div>
    </article>

    {if $related}
        <section class="related">
            <h2 class="related__title">Related posts</h2>
            <div class="post-grid">
                {foreach $related as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
