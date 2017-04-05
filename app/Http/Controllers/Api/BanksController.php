<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Controllers\Response;
use CodeFin\Http\Requests;
use CodeFin\Http\Requests\BankAccountCreateRequest;
use CodeFin\Http\Requests\BankAccountUpdateRequest;
use CodeFin\Repositories\Interfaces\BankAccountRepository;
use CodeFin\Repositories\Interfaces\BankRepository;


class BanksController extends Controller
{
    /**
     * @var BankRepository
     */
    protected $repository;


    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }
}
