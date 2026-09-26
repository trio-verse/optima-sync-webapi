<?php

namespace App\QueriesBuilder\Registries;

final class ProjectQueryRegistry
{

    public static function fields(): array
    {
        return config('queryBuilderRegistry.projectManagement' , []);
    }
}
