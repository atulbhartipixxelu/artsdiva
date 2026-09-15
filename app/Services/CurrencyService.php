<?php

namespace App\Services;

class CurrencyService
{
    public function all(): array
    {
        return config('artsdiva.currencies');
    }

    public function current(): string
    {
        $code = session('currency', config('artsdiva.default_currency'));

        return array_key_exists($code, $this->all())
            ? $code
            : config('artsdiva.default_currency');
    }

    public function set(string $code): void
    {
        if (array_key_exists($code, $this->all())) {
            session(['currency' => $code]);
        }
    }

    public function convertFromEur(float $amountEur, ?string $code = null): float
    {
        $code ??= $this->current();
        $rate = $this->all()[$code]['rate'] ?? 1.0;

        return $amountEur * $rate;
    }

    public function format(float $amountEur, ?string $code = null): string
    {
        $code ??= $this->current();
        $meta = $this->all()[$code];
        $converted = $this->convertFromEur($amountEur, $code);

        $decimals = $code === 'JPY' ? 0 : 0;
        $formatted = number_format($converted, $decimals);

        return $meta['symbol'].$formatted;
    }
}
