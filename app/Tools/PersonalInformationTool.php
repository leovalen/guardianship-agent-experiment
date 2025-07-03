<?php
namespace App\Tools;

use Log;
use Prism\Prism\Tool;

class PersonalInformationTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('personal-information-tool')
            ->for('Provides personal information about the currently authenticated user.')
            ->withStringParameter('user_id', 'The id of the user to fetch details for')
            ->using($this);
    }

    public function __invoke(string $user_id): string
    {
        Log::info('PersonalInformationTool invoked with user id: ' . $user_id);

        return json_encode([
                'id' => $user_id,
                'name' => 'Arne Johnsen',
                'email' => 'ajohnsen@example.com',
                'age' => 73,     
        ]);
    }
}