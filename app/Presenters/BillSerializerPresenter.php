<?php

namespace CodeFin\Presenters;

use CodeFin\Serializer\BillSerializer;
use CodeFin\Transformers\BillSerializerTransformer;
use CodeFin\Transformers\BillTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillPayPresenter
 *
 * @package namespace CodeFin\Presenters;
 */
class BillSerializerPresenter extends FractalPresenter
{
    /**
     * @var BillPresenter
     */
    private $presenter;

    /**
     * BillPaySerializerPresenter constructor.
     * @param BillPresenter $presenter
     */
    public function __construct(BillPresenter $presenter)
    {
        parent::__construct();
        $this->presenter = $presenter;
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillSerializerTransformer($this->presenter);
    }
}
