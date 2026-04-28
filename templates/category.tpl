{extends file="layout.tpl"}

{block name="title"}{$category.name} — Mini Blog{/block}

{block name="content"}
    <div class="category-page">
        <h1 class="category-page__title">{$category.name}</h1>

        {if $category.description}
            <p class="category-page__description">{$category.description}</p>
        {/if}

        <nav class="category-page__sort">
            <span class="category-page__sort-label">Sort by:</span>
            <a href="{url path="/category/{$category.id}" sort="date" page=1}"
               class="category-page__sort-link {if $current_sort === 'date'}category-page__sort-link--active{/if}">
                Date
            </a>
            <a href="{url path="/category/{$category.id}" sort="views" page=1}"
               class="category-page__sort-link {if $current_sort === 'views'}category-page__sort-link--active{/if}">
                Views
            </a>
        </nav>

        {if $posts}
            <div class="post-grid">
                {foreach $posts as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>

            {include file="partials/pagination.tpl"}
        {else}
            <p class="category-page__empty">No posts in this category yet.</p>
        {/if}
    </div>
{/block}
