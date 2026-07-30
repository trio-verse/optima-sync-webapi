<?php

namespace App\QueriesBuilder;

use Illuminate\Database\Eloquent\Builder;

class ClientQuery extends Builder
{

    public function industryFilter(?int $industryId)
    {
        return $this->when(
            filled($industryId),
            fn(Builder $query, int $industryId) =>
            $query->where('industry_id', $industryId)
        );
    }

    public function cityFilter(?int $cityId)
    {
        return $this->when(
            filled($cityId),
            fn(Builder $query, int $cityId) =>
            $query->where('city_id', $cityId)
        );
    }
    public function nameFilter(?string $name)
    {
        return $this->when(
            filled($name),
            fn(Builder $query, string $name) =>
            $query->where('name', "%" . $name . "%")
        );
    }

    public function typeFilter(?string $type)
    {
        return $this->when(
            filled($type),
            fn(Builder $query, string $type) =>
            $query->where('type', "%" . $type . "%")
        );
    }

    public function contactInfoFilter(?array $contactInfo)
    {
        return $this->when($contactInfo['search'] ?? null, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->
                    Where('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        });
    }

}