<?php

namespace App\QueriesBuilder;

use Illuminate\Database\Eloquent\Builder;

class ClientQuery extends Builder
{

    public function industryFilter(?int $industryId)
    {
        return $this->when(
            filled($industryId),
            fn(Builder $query) =>
            $query->where('industry_id', $industryId)
        );
    }

    public function cityFilter(?int $cityId)
    {
        return $this->when(
            filled($cityId),
            fn(Builder $query) =>
            $query->where('city_id', $cityId)
        );
    }
    public function nameFilter(?string $name)
    {
        return $this->when(
            filled($name),
            fn(Builder $query) =>
            $query->where('name', "like", "%{$name}%")
        );
    }

    public function typeFilter(?string $type)
    {
        return $this->when(
            filled($type),
            fn(Builder $query) =>
            $query->where('type', "like", "%{$type}%")
        );
    }

    public function contactInfoFilter(string|null $contactInfo)
    {
        return $this->when(is_string($contactInfo), function (Builder $query) use ($contactInfo) {
            $query->where(function (Builder $query) use ($contactInfo) {
                $query->
                    Where('email', 'like', "%{$contactInfo}%")
                    ->orWhere('phone', 'like', "%{$contactInfo}%")
                    ->orWhere('whatsapp', 'like', "%{$contactInfo}%")
                    ->orWhere('address', 'like', "%{$contactInfo}%");
            });
        });
    }

}