<?php

namespace CodeFin\Http\Controllers\Admin;

use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Controllers\Response;
use CodeFin\Http\Requests;
use CodeFin\Http\Requests\BankCreateRequest;
use CodeFin\Http\Requests\BankUpdateRequest;
use CodeFin\Repositories\Interfaces\BankRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = $this->repository->paginate(3);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $banks,
            ]);
        }

        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BankCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BankCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bank = $this->repository->create($request->all());

            $response = [
                'message' => 'Bank created.',
                'data' => $bank->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $bank = $this->repository->find($id);

        return view('banks.edit', compact('bank'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  BankUpdateRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(BankUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bank = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Bank updated.',
                'data' => $bank->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Bank deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Bank deleted.');
    }
}
