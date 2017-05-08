<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Criteria\FindBetweenDateBRCriteria;
use CodeFin\Presenters\BillSerializerPresenter;
use CodeFin\Criteria\FindByValueBRCriteria;
use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Controllers\Response;
use CodeFin\Http\Requests;
use CodeFin\Http\Requests\BillPayRequest;
use CodeFin\Http\Requests\BillReceiveRequest;
use CodeFin\Repositories\Interfaces\BillReceiveRepository;
use Illuminate\Http\Request;


class BillReceivesController extends Controller
{
    use BillControllerTrait;

    /**
     * @var BillReceiveRepository
     */
    protected $repository;


    public function __construct(BillReceiveRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParam = config('repository.criteria.params.search');
        $search = $request->get($searchParam);
        $this->repository->setPresenter(BillSerializerPresenter::class);
        $this->repository
            ->pushCriteria(new FindBetweenDateBRCriteria($search, 'date_due'))
            ->pushCriteria(new FindByValueBRCriteria($search));

        $bills = $this->repository->paginate();

        return $bills;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillReceiveRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillReceiveRequest $request)
    {
        $bankAccount = $this->repository->create($request->all());
        return response()->json($bankAccount, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAccount = $this->repository->find($id);
        return response()->json($bankAccount, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  BillPayRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(BillReceiveRequest $request, $id)
    {
        $bankAccount = $this->repository->update($request->all(), $id);
        return response()->json($bankAccount, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json([], 204);
    }
}
