<?php

namespace CodeFin\Transformers;

use Illuminate\Support\Facades\Request;
use League\Fractal\TransformerAbstract;
use CodeFin\Models\Bank;

/**
 * Class BankTransformer
 * @package namespace CodeFin\Transformers;
 */
class BankTransformer extends TransformerAbstract
{

    /**
     * Transform the \Bank entity
     * @param \Bank $model
     *
     * @return array
     */
    public function transform(Bank $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => $model->name,
            'logo'         => $this->makeLogoPath($model),

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    private function makeLogoPath(Bank $model)
    {
        $url = url('/');
        $folder = $model->logosDir;
        return "$url/storage/$folder/{$model->logo}";
    }
}
