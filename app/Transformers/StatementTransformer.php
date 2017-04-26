<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\Statement;

/**
 * Class StatementTransformer
 * @package namespace CodeFin\Transformers;
 */
class StatementTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['bankAccount'];

    /**
     * Transform the \Statement entity
     * @param \Statement $model
     *
     * @return array
     */
    public function transform(Statement $model)
    {
        return [
            'id'         => (int) $model->id,
            'date'         => $model->created_at->format('Y-m-d'),
            'value'         => $model->value,
            'balance'         => $model->balance,
            'bank_account_id'         => (int)$model->bank_account_id,
        ];
    }

    public function includeBankAccount(Statement $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
