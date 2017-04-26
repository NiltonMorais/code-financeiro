<?php

namespace CodeFin\Serializer;

use Illuminate\Contracts\Support\Jsonable;

class StatementSerializer implements Jsonable
{
    /**
     * @var
     */
    private $statements;
    /**
     * @var
     */
    private $statementData;

    /**
     * StatementSerializer constructor.
     * @param $statements
     * @param $statementData
     */
    public function __construct($statements, $statementData)
    {
        $this->statements = $statements;
        $this->statementData = $statementData;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        $statements = $this->statements->jsonSerialize();
        return json_encode([
            'statements' => $statements,
            'statement_data' => $this->statementData
        ], $options);
    }

    /**
     * @return mixed
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @return mixed
     */
    public function getStatementData()
    {
        return $this->statementData;
    }
}