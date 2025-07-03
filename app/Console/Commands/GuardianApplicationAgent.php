<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Prism\Relay\Facades\Relay;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Text\PendingRequest;

use function Laravel\Prompts\note;
use function Laravel\Prompts\textarea;

class GuardianApplicationAgent extends Command
{
    protected $signature = 'agent:guardian-application';

    public function handle()
    {
        $response = $this->agent(textarea('Prompt'))->asText();

        note($response->text);
    }

    protected function agent(string $prompt): PendingRequest
    {
        $system_prompt = 'Du er en ekspert på å ta imot og behandle søknader om vergemål. Du samler inn all nødvendig informasjon og bruker verktøyene du trenger for å behandle søknaden.';

        return Prism::text()
            ->using(Provider::Anthropic, 'claude-3-7-sonnet-latest')
            ->withSystemPrompt($system_prompt)
            ->withPrompt($prompt)
            ->withTools([
                ...Relay::tools('puppeteer'),
            ])
            ->usingTopP(1)
            ->withMaxSteps(99)
            ->withMaxTokens(8192);
    }
}