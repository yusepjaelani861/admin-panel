<?php

namespace App\Http\Controllers;

use App\Models\CDN\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function list(Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        } 

        $transaction = Transaction::orderBy('id', 'desc')
            ->with('user');
        if ($request->has('search')) {
            $transaction = $transaction->where('merchant_ref', 'like', '%' . $request->search . '%');
        }

        if ($request->user) {
            $transaction = $transaction->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->user . '%');
            });
        }

        $transaction = $transaction->paginate((int) $request->limit ?? 20);

        $transaction->appends($request->all());

        return view('transactions.list', [
            'transactions' => $transaction
        ]);
    }

    public function view(int $id, Request $request)
    {
        if (!$this->protect()) {
            return redirect()->route('dashboard');
        }
        
        $transaction = Transaction::where('id', $id)
            ->with('user')
            ->first();

        if (!$transaction) {
            return redirect()->route('transactions.list')->with('error', 'Transaction not found');
        }

        return view('transactions.view', [
            'transaction' => $transaction
        ]);
    }
}
