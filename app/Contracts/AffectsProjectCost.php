<?php
namespace App\Contracts;

interface AffectsProjectCost
{
    /**
     * @return array<int>
     */
    public function getProjectId(): array;
}
