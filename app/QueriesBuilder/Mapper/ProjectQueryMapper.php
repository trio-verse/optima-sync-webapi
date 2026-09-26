<?php


namespace App\QueriesBuilder\Mapper;

use App\QueriesBuilder\Dtos\QueryCondition;
use App\QueriesBuilder\Dtos\QueryDefinition;
use App\QueriesBuilder\Dtos\QueryGroup;

class ProjectQueryMapper
{

    public function create(array $data): QueryDefinition
    {
        return new QueryDefinition($this->cearteGroup($data['query']));
    }

    private function cearteGroup(array $data): QueryGroup|QueryCondition
    {
        // array of nodes conditions
        $conditions = [];

        foreach ($data['conditions'] as $condition) {
            $conditions[] = $this->createNode($condition);
        }
        return new QueryGroup(
            $data['logic'],
            $conditions
        );
    }

    // for every one condation scope
    private function createNode(array $data): QueryCondition
    {
        if (isset($data['field'])) {
            // if the data are condition => return new QueryCondition
            return new QueryCondition(
                $data['field'],
                $data['operator'],
                $data['value'],
            );
        }

        // if the data are Group not a condation => recursive call to cearteGroup 
        return $this->cearteGroup($data);
    }
}
