<?php

namespace App\Models\Traits;

use App\Enums\CurrencyEnum;
use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait WithBaseCurrency
{
    protected function baseCurrency(): Attribute
    {
        return Attribute::make(
            get: fn () => CurrencyEnum::tryFrom(array_search(ExchangeRate::BASE_CURRENCY_VALUE, $this->currency_rates ?? [])),
        );
    }

    public function getCurrencyRate(string $currency): float
    {
        return $this->currency_rates[$currency];
    }

    public function getBaseCurrency(): CurrencyEnum
    {
        $currenyCode = array_search(ExchangeRate::BASE_CURRENCY_VALUE, $this->invoice->currency_rates);

        return CurrencyEnum::tryFrom($currenyCode);
    }

    public function isConvertable(): bool
    {
        return $this->currency->value !== $this->baseCurrency->value;
    }
}
