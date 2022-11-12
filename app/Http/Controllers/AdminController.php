<?php

namespace App\Http\Controllers;

use App\UlosColors;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Transaction;
use App\Profile;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  public function index()
  {
    $countOrder = Transaction::all()->count();

    $countMerchant = DB::table('model_has_roles')->where('role_id', 2)->count();

    $countCustomer = DB::table('model_has_roles')->where('role_id', 3)->count();

    $countHomestay = DB::table('homestays')->count();

    return view('admin.index')
    ->with('countOrder', $countOrder)
    ->with('countMerchant', $countMerchant)
    ->with('countCustomer', $countCustomer)
    ->with('countHomestay', $countHomestay);
  }

  private function getAuthincatedUser() {
    $user = User::with('profile')->find(Auth::user()->id);
    $address = json_decode(json_decode($user->profile->address)[0]);
    $user->profile->address = $address;

    return $user;
  }

  public function showProfile(){
    $user = $this->getAuthincatedUser();
    return view('admin.profiles.index')->with('user', $user);
  }

  public function editProfile(){
    $user = $this->getAuthincatedUser();
    return view('admin.profiles.edit')->with('user', $user);
  }

  public function updateProfile(Request $request){
    $user = $this->getAuthincatedUser();
    $profile = [];
    $profile['name'] = $request->name;
    $profile['phone'] = $request->phone;

    if($request->file('photo')) {
      $updateImage = $request->file('photo');
      $imageName = $updateImage->getClientOriginalName();
      $destinationPath = public_path('/images/profiles');
      $updateImage->move($destinationPath, $imageName);
      $profile['photo'] = $imageName;
    }

    $user->profile()->update($profile);

    return redirect('/admin/profile')->with('success', 'Admin berhasil di update');
  }
  public function showChangePassword(){
    $user = $this->getAuthincatedUser();
    return view('admin.profiles.edit-password')->with('user', $user);
  }
  public function editPassword(Request $request){
    $user = $this->getAuthincatedUser();

    if($request->password === $request->password_confirm){
      $user->password = bcrypt($request->password);
      $user->update();

      return redirect("/admin/profile")->with("success", "Password changed successfully");
    } else {
      return redirect()->back()->with("failed", "Password not matched");
    }

  }

  public function findAllUlosColors(){
      $ulosColors = UlosColors::all();
      return view('admin.products.UlosColors')->with('ulos',$ulosColors);
  }

  public function addUlosColors(Request $request){
      $ulosColors = new UlosColors();
      $ulosColors->color =$request->warna;
      $ulosColors->save();
      return redirect("/admin/ulos-colors")->with("success", "Add new ulos color success");
  }

    public function editUlosColors(Request $request, $id){
        $ulosColors = UlosColors::find($id);
        $ulosColors->color =$request->warna;
        $ulosColors->save();
        return redirect("/admin/ulos-colors")->with("success", "Update new ulos color success");
    }

    public function deleteUlosColors($id){
        $ulosColors = UlosColors::find($id);
        $ulosColors->delete();
        return redirect("/admin/ulos-colors")->with("success", "Delete new ulos color success");
    }

}
