<?php

namespace CodeFin\Presenters;

use CodeFin\Transformers\BankTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BankPresenter
 *
 * @package namespace CodeFin\Presenters;
 */
class BankPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BankTransformer();
    }
}
