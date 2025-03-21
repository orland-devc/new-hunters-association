<?php

namespace App\Models\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait JournalAble
{
    public string $journalChartOfAccount = 'A1001';

    public string $journalType = 'debit';

    public string $journalValue = 'total';

    /**
     * Get the chart of account to be used.
     * Reference App\Models\ChartOfAccount::class in account_id column.
     * Default is `A1001` which is "Current Assets".
     */
    public function getJournalChartOfAccount(): ?string
    {
        return $this->journalChartOfAccount;
    }

    public function setJournalChartOfAccount($value): self
    {
        $this->journalChartOfAccount = $value;

        return $this;
    }

    /**
     * Journl entry either Debit or Credit.
     */
    public function getJournalType(): ?string
    {
        return $this->journalType;
    }

    public function setJournalType($value): self
    {
        $this->journalType = $value;

        return $this;
    }

    /**
     * Overwrite this to get human-readable description.
     */
    public function getJournalDescription(): string
    {
        return '';
    }

    /**
     * Overwrite this to get reference number
     * e.g. invoice number, payment reference, etc.
     */
    public function getJournalReference(): string
    {
        return '';
    }

    /**
     * Value to be used in the journal entry with
     * referent to $this->getJournalType() [ debit | credit ]
     */
    public function getJournalValue(): float|\Brick\Money\Money|int
    {
        $amount = $this->{$this->journalValue} ?? 0;

        return $amount;
    }

    public function setJournalValue($value): self
    {
        $this->journalValue = $value;

        return $this;
    }

    /**
     * Model should have belong to a company.
     */
    public function getJournalCompany(): Company
    {
        return $this->company;
    }

    /**
     * Helper method to get Journal Entry Payload
     */
    protected function journalEntryPayload(): Attribute
    {
        return Attribute::make(fn () => [
            'company_id' => $this->getJournalCompany()->id,
            'chart_of_account' => $this->getJournalChartOfAccount(),
            $this->getJournalType() => $this->getJournalValue(),
            'credit' => $this->getJournalCredit(),
            'description' => $this->getJournalDescription(),
            'reference' => $this->getJournalReference(),
        ]);
    }
}
