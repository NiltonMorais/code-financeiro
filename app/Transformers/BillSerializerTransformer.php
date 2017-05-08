<?php

namespace CodeFin\Transformers;

use CodeFin\Models\AbstractBill;
use CodeFin\Serializer\BillSerializer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Contracts\PresenterInterface;

/**
 * Class BillPayTransformer
 * @package namespace CodeFin\Transformers;
 */
class BillSerializerTransformer extends TransformerAbstract
{
    /**
     * @var PresenterInterface
     */
    private $presenter;

    /**
     * BillSerializerTransformer constructor.
     * @param PresenterInterface $presenter
     */
    public function __construct(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * @param BillSerializer $serializer
     * @return array
     */
    public function transform(BillSerializer $serializer)
    {
        return [
            'bills' => $this->presenter->present($serializer->getBills()),
            'bill_data' => $serializer->getBillData()
        ];
    }
}
