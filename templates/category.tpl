{extends file="layout.tpl"}

{block name="title"}{$category.name} — Mini Blog{/block}

{block name="content"}
    <h1>{$category.name}</h1>

    {if $category.description}
        <p>{$category.description}</p>
    {/if}

    <nav>
        Sort by:
        <a href="{url path="/category/{$category.id}" sort="date" page=1}"
           {if $current_sort === 'date'} style="font-weight:bold" aria-current="true" {/if}>
            Date
        </a>
        |
        <a href="{url path="/category/{$category.id}" sort="views" page=1}"
           {if $current_sort === 'views'} style="font-weight:bold" aria-current="true" {/if}>
            Views
        </a>
    </nav>

    {if $posts}
        <div>
            {foreach $posts as $post}
                {include file="partials/post-card.tpl" post=$post}
            {/foreach}
        </div>

        {include file="partials/pagination.tpl"}
    {else}
        <p>No posts in this category yet.</p>
    {/if}
{/block}
