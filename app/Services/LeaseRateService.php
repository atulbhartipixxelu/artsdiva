<?php

namespace App\Services;

class LeaseRateService
{
    /**
     * Resolve annual lease percentage for a EUR acquisition value.
     */
    public function rateFor(float $priceEur): array
    {
        foreach (config('artsdiva.lease_tiers') as $tier) {
            if ($tier['max'] === null || $priceEur < $tier['max']) {
                return $tier;
            }
        }

        return ['max' => null, 'rate' => 0.05, 'label' => '5%'];
    }

    public function annualLeaseEur(float $priceEur): float
    {
        $tier = $this->rateFor($priceEur);

        return $priceEur * $tier['rate'];
    }
}
