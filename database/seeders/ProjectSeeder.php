<?php

namespace Database\Seeders;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Models\Client;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::all();
        $clients = Client::all();
        $users = User::all();

        if ($organizations->isEmpty() || $clients->isEmpty() || $users->isEmpty()) {
            $this->call([
                OrganizationSeeder::class,
                ClientSeeder::class,
                UserSeeder::class,
            ]);

            $organizations = Organization::all();
            $clients = Client::all();
            $users = User::all();
        }

        foreach (range(1, 50) as $i) {
            $client = $clients->random();
            $organization = $client->organization;
            $creator = $users->random();

            $subTotal = fake()->randomFloat(2, 5000, 100000);
            $profitPercentage = fake()->numberBetween(10, 30);
            $totalAmount = round($subTotal * (1 + $profitPercentage / 100), 2);

            $project = null;
            Project::withoutEvents(function () use ($organization, $client, $creator, $subTotal, $profitPercentage, $totalAmount, &$project) {
                $referenceId = 'PRJ-' . str_pad(Project::max('id') + 1, 4, '0', STR_PAD_LEFT);

                $project = Project::create([
                    'organization_id' => $organization->id,
                    'client_id' => $client->id,
                    'status' => fake()->randomElement(collect(enProjectStatus::cases())->map->value->toArray()),
                    'source' => fake()->randomElement(collect(enProjectSource::cases())->map->value->toArray()),
                    'created_by' => $creator->id,
                    'sub_total' => $subTotal,
                    'profit_percentage' => $profitPercentage,
                    'total_amount' => $totalAmount,
                    'discount' => fake()->randomFloat(2, 0, 5000),
                    'tax' => fake()->randomFloat(2, 0, 5000),
                    'issue_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                    'valid_until' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                    'payment_terms' => fake()->randomElement(['net_30', 'net_60', 'net_90', 'due_on_receipt']),
                    'reference_id' => $referenceId,
                ]);
            });

            $version = ProjectVersion::create([
                'project_id' => $project->id,
                'version_number' => 1,
                'title' => fake()->sentence(3),
                'description' => fake()->paragraph(),
                'start_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'end_date' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
                'duration' => fake()->randomElement(['1 month', '2 months', '3 months', '6 months']),
                'freeze' => fake()->boolean(30),
                'created_by' => $creator->id,
            ]);

            $project->update(['current_version_id' => $version->id]);
        }
    }
}
