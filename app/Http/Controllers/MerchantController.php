<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use App\Profile;
use Auth;
use DB;
use Carbon\Carbon;

class MerchantController extends Controller
{

  private function getAuthenticatedMerchant()
  {
    $merchant = User::with('profile')->find(Auth::user()->id);
    $address = json_decode(json_decode($merchant->profile->address)[0]);
    $merchant->profile->address = $address;

    return $merchant;
  }

  public function index()
  {
    $merchant = $this->getAuthenticatedMerchant();
    return view('users.merchants.index')->with('merchant', $merchant);
  }

  public function products()
  {
    return view('users.merchants.products');
  }

  public function getNewOrders($id)
  {
    $merchant = $this->getAuthenticatedMerchant();

    return view('users.merchants.orders.new-order')->with('merchant', $merchant);
  }

  public function getOngoingOrders($id)
  {
    $merchant = $this->getAuthenticatedMerchant();

    return view('users.merchants.orders.ongoing-order')->with('merchant', $merchant);
  }

  public function getSuccesOrder($id)
  {
    $merchant = $this->getAuthenticatedMerchant();

    return view('users.merchants.orders.success-order')->with('merchant', $merchant);
  }

  public function newMerchant()
  {
    $merchants = DB::table('model_has_roles')->where('role_id', 2)
      ->pluck('model_id')->toArray();

    $users = User::where('status', '-')
      ->whereIn('id', $merchants)
      ->pluck('id')->toArray();

    $profiles = Profile::whereIn('user_id', $users)->get();

    foreach ($profiles as $profile) {
      $profile->address = json_decode(json_decode($profile->address)[0]);
    }

    return view('admin.merchant.index')->with('profiles', $profiles);
  }

  public function updateConfirm($id)
  {
    $confirm = User::find($id);
    $confirm->status = "verifiedByAdmin";
    $confirm->save();

    return redirect('/admin/new-merchant');
  }

  public function listMerchant()
  {
    $merchants = DB::table('model_has_roles')->where('role_id', 2)
      ->pluck('model_id')->toArray();

    $users = User::whereIn('id', $merchants)
      ->pluck('id')->toArray();

    $profiles = Profile::whereIn('user_id', $users)->get();

    foreach ($profiles as $profile) {
      $profile->address = json_decode(json_decode($profile->address)[0]);
    }

    return view('admin.merchant.list')->with('profiles', $profiles);
  }


  public function listUser()
  {

    $user = DB::table('model_has_roles')->where('role_id', 3)
      ->pluck('model_id')->toArray();

    $users = User::whereIn('id', $user)
      ->pluck('id')->toArray();

    $profiles = Profile::whereIn('user_id', $users)->get();

    foreach ($profiles as $profile) {
      $profile->address = json_decode(json_decode($profile->address)[0]);
      $email = User::find($profile->user_id);
      $profile->email = $email['email'];
    }
    return view('admin.merchant.list-user')->with('profiles', $profiles);
  }

  public function detailMerchant($id)
  {
    // $merchants = DB::table('model_has_roles')->where('role_id', 2)
    // ->pluck('model_id')->toArray();        

    // $users = User::whereIn('id', $merchants)
    //                       ->pluck('id')->toArray();    

    // $profiles = Profile::whereIn('user_id', $users)->get();    

    // $profile = $profiles->find($id);

    $profile = Profile::all()->where('user_id', $id)->first();
    // foreach($profiles as $profile) {
    $profile->address = json_decode(json_decode($profile->address)[0]);
    // }    
    return view('admin.merchant.detail-merchant')->with('profiles', $profile);
  }
}
