<?php

namespace App\Http\Controllers\Mutant;

use App\Order;
use App\Product;
use App\Transaction;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

const STATUS_ACCEPT_BY_ADMIN = "acceptedByAdmin";

class TransactionController extends Controller
{
    // This class contains functions which have duplicated from
    // Renewed/TransactionController but every function have been
    // injected with mutant.

    /***************************
        updateStatus
     ***************************/

    public function updateStatusMutant1(Request $request, $id)
    {
        $countUpdatedTransaction = 0;
        try {
            $transaction = Transaction::find($id);
            $transaction->status = $request->status;
            $countUpdatedTransaction = $transaction->update();
        } catch (Exception $e) {
            return $e;
        }

        $countUpdatedProduct = 0;
        // muntant 1: == change to !=
        if ($request->status != STATUS_ACCEPT_BY_ADMIN) {
            $orders = Order::all()->where('transaction_id', $id);
            for ($i = 0; $i < count($orders); $i++) {
                try {
                    $product = Product::find($orders[$i]['product_id']);
                    $product->stock = $product->stock - $orders[$i]['quantity'];
                    $product->sold =  $product->sold + $orders[$i]['quantity'];
                    $countUpdatedProduct = $product->update();
                } catch (Exception $e) {
                    return $e;
                }
            }
        }

        return array(
            'updated_transaction' => (int) $countUpdatedTransaction,
            'updated_product' => (int) $countUpdatedProduct,
        );
    }

    public function updateStatusMutant2(Request $request, $id)
    {
        $countUpdatedTransaction = 0;
        try {
            $transaction = Transaction::find($id);
            $transaction->status = $request->status;
            $countUpdatedTransaction = $transaction->update();
        } catch (Exception $e) {
            return $e;
        }

        $countUpdatedProduct = 0;
        if ($request->status == STATUS_ACCEPT_BY_ADMIN) {
            $orders = Order::all()->where('transaction_id', $id);
            // muntant 2: < change to >
            for ($i = 0; $i > count($orders); $i++) {
                try {
                    $product = Product::find($orders[$i]['product_id']);
                    $product->stock = $product->stock - $orders[$i]['quantity'];
                    $product->sold =  $product->sold + $orders[$i]['quantity'];
                    $countUpdatedProduct = $product->update();
                } catch (Exception $e) {
                    return $e;
                }
            }
        }

        return array(
            'updated_transaction' => (int) $countUpdatedTransaction,
            'updated_product' => (int) $countUpdatedProduct,
        );
    }
}
