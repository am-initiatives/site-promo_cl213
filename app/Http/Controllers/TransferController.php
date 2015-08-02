<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Guard;
use App\Account as Account;
use App\Transaction as Transaction;

class TransferController extends Controller
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
                'date' => utf8_encode($t->created_at->formatLocalized('%d %B %Y')),
                'wording' => $t->wording,
                'amount' => $t->amount,
                'credited' => $t->credited->description,
                'debited' => $t->debited->description,
                );
        }

        $data['transactions'] = $table;

        return view('transfers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Check user
        $account_ids = [1,3];

        $creditables = Account::all();
        $debitables = Account::find($account_ids);

        $data['creditables'] = array_combine($creditables->pluck('id')->toArray(), $creditables->pluck('description')->toArray()) ;
        $data['debitables'] = array_combine($debitables->pluck('id')->toArray(), $debitables->pluck('description')->toArray()) ;

        return view('transfers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
