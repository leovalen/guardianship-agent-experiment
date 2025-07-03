<?php
namespace App\Tools;

use Log;
use Prism\Prism\Tool;

class GuardianshipApplicationStatusTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('guardianship-application-status')
            ->for('Provides information about the status of guardianship applications.')
            ->withStringParameter('user_id', 'The id of the user to fetch details for')
            ->using($this);
    }

    public function __invoke(string $user_id): string
    {
         Log::info('GuardianshipApplicationStatusTool invoked with user_id: ' . $user_id);

        return json_encode([
            'application_status' => [
                'application_id' => 1,
                'status' => 'Under behandling',
                'last_updated' => now()->toDateTimeString(),
                'details' => 'Søknaden er under behandling av vergemålsmyndigheten og forventes å være ferdig innen tre dager.',
            ],
        ]);
    }
}