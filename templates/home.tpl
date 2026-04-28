{extends file="layout.tpl"}

{block name="title"}Home — Mini Blog{/block}

{block name="content"}
    {foreach $categories as $category}
        <section class="category-section">
            <header class="category-section__header">
                <h2 class="category-section__title">{$category.name}</h2>
                <a href="/category/{$category.id}" class="category-section__link">View all</a>
            </header>

            {if $category.description}
                <p class="category-section__description">{$category.description}</p>
            {/if}

            <div class="post-grid">
                {foreach $category.posts as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
