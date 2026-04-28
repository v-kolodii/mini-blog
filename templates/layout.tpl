<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{block name="title"}Mini Blog{/block}</title>
</head>
    <body>
        {include file="partials/header.tpl"}

        <main>
            {block name="content"}{/block}
        </main>

        {include file="partials/footer.tpl"}
    </body>
</html>
