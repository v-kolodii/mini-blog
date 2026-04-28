{extends file="layout.tpl"}

{block name="title"}Home — Mini Blog{/block}

{block name="content"}
    {foreach $categories as $category}
        <section>
            <header>
                <h2>{$category.name}</h2>
                <a href="/category/{$category.id}">View all</a>
            </header>

            {if $category.description}
                <p>{$category.description}</p>
            {/if}

            <div>
                {foreach $category.posts as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
