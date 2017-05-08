<?php

namespace CodeFin\Serializer;

use Illuminate\Contracts\Support\Jsonable;

class BillSerializer implements Jsonable
{
    /**
     * @var
     */
    private $bills;
    /**
     * @var
     */
    private $billData;

    /**
     * BillSerializer constructor.
     * @param $bills
     * @param $billData
     */
    public function __construct($bills, $billData)
    {
        $this->bills = $bills;
        $this->billData = $billData;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        $bills = $this->bills->jsonSerialize();
        return json_encode([
            'bills' => $bills,
            'bill_data' => $this->billData
        ], $options);
    }

    /**
     * @return mixed
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * @return mixed
     */
    public function getBillData()
    {
        return $this->billData;
    }
}