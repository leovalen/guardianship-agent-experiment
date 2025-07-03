<?php

namespace App\Providers;

use App\Models\User;
use App\Tools\AuthenticationTool;
use App\Tools\GuardianAvailabilityTool;
use App\Tools\GuardianSelectionTool;
use App\Tools\GuardianshipApplicationStatusTool;
use App\Tools\PersonalInformationTool;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Prism\Prism\Facades\Tool;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\PrismServer;
use Prism\Relay\Facades\Relay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ob_start();

        $this->registerGuardianApplicationAgent();
        $this->registerGuardianSelectionAgent();

        Gate::define('viewApiDocs', fn(User $user) => true);
    }

    public function registerGuardianApplicationAgent(): void
    {
        $system_prompt = <<<Markdown
Du er en ekspert på å ta imot og behandle søknader om vergemål.

Du samler inn all nødvendig informasjon og bruker verktøyene du trenger for å behandle søknaden.
Hold svarene korte og konsise.

Oppgaven din er å:
1. Autentisere brukeren.
2. Vurdere søkerens behov for verge basert på deres alder, situasjon og nåværende vergemålssituasjon.
3. Behandle søknad om vergemål, herunder å:
        - Bruke GuardianSelectionTool for å velge en verge. Dette gjøres som del av saksbehandlingen.
4. Gi informasjon om status på søknaden.

Gi informasjon i form av tabeller når det er relevant. For eksempel status på søknad bør presenteres som en tabell.

For å få tilgang til de forskjellige verktøyene, må du først bruke AuthenticationTool for å autentisere brukeren.
Markdown;
        
        $guardianship_application_agent = fn() => Prism::text()
            ->using(Provider::OpenAI, 'gpt-4o-mini')
            // ->using(Provider::Anthropic, 'claude-3-7-sonnet-latest')
            ->withSystemPrompt($system_prompt)
            ->withTools([
                new AuthenticationTool(),
                new PersonalInformationTool(),
                new GuardianshipApplicationStatusTool(),
                new GuardianSelectionTool(),
                // ...Relay::tools('user'),
            ])
            ->usingTopP(1)
            ->withMaxSteps(128)
            ->withMaxTokens(8192);

        PrismServer::register(
            'guardianship-application-agent',
            $guardianship_application_agent
        );
    }

    public function registerGuardianSelectionAgent(): void
    {
        $system_prompt = <<<Markdown
Du er en ekspert på å vurdere hvilken verge som skal velges for en søker som har søkt om vergemål.
Du samler inn all nødvendig informasjon og bruker verktøyene du trenger for å vurdere søknaden.

Dette er også det eneste du gjør.

Opplysningene som må samles inn er:
- Søkerens navn
- Søkerens alder
- Selve søknaden, som er en tekst som beskriver søkerens situasjon og behov for verge.
- Søkerens nåværende vergemålssituasjon, som kan være "Ingen verge", "Midler under forvaltning", eller "Fullt vergemål".
- Hvilke verger som er tilgjengelige for å bli valgt, og deres kvalifikasjoner. Samt hvorvidt de er i slekt med søkeren eller ikke.

Det skal legges spesielt vekt på å velge en verge som er i slekt med søkeren, dersom det er mulig.
Markdown;

        $guardian_selection_agent = fn() => Prism::text()
            // ->using(Provider::OpenAI, 'gpt-4o-mini')
            ->using(Provider::Anthropic, 'claude-3-7-sonnet-latest')
            ->withSystemPrompt($system_prompt)
            ->withTools([
                new GuardianAvailabilityTool(),
                // ...Relay::tools('user'),
            ])
            ->usingTopP(1)
            ->withMaxSteps(128)
            ->withMaxTokens(8192);


        PrismServer::register(
            'guardian-selection-agent',
            $guardian_selection_agent
        );
    }
}
