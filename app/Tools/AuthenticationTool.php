<?php
namespace App\Tools;

use Log;
use Prism\Prism\Tool;

class AuthenticationTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('authentication-tool')
            ->for('Authenticates a user and provides their user ID')
            ->using($this);
    }

    public function __invoke(): string
    {
        Log::info('Authenication tool invoked');

        return json_encode([
                'user_id' => 1,
        ]);
    }
}