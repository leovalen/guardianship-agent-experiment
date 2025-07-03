<?php
namespace App\Tools;

use Illuminate\Support\Facades\Log;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Tool;

class GuardianSelectionTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('guardian-selection')
            ->for('Selects a guardian for a user based on their availability and suitability.')
            ->withStringParameter('prompt', 'The relevant information regarding the user to select a guardian for. Must include details such as user_id, application_id, name, age, location, and any specific requirements or preferences for the guardian. Must also include information about why the applicant needs a guardian')
            ->using($this);
    }

    public function __invoke(string $prompt): string
    {
        Log::info('GuardianSelectionTool invoked with prompt: ' . $prompt);

        // Ensure prompt is a clean string
        $cleanPrompt = is_string($prompt) ? trim($prompt) : json_encode($prompt);
        
        if (empty($cleanPrompt)) {
            return json_encode(['error' => 'Empty prompt received']);
        }

        try {
            $response = Prism::text()
                ->using(Provider::OpenAI, 'guardian-selection-agent')
                ->withPrompt($cleanPrompt)
                ->usingProviderConfig(['url' => 'http://host.orb.internal:8080/prism/openai/v1'])
                ->asText();

            return json_encode($response->text);

        } catch (\Exception $e) {
            Log::error('GuardianSelectionTool error: ' . $e->getMessage());
            return json_encode(['error' => 'Selection service unavailable', 'details' => $e->getMessage()]);
        }
    }
}