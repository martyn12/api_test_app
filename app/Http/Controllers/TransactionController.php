<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function registerTransaction(CreateTransactionRequest $request)
    {
        $data = $request->validated();
        $data['payments_sum'] = $data['hours'] * 200;
        $transaction = Transaction::create($data);
        return response()->json($transaction);
    }

    public function getPaymentSum()
    {
        $sum = DB::table('transactions')
            ->selectRaw('employee_id, sum(payments_sum) as payments')
            ->where('status', '=', 0)
            ->groupBy('employee_id')
            ->get();

        $response = [];

        foreach ($sum as $item) {
            $response[$item->employee_id] = $item->payments;
        }

        return response()->json([$response]);
    }

    public function conductTransactions()
    {
        try {
            $transactions = Transaction::where('status', 0)->get();
            foreach ($transactions as $transaction) {
                $transaction->status = 1;
                $transaction->update();
            }
            return response(['transaction status has been updated'], 200);
        } catch (\Exception $exception) {
            return response(['server error'], 500);
        }
    }
}
