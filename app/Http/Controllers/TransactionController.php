<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function createTransaction(CreateTransactionRequest $request)
    {
        $data = $request->validated();
        $data['payment'] = $data['hours'] * Transaction::HOURLY_PAYMENT;
        $transaction = Transaction::create($data);

        return response()->json($transaction, 201);
    }

    public function getPaymentSum()
    {
        try {
            $sum = DB::table('transactions')
                ->selectRaw('employee_id, sum(payment) as payments')
                ->where('status', '=', Transaction::STATUS_OPEN)
                ->groupBy('employee_id')
                ->get();

            $response = [];
            foreach ($sum as $item) {
                $response[$item->employee_id] = $item->payments;
            }

            return response()->json($response);
        } catch (\Exception $exception) {
            return response(['server error:' . $exception->getMessage()], 500);
        }
    }

    public function conductTransactions()
    {
        try {
            $transactions = Transaction::where('status', 0)->get();
            if ($transactions->toArray()) {
                foreach ($transactions as $transaction) {
                    $transaction->status = Transaction::STATUS_CONDUCTED;
                    $transaction->update();
                }
                return response(['transactions status has been updated'], 201);
            } else return response(['no transactions to conduct'], 200);
        } catch (\Exception $exception) {
            return response(['server error:' . $exception->getMessage()], 500);
        }
    }
}
