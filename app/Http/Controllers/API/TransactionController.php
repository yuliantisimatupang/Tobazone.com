<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Profile;
use App\Order;
use App\Payment;
use App\Cart;
use App\Product;
use Auth;
use GuzzleHttp\Client;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $profile = Profile::where('user_id', $request->all()['customerId'])->first();

        $customerAddress = $request->all()['customerAddress'];
        $shippingAddress = $profile->name . ", " .
            $profile->phone . "\n" .
            $customerAddress['detail'] . ", " .
            $customerAddress['subdistrict_name'] . ", " .
            $customerAddress['city_name'] . ", " .
            $customerAddress['province_name'] . " (" .
            $customerAddress['postal_code'] . ")";

        $merchants = $request->all()['merchants'];

        foreach($merchants as $merchant) {
            $transaction = Transaction::create([
                'customer_id' => $request->all()['customerId'],
                'merchant_id' => $merchant['id'],
                'courier' => $merchant['courier_code'],
                'address' => $shippingAddress,
                'additional_info' => "",
                'status' => "pending",
            ]);

            $orders = $merchant['products'];

            foreach($orders as $order) {
                $cart1 = Cart::where('id', $order['cartId'])->first();
                $o = Order::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $order['productId'],
                    'quantity' => $order['quantity'],
                    'price' => $order['price'],
                    'message' => $cart1->message
                ]);

                if($o) {
                    Cart::find($order['cartId'])->delete();
                }

                // $data_product = Product::find($order['productId']);
                // $data_product->stock = $data_product->stock - $order['quantity'];
                // $data_product->sold = $order['quantity'];
                // $data_product->update();
            }

            Payment::create([
                'transaction_id' => $transaction->id,
                'product_cost' => $merchant['totalProductCost'],
                'shipping_cost' => $merchant['totalShippingCost'],
            ]);
        }

        return response()->json($transaction);
    }

    public function updateTransactionStatus(Request $request, $id) {
        $transaction = Transaction::find($id);
        $transaction->status = $request->status;
        $transaction->update();
    }

    public function confirmByUser(Request $request, $id) {

        $transaction = Transaction::find($id);
        $transaction->confirm_user = $request->data;
        $transaction->update();
    }

    public function getCustomerTransaction($id) {
        $transaction = Transaction::with(['orders', 'orders.product', 'payment','merchant.profile'])
            //   ->withTrashed()
            ->where('customer_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transaction);
    }

    public function getTransaction($userId, $tranId) {
            $transaction = Transaction::with(['customer', 'customer.profile', 'payment'])

            ->where('customer_id', $userId)
            ->where('id', $tranId)
            ->first();
        return response()->json($transaction);
    }


    public function updateProofOfPayment(Request $request, $id) {
        $image = $request->file('image');
        $imageName = time() . $image->getClientOriginalName();
        $destinationPath = public_path('/images/proof-of-payment');
        $image->move($destinationPath, $imageName);

        $transaction = Transaction::find($id);
        $payment = $transaction->payment;
        $payment->proof = json_encode([
            "image" => $imageName,
            "bank" => $request->bank,
            "senderName" => $request->name,
        ]);
        $payment->status = 'paid';
        $transaction->status = 'waitForVerified';

        $payment->update();
        $transaction->update();
    }

    public function getTrackingStatus($id) {
        $transaction = Transaction::with(['orders.product.review', 'orders.product.merchant.profile', 'payment'])
            ->where('id', $id)
            ->first();

        $tracking = $this->getTrackingV2($transaction->shipping_number, $transaction->courier);

        return response()->json([
            "transaction" => $transaction,
            "tracking" => json_decode($tracking)
        ]);
    }

    private function getTracking($shippingNumber, $courier) {
        $client = new Client([
            'base_uri' => 'https://pro.rajaongkir.com/api/',
            'headers' => [
                "key" => env('RAJAONGKIR_API_KEY'),
                "Content-Type" => "application/x-www-form-urlencoded"
            ]
        ]);

        $payload = [
            "waybill" => $shippingNumber,
            "courier" => $courier,
        ];

        $result = $client->request('POST', 'waybill', ['form_params' => $payload]);
        return $result->getBody()->getContents();
    }

    private function getTrackingV2($shippingNumber, $courier)
    {
        
        $client = new Client([
            'base_uri' => 'https://api.binderbyte.com/v1/track?api_key=b6ca0ecb8ba7a9d1481fa9ef04e3448b3113b0e8c62c7da0ae1a7e4c1976c783&courier='.$courier.'&awb='.$shippingNumber,
        ]);


        $result = $client->request('GET');
        return $result->getBody()->getContents();
    }

}
