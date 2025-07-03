<?php
namespace App\Tools;

use Log;
use Prism\Prism\Tool;

class GuardianAvailabilityTool extends Tool
{
    public function __construct()
    {
        $this
            ->as('guardian-availability')
            ->for('Provides information about which guardians are available for the specified user id.')
            ->withStringParameter('user_id', 'The id number of the user to fetch available guardians for')
            ->using($this);
    }

    public function __invoke(string $user_id): string
    {
         Log::info('GuardianAvailabilityTool invoked with user id: ' . $user_id);

        return json_encode([
            [
                'id' => 'guardian_001',
                'name' => 'Sarah Johnson',
                'relationship' => 'adult_child',
                'age' => 45,
                'location' => 'Same city',
                'availability' => 'available',
                'experience' => 'Has cared for elderly parent previously',
                'contact_info' => 'sarah.johnson@email.com',
                'background_check' => 'completed',
                'financial_stability' => 'verified',
                'priority_score' => 95
            ],
            [
                'id' => 'guardian_002',
                'name' => 'Michael Thompson',
                'relationship' => 'nephew',
                'age' => 38,
                'location' => 'Within 50 miles',
                'availability' => 'available',
                'experience' => 'Professional caregiver, 10+ years',
                'contact_info' => 'm.thompson@email.com',
                'background_check' => 'completed',
                'financial_stability' => 'verified',
                'priority_score' => 88
            ],
            [
                'id' => 'guardian_003',
                'name' => 'Lisa Martinez',
                'relationship' => 'close_friend',
                'age' => 52,
                'location' => 'Same neighborhood',
                'availability' => 'limited',
                'experience' => 'Volunteer at senior center',
                'contact_info' => 'lisa.martinez@email.com',
                'background_check' => 'in_progress',
                'financial_stability' => 'pending_verification',
                'priority_score' => 72
            ]
        ]);
    }
}