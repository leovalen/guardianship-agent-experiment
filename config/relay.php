<?php

declare(strict_types=1);

use Prism\Relay\Enums\Transport;

return [
    /*
    |--------------------------------------------------------------------------
    | MCP Server Configurations
    |--------------------------------------------------------------------------
    |
    | Define your MCP server configurations here. Each server should have a
    | name as the key, and a configuration array with the appropriate settings.
    |
    */
    'servers' => [
        'user' => [
            'command' => [
                'php /var/www/html/artisan mcp:serve --transport=stdio',
            ],
            'transport' => Transport::Stdio,
            'timeout' => 30,
            'env' => [],
        ],

        /*
        'user' => [
            'url' => 'http://host.orb.internal:8080/mcp',
            'transport' => Transport::Http,
            'timeout' => 30,
            'env' => [],
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Tool Definition Cache Duration
    |--------------------------------------------------------------------------
    |
    | This value determines how long (in minutes) the tool definitions fetched
    | from MCP servers will be cached. Set to 0 to disable caching entirely.
    |
    */
    'cache_duration' => env('RELAY_TOOLS_CACHE_DURATION', 60),
];
