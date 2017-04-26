<?php

namespace CodeFin\Presenters;

use CodeFin\Transformers\StatementTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatementPresenter
 *
 * @package namespace CodeFin\Presenters;
 */
class StatementPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatementTransformer();
    }
}
