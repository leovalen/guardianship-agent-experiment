<?php

namespace App\Mcp;

use PhpMcp\Server\Attributes\{McpTool};

class UserService
{
    /**
     * Get the current user account.
     */
    #[McpTool(name: 'get_user')]
    public function getUser(): array
    {
        return [
            'id' => 123,
            'email' => 'kari@example.com',
            'name' => 'Kari Kål'
        ];
    }
}