<?php

declare(strict_types=1);

namespace App\SmartyPlugin;

use Smarty\Template;

class UrlBuilder
{
    public static function build(array $params, Template $template): string
    {
        $path = $params['path'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        unset($params['path']);

        $query = $_GET;

        foreach ($params as $key => $value) {
            // remove params for first page also
            if ($value === null || $value === '' || ($key === 'page' && (int)$value === 1)) {
                unset($query[$key]);
            } else {
                $query[$key] = $value;
            }
        }

        return $path . (empty($query) ? '' : '?' . http_build_query($query));
    }
}
