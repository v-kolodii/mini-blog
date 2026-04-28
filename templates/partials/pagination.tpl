{if $paginator->totalPages > 1}
    <nav class="pagination">
        {if $paginator->hasPrev}
            <a href="{url page=$paginator->currentPage-1}" class="pagination__link">Previous</a>
        {/if}

        <span class="pagination__info">
            Page {$paginator->currentPage} of {$paginator->totalPages}
        </span>

        {if $paginator->hasNext}
            <a href="{url page=$paginator->currentPage+1}" class="pagination__link">Next</a>
        {/if}
    </nav>
{/if}
