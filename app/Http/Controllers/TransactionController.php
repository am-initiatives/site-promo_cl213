<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Account as Account;
use App\Transaction as Transaction;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        $table = [];

        foreach ($transactions as $t) {
            $table[] = array(
                'date' => utf8_encode($t->created_at->diffForHumans()),
                'wording' => $t->wording,
                'amount' => $t->amount,
                'credited' => $t->credited->description,
                'debited' => $t->debited->description,
                );
        }

        $data['transactions'] = $table;

        return view('transactions.index', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'credited' => 'required|integer',
            'debited' => 'required|integer|different:credited',
            'wording' => 'required|between:10,255',
            'amount' => 'required|numeric',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $debitables = Auth::user()->availableAccounts();
        $creditables = Account::all();

        $data['creditables'] = [];
        $data['debitables'] = [];

        foreach ($creditables as $c) {
            $data['creditables'][$c->id] = $c->getTitle();
        }
        foreach ($debitables as $c) {
            $data['debitables'][$c->id] = $c->getTitle();
        }

        return view('transactions.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createList()
    {
        $debitables = Auth::user()->availableAccounts();
        $creditables = Account::all();

        $data['creditables'] = [];
        $data['debitables'] = [];

        foreach ($creditables as $c) {
            $data['creditables'][$c->id] = $c->getTitle();
        }
        foreach ($debitables as $c) {
            $data['debitables'][$c->id] = $c->getTitle();
        }

        return view('transactions.lists.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function listTables(Request $request)
    {
        $tables = $request->all();

        $data['debited'] = [];
        $data['credited'] = [];

        if (isset($tables['debited'])) {
            $ids = array_keys($tables['debited']);
            $debited = Account::find($ids);

            foreach ($tables['debited'] as $id => $amount) {
                $d = $debited->only($id)->first();
                $data['debited'][] = array(
                    'id' => $id,
                    'title' => $d->getTitle(),
                    'amount' => $amount,
                );
            }
        }

        if (isset($tables['credited'])) {
            $ids = array_keys($tables['credited']);
            $credited = Account::find($ids);

            foreach ($tables['credited'] as $id => $amount) {
                $d = $credited->only($id)->first();
                $data['credited'][] = array(
                    'id' => $id,
                    'title' => $d->getTitle(),
                    'amount' => $amount,
                );
            }
        }

        return view('transactions.lists.tables', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->route('transactions.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        if (!Auth::user()->isAllowed('all_accounts'))
        {
            $available = Auth::user()->availableAccounts();

            $debited = Account::find($request->get('debited'));
            if (!$available->has($debited->id))
                return redirect()->back()->withErrors(['unauthorized' => 'Tu n\'as pas le droit de débiter ce compte'.$debited->description])->withInput();;
        }


        $data = array(
            'wording' => $request->get('wording'),
            'amount' => (integer) 100*$request->get('amount'),
            'credited_account_id' => $request->get('credited'),
            'debited_account_id' => $request->get('debited'),
            );

        Transaction::create($data);

        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
