{if $paginator->totalPages > 1}
    <nav>
        {if $paginator->hasPrev}
            <a href="{url page=$paginator->currentPage-1}">Previous</a>
        {/if}

        <span>Page {$paginator->currentPage} of {$paginator->totalPages}</span>

        {if $paginator->hasNext}
            <a href="{url page=$paginator->currentPage+1}">Next</a>
        {/if}
    </nav>
{/if}
