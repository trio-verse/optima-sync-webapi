<?php

namespace App\Support\FakePersistence;

use Database\Factories\ProjectCostFactory;
use Database\Factories\ProjectFactory;
use Database\Factories\ProjectFeatureFactory;
use Database\Factories\ProjectVersionFactory;
use Database\Factories\QuotationFactory;

/**
 * Seeds and exposes fake stores for the project management module.
 */
class ProjectModuleFakeStore
{
    private FakeStore $projects;
    private FakeStore $versions;
    private FakeStore $features;
    private FakeStore $costs;
    private FakeStore $quotations;

    public function __construct()
    {
        $this->projects = new FakeStore('projects');
        $this->versions = new FakeStore('project_versions');
        $this->features = new FakeStore('project_features');
        $this->costs = new FakeStore('project_costs');
        $this->quotations = new FakeStore('quotations');

        $this->seed();
    }

    public function projects(): FakeStore
    {
        return $this->projects;
    }

    public function versions(): FakeStore
    {
        return $this->versions;
    }

    public function features(): FakeStore
    {
        return $this->features;
    }

    public function costs(): FakeStore
    {
        return $this->costs;
    }

    public function quotations(): FakeStore
    {
        return $this->quotations;
    }

    private function seed(): void
    {
        $this->projects->seedIfEmpty(fn () => [
            ProjectFactory::dto(1, [
                'reference_id' => 'PRJ-2026-001',
                'status' => 'new',
                'source' => 'internal',
                'sub_total' => '10000.00',
                'profit_percentage' => 20,
                'total_amount' => '12000.00',
                'client' => ['id' => 1, 'name' => 'Acme Ltd', 'email' => 'hello@acme.test'],
                'current_version' => ['id' => 1, 'version_number' => 1, 'title' => 'Initial Version', 'freeze' => false],
            ]),
            ProjectFactory::dto(2, [
                'reference_id' => 'PRJ-2026-002',
                'client_id' => 2,
                'current_version_id' => 2,
                'status' => 'in_progress',
                'source' => 'Client',
                'sub_total' => '18500.00',
                'profit_percentage' => 25,
                'total_amount' => '23125.00',
                'client' => ['id' => 2, 'name' => 'Beta Corp', 'email' => 'ops@beta.test'],
                'current_version' => ['id' => 2, 'version_number' => 2, 'title' => 'Revised Scope', 'freeze' => false],
            ]),
        ]);

        $this->versions->seedIfEmpty(fn () => [
            ProjectVersionFactory::dto(1, 1, [
                'freeze' => true,
                'features_snapshot' => [
                    ['id' => 1, 'name' => 'User Authentication', 'status' => 'completed'],
                ],
                'costs_snapshot' => [
                    ['id' => 1, 'name' => 'Development Hours', 'quantity' => 40, 'amount' => '50.00'],
                ],
                'members_snapshot' => [
                    [
                        'id' => 1,
                        'name' => 'John Doe',
                        'role' => 'frontend developer',
                        'email' => 'john.doe@example.com',
                        'points' => 100,
                        'cost_per_point' => 10.00,
                    ],
                ],
            ]),
            ProjectVersionFactory::dto(2, 1, [
                'version_number' => 2,
                'title' => 'Revised Scope',
                'change_description' => 'Added reporting dashboard',
                'based_on_version_id' => 1,
                'freeze' => false,
            ]),
            ProjectVersionFactory::dto(3, 2, [
                'version_number' => 1,
                'title' => 'Beta Kickoff',
            ]),
        ]);

        $this->features->seedIfEmpty(fn () => [
            ProjectFeatureFactory::dto(1, 1, 1),
            ProjectFeatureFactory::dto(2, 1, 1, [
                'name' => 'Dashboard Analytics',
                'description' => 'Charts and KPI widgets',
                'status' => 'in_progress',
            ]),
            ProjectFeatureFactory::dto(3, 1, 2, [
                'name' => 'Reporting Module',
                'status' => 'new',
            ]),
        ]);

        $this->costs->seedIfEmpty(fn () => [
            ProjectCostFactory::dto(1, 1, 1),
            ProjectCostFactory::dto(2, 1, 1, [
                'name' => 'UI/UX Design',
                'description' => 'Wireframes and high-fidelity screens',
                'quantity' => 20,
                'amount' => '75.00',
            ]),
            ProjectCostFactory::dto(3, 1, 2, [
                'name' => 'Hosting',
                'quantity' => 1,
                'amount' => '200.00',
            ]),
        ]);

        $this->quotations->seedIfEmpty(fn () => [
            QuotationFactory::dto(1, 1),
            QuotationFactory::dto(2, 2, [
                'quotation_number' => 'QTN-202609-0002',
                'subtotal' => '18500.00',
                'discount' => '0.00',
                'tax' => '1850.00',
                'total' => '20350.00',
            ]),
        ]);
    }
}
