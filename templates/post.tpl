{extends file="layout.tpl"}

{block name="title"}{$post.title} — Mini Blog{/block}

{block name="content"}
    <article>
        {if $post.image}
            <img src="{$post.image}" alt="{$post.title}">
        {/if}

        <h1>{$post.title}</h1>

        <div>
            <time datetime="{$post.published_at}">
                {$post.published_at|date_format:"%B %e, %Y"}
            </time>
            <span>· {$post.views_count} views</span>
        </div>

        {if $post.categories}
            <div>
                Categories:
                {foreach $post.categories as $category}
                    <a href="/category/{$category.id}">{$category.name}</a>{if !$category@last}, {/if}
                {/foreach}
            </div>
        {/if}

        <div>{$post.description}</div>

        <div>{$post.content nofilter}</div>
    </article>

    {if $related}
        <section>
            <h2>Related posts</h2>
            <div>
                {foreach $related as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
