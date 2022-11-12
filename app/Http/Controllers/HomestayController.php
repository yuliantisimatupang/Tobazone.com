<?php

namespace App\Http\Controllers;

use App\Homestay;
use App\HomestayRooms;
use App\HomestayTransactions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\HomestayOrders;
use Illuminate\Http\Response;

class HomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findAll()
    {
        $homestays = Homestay::All();
        $data = [
            'code' => 200,
            'status' => 'OK',
            'data' => [
                $homestays
            ]
        ];
        return view('users.homestay.after_search_page')->with('homestays', $homestays);
    }

    public function findAllCustomer(Request $request)
    {
        if ($request->exists('kabupaten')) {
            $query = $request->query('kabupaten');
            $result = DB::table('homestays')
                ->join('users', 'users.id', '=', 'homestays.merchant_id')
                ->select('homestays.*', 'users.username')
                ->where('homestays.kabupaten', '=', $query)
                ->get();
            $carousel = Homestay::orderBy('created_at', 'desc')->take(3)->get();
            $data = [
                'code' => 200,
                'status' => 'OK',
                'data' => [
                    $result
                ]
            ];
            $kabupaten = DB::select("SELECT kabupaten FROM homestays GROUP BY kabupaten");
            return view(
                'users.homestay.index',
                [
                    'homestays' => $result,
                    'kabupaten' => $kabupaten,
                    'carousel' => $carousel
                ]
            );
        } else {
            $result = DB::table('homestays')
                ->join('users', 'users.id', '=', 'homestays.merchant_id')
                ->select('homestays.*', 'users.username')
                ->get();
            $data = [
                'code' => 200,
                'status' => 'OK',
                'data' => [
                    $result
                ]
            ];
            $carousel = Homestay::orderBy('created_at', 'desc')->take(3)->get();
            $kabupaten = DB::select("SELECT kabupaten FROM homestays GROUP BY kabupaten");
            return view(
                'users.homestay.index',
                [
                    'homestays' => $result,
                    'kabupaten' => $kabupaten,
                    'carousel' => $carousel
                ]
            );
        }
    }

    public function morePage()
    {
        $homestays = Homestay::All();
        $result = DB::table('homestays')
            ->join('users', 'users.id', '=', 'homestays.merchant_id')
            ->select('homestays.*', 'users.username')
            ->get();
        $data = [
            'code' => 200,
            'status' => 'OK',
            'data' => [
                $result
            ]
        ];
        return view('users.homestay.more_page')->with('homestays', $result);
    }


    public function search(Request $request)
    {
        $where = '';
        if ($request->kecamatan) {
            $where .= "WHERE LOWER(kecamatan) like LOWER('%" . $request->kecamatan . "%')";
        }
        if ($request->tamu) {
            if (strlen($where) > 0) {
                $where .= " AND (total_room <= " . $request->tamu . " OR room_available <= " . $request->tamu . ")";
            } else {
                $where .= " WHERE (total_room <= " . $request->tamu . " OR room_available <= " . $request->tamu . ")";
            }
        }
        $homestays = DB::select("SELECT * FROM homestays " . $where);

        return view('users.homestay.after_search_page')->with('homestays', $homestays);
    }

    public function search_get(Request $request)
    {
        $query = $request->query('kabupaten');
        $result = DB::table('homestays')
            ->join('users', 'users.id', '=', 'homestays.merchant_id')
            ->select('homestays.*', 'users.username')
            ->where('homestays.kabupaten', '=', $query)
            ->get();
        return view('users.homestay.after_search_page')->with('homestays', $result);
    }
    public function searchInAllPage(Request $request)
    {
        $where = '';
        if ($request->kecamatan) {
            $where .= "WHERE LOWER(kecamatan) like LOWER('%" . $request->kecamatan . "%')";
        }
        if ($request->tamu) {
            if (strlen($where) > 0) {
                $where .= " AND (total_room <= " . $request->tamu . " OR room_available <= " . $request->tamu . ")";
            } else {
                $where .= " WHERE (total_room <= " . $request->tamu . " OR room_available <= " . $request->tamu . ")";
            }
        }
        $homestays = DB::select("SELECT * FROM homestays join users on users.id = homestays.merchant_id " . $where);

        return view('users.homestay.all_homestay_page')->with('homestays', $homestays);
    }

    public function getAllHomestay()
    {
        $result = DB::table('homestays')
            ->join('users', 'users.id', '=', 'homestays.merchant_id')
            ->select('homestays.*', 'users.username')
            ->get();
        return view('users.homestay.all_homestay_page')->with('homestays', $result);
    }

    public function searchTest()
    {
        $homestays = Homestay::All();
        return view('users.homestay.after_search_page')->with('homestays', $homestays);
    }

    /**
     * Display a list of homestay orders by user id.
     *
     * @return \Illuminate\Http\Response
     */
    public function findAllCustomerOrder()
    {
        $user = Auth::user();
        if (!$user) {
            // Redirect to 401 page if user is not logged in.
            return abort(Response::HTTP_UNAUTHORIZED, 'Not authorized user');
        }

        $homestayOrders = HomestayTransactions::where('user_id', $user->id)->get();

        return view('users.customers.homestays.index')->with('homestayOrders', $homestayOrders);
    }

    /**
     * Display the detail of a homestay order by order id.
     *
     * @return \Illuminate\Http\Response
     */
    public function findCustomerOrderByID($idOrder)
    {
        $user = Auth::user();
        if (!$user) {
            // Redirect to 401 page if user is not logged in.
            return abort(Response::HTTP_UNAUTHORIZED, 'Not authorized user');
        }

        $orderss= HomestayTransactions::find($idOrder);
        $orderDetail = HomestayOrders::where('id_transaction', $idOrder)
            ->where('id_customer', $user->id)
            ->get();
//        dd($orderDetail[0]->homestay->name);
        // Handle if request is not found.
        if (!$orderDetail) {
            abort(404, 'Page not found.');
        }


        return view('users.customers.homestays.order_detail',compact('orderDetail','orderss'));
    }

    public function findById($id)
    {
        $detail = Homestay::find($id);
        $rooms = HomestayRooms::where('id_homestay', $id)->get();
        if (!$detail) {
            abort(404, "Page not found.");
        }
        $data = [
            "homestays" => $detail,
            "kamar" => $rooms
        ];

        return view('users.homestay.detail_homestay_page')->with('homestays', $data);
    }

    public function stores(Request $request)
    {

        return "Sukses";
    }

    public function createDataPage()
    {
        return view('users.merchants.homestays.create_homestay');
    }

    public function store(Request $request)
    {
        $length = 15;
        $rand = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        if ($request->image) {
            $data = explode(',', $request->image);
            file_put_contents('images/' . $rand . '.png', base64_decode($data[1]));
        }


        $homestay = new Homestay();
        $homestay->name = ($request->get('name'));
        $homestay->price = $request->price;
        $homestay->total_room = 2;
        $homestay->room_available = 2;
        $homestay->description = $request->description;
        $homestay->image = $rand . '.png';
        $homestay->address = $request->address;
        $homestay->status = 1;
        $homestay->kabupaten = $request->kabupaten['name'];
        $homestay->kecamatan = $request->kecamatan['city'];
        $homestay->merchant_id = Auth::user()->id;
        $homestay->save();
        return redirect('/merchant')->with('success', 'Product created successfully.');
    }

    public function saveRooms(Request $request)
    {
        $length = 10;
        $homestay = Homestay::where('merchant_id', Auth::user()->id)->latest('created_at')->first();
        $rooms = new HomestayRooms();
        $rooms->id_homestay = $homestay->id;
        $rooms->kategori = $request->kategori;
        $rooms->facilities = json_encode($request->fasilitas);
        $rooms->price = $request->price;
        $rooms->total_bed = $request->total_bed;
        $rooms->image = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length) . ".png";
        $rooms->name = "0";
        $rooms->status = "available";
        $rooms->description = "";
        $rooms->total_extra_bed = $request->total_extra_bed;
        $rooms->save();
    }


    public function bookHomestay(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            // Redirect to login page if user is not logged in.
            return redirect('/');
        }
        $rooms = HomestayRooms::find($id);
        $total = $request->get('totalRoom');
        $orderHomestay = new HomestayOrders();
        $orderHomestay->total_price = $total * $rooms->price;
        $orderHomestay->id_homestay = $rooms->id_homestay;
        $orderHomestay->id_kamar = $id;
        $orderHomestay->id_customer = Auth::user()->id;
        $orderHomestay->check_in = $request->get('checkIn');
        $orderHomestay->duration = $request->get('durasi');
        $orderHomestay->jumlah_kamar = $request->get('totalRoom');
        $orderHomestay->payment_method = "";
        $orderHomestay->is_paid = false;
        $orderHomestay->resi = "";
        $orderHomestay->status = "Pending";
        $orderHomestay->save();
        return redirect('/user/homestay/order/findAll');
    }

    public function approvePenginapan(Request $request, $id)
    {

        $homestay_id = HomestayTransactions::find($id);
        $affected = DB::table('homestay_orders')->where('id_transaction', '=', $id)->update(array('status' => 'accepted'));
        $homestay_id->status = "accepted";
        $homestay_id->update();
        //redirect

        return redirect('/admin/homestay/new-order')->with('success', 'Pesanan Diterima');
    }

    public function rejectedPenginapan(Request $request, $id)
    {

        $affected = DB::table('homestay_orders')->where('id_transaction', '=', $id)->update(array('status' => 'accepted'));
        $homestay_id = HomestayTransactions::find($id);
        $homestay_id->status = "rejected";
        $homestay_id->update();

        return redirect('/admin/homestay/new-order')->with('success', 'Pesanan Ditolak');
    }

    public function listPesananPenginapan()
    {

        $data = HomestayTransactions::all();

        return view('users.merchants.homestays.ListPesananPenginapan')->with('data', $data);
    }

    public function listSuccessOrder()
    {

        $merchant = $this->getAuthenticatedMerchant();
        return view('users.merchants.orders.success-order')->with('merchant', $merchant);
    }


    //Merchant
    public function createHomestayPage()
    {
        $merchant = $this->getAuthenticatedMerchant();
        return view('users.merchants.homestays.create_homestay')->with('result', $merchant);
    }

    private function getAuthenticatedMerchant()
    {
        $merchant = User::with('profile')->find(Auth::user()->id);
        $address = json_decode(json_decode($merchant->profile->address)[0]);
        $merchant->profile->address = $address;

        return $merchant;
    }

    public function getAllMerchantHomestay()
    {
        $merchant = $this->getAuthenticatedMerchant();
        $homestays = Homestay::where('merchant_id', Auth::user()->id)->get();;
        $result = [
            "merchant" => $merchant,
            "homestay" => $homestays
        ];
        //        dd($result['merchant']->profile->photo);
        return view('users.merchants.homestays.all_homestay')->with('result', $result);
    }


    public function findAllMerchantOrder()
    {

        $homestayOrders = DB::table('homestay_orders')
            ->join('homestays', 'homestay_orders.id_homestay', '=', 'homestays.id')
            ->where('homestays.merchant_id', '=', Auth::user()->id)
            ->whereIn('homestay_orders.status', ['paid', 'pending'])
            ->get();
        return response()->json($homestayOrders);
    }

    public function findAllMerchantHomestay()
    {
        $homestays = Homestay::where('merchant_id', Auth::user()->id)->get();

        return $homestays;
    }

    public function deleteById($id)
    {
        Homestay::find($id)->delete();
        $merchant = $this->getAuthenticatedMerchant();
        $homestays = Homestay::All();
        $result = [
            "merchant" => $merchant,
            "homestay" => $homestays
        ];
        return redirect('merchant/homestay/findAll');
    }

    /**
     * Show the form for editing homestay and homestay room(s).
     *
     * @param int $id
     * @return void
     */
    public function updateHomestay($id)
    {
        if (!Auth::user()) {
            return abort(Response::HTTP_UNAUTHORIZED, 'Not authorized user');
        }

        $merchant = $this->getAuthenticatedMerchant();
        if ($merchant === null) {
            return abort(Response::HTTP_UNAUTHORIZED, 'Not authorized user');
        }

        $result = [
            "merchant" => $merchant,
            "homestay" => Homestay::find($id),
            "rooms" => HomestayRooms::where('id_homestay', $id)->get(),
        ];

        return view('users.merchants.homestays.update_homestay')->with('result', $result);
    }

    /**
     * Update the homestay in the storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $homestay = Homestay::find($id);
        if ($request->file('images')) {
            $image = $request->file('images');
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $homestay->image);
        }
        $homestay->name = $request->name;
        $homestay->total_room = $request->stock;
        $homestay->room_available = $request->stock_available;
        $homestay->price = $request->price;
        $homestay->description = $request->description;
        $homestay->address = $request->address;
        $homestay->image = $homestay->image;
        $homestay->update();

        return redirect('/merchant/homestay/findAll')->with('success', 'Product created successfully.');
    }

    public function findHomestayById($id)
    {
        $homestay = Homestay::find($id);
        return $homestay;
    }

    public function findSuccessOrderMerchant()
    {
        $transactions = HomestayOrders::join('users', 'id_customer', '=', 'users.id')
            ->join('homestays', 'id_homestay', '=', 'homestays.id')
            ->select('homestay_orders.*', 'homestays.name', 'users.username', 'homestays.address')
            ->where('homestay_orders.status', 'Success')->get();
        return view('admin.homestay.detail-homestay')->with('order', $transactions);
    }

    public function findAllMerchantOrders()
    {
        $homestayOrders = DB::table('homestay_orders')
            ->join('homestays', 'homestay_orders.id_homestay', '=', 'homestays.id')
            ->join('users', 'users.id', '=', 'homestay_orders.id_customer')
            ->where('homestays.merchant_id', '=', Auth::user()->id)
            ->whereIn('homestay_orders.status', ['paid', 'pending'])
            ->get();
        $query = DB::Select('SELECT ho.* , h.name, h.address , u.username FROM homestay_orders AS ho JOIN homestays AS h ON ho.id_homestay = h.id JOIN users AS u ON ho.id_customer = u.id WHERE h.merchant_id =' . Auth::user()->id);
        //        $result = DB::table('homestay_orders')
        //            ->select('*')
        //            ->join('homestays', 'homestays.id', '=', 'homestay_orders.country_id')
        //            ->where('countries.country_name', $country)
        //            ->get();
        //        dd($orders);
        //        $homestay = Homestay::find($orders->id_homestay);
        $merchant = $this->getAuthenticatedMerchant();
        $result = [
            "merchant" => $merchant,
            "orders" => $query
            //            "homestay" => $homestay
        ];

        return view('users.merchants.homestays.record_pesanan_penginapan')->with('merchant', $merchant);
    }

    public function uploadResi(Request $request, $id)
    {
        $length = 10;
        $rand = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        $homestayOrders = HomestayTransactions::find($id);
        if ($request->file('images')) {
            $image = $request->file('images');
            $destinationPath = public_path('/images');
            $image->move($destinationPath, 'resi_' . $rand . '.png');
        }
        $homestayOrders->status = 'In Progress';
        $homestayOrders->payment_method = $request->utkbank;
        $homestayOrders->is_paid = 1;
        $homestayOrders->resi = 'resi_' . $rand . '.png';
        $homestayOrders->nama_pengirim = $request->namapengirim;
        $homestayOrders->update();
        return redirect('/user/homestay/order/findAll');
    }

    //Admin

    public function findAllnewOrder()
    {
        $transactions = HomestayOrders::join('users', 'id_customer', '=', 'users.id')
            ->join('homestays', 'id_homestay', '=', 'homestays.id')
            ->select('homestay_orders.*', 'homestays.name', 'users.username', 'homestays.address')
            ->whereIn('homestay_orders.status', ['In Progress', 'Pending'])->get();
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'Pending'");
        return view('admin.orders.homestay-new-order')->with('transactions', $query);
    }

    public function findAllPaidOrder()
    {
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'In Progress'");
        return view('admin.orders.homestay-new-order')->with('transactions', $query);
    }

    public function findAllSuccessOrder()
    {
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'accepted'");
        return view('admin.orders.homestay-new-order')->with('transactions', $query);
    }

    public function findAllRejectedOrder()
    {
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'rejected'");
        return view('admin.orders.homestay-new-order')->with('transactions', $query);
    }

    public function allSuccessOrder()
    {
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'accepted' AND h.merchant_id=" . Auth::id());
        $result = [
            "code" => 200,
            "status" => "OK",
            "data" => $query
        ];
        return $result;
    }

    public function allPaidOrder()
    {
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.status = 'In Progress' AND h.merchant_id=" . Auth::id());
        $result = [
            "code" => 200,
            "status" => "OK",
            "data" => $query
        ];
        return $result;
    }

    public function findDetailNewOrder($id)
    {
        $transactions = HomestayOrders::join('users', 'id_customer', '=', 'users.id')
            ->join('homestays', 'id_homestay', '=', 'homestays.id')
            ->select('homestay_orders.*', 'homestays.name', 'users.username', 'homestays.address')
            ->where('homestay_orders.id', $id)->get();
        $query = DB::Select("SELECT ho.* , h.name, h.address , u.username FROM homestay_transaction AS ho JOIN homestays AS h ON ho.homestay_id = h.id JOIN users AS u ON ho.user_id = u.id WHERE ho.id = " . $id);

        return view('admin.homestay.detail-homestay')->with('order', $query);
    }

    public function deleteOrder($id)
    {
        $order = HomestayTransactions::find($id);
        $order_all = HomestayOrders::where('id_transaction', '=', $id);
        $order_all ->delete();
        $order->delete();
        return redirect('/user/homestay/order/findAll');
    }


    public function findHomestayTerlaris()
    {
        $query = DB::Select("SELECT COUNT(ho.id) AS ORD, h.id, h.merchant_id,
h.name,
h.price,
h.total_room,
h.room_available,
h.description,
h.address,
h.image,
h.status,
h.kabupaten,
h.kecamatan,
h.desa FROM homestays AS h LEFT OUTER JOIN homestay_orders AS ho ON h.id = ho.id_homestay GROUP BY h.id,
h.merchant_id,
h.name,
h.price,
h.total_room,
h.room_available,
h.description,
h.address,
h.image,
h.status,
h.kabupaten,
h.kecamatan,
h.desa ORDER BY ORD DESC LIMIT 10");

        return response()->json($query);
    }
}
