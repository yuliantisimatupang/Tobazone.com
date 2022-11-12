<?php

namespace App\Http\Controllers;

use App\IncludedNotIncluded;
use App\Kabupaten;
use App\LayananWisata;
use App\PaketWisata;
use App\Sesi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use File;

class PaketWisataController extends Controller
{
    public function index()
    {
        $pakets = PaketWisata::with(['getIncludedNotIncluded', 'getKabupaten'])->where('status', '!=', 2)->orderBy('created_at', 'DESC')->paginate(10);
        $kabupaten = Kabupaten::all();
        //        $pakets= paketWisata::where('id_paket',0)->paginate();
        $paketss = PaketWisata::with(['getIncludedNotIncluded', 'getKabupaten'])->where('status', '!=', 2)->orderBy('created_at', 'DESC')->limit(3);

        return view('admin.paket.index', compact('kabupaten', 'pakets','paketss'));
    }
    public function index_customer(){
        $paket = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->limit(8);
        $pakets = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->limit(3);
        $jenis = DB::table('paket_wisata')->select('jenis_paket')->groupBy('jenis_paket')->get();
        $kabupaten = Kabupaten::all();
        $paket_lainnya = $pakets->take(3);

        return view('paket-wisata.index',compact('paket', 'jenis', 'kabupaten','paket_lainnya','pakets'));
    }
    public function more_paket(){
        $paket = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->paginate(10);
        $pakets = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $jenis = DB::table('paket_wisata')->select('jenis_paket')->groupBy('jenis_paket')->get();
        $kabupaten = Kabupaten::all();
        $paket_lainnya = $pakets->take(3);

        return view('paket-wisata.paketwisata',compact('paket', 'jenis', 'kabupaten','paket_lainnya'));
    }

    public function list_paket(){
        $paket = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->paginate(20);
        $jenis = DB::table('paket_wisata')->select('jenis_paket')->groupBy('jenis_paket')->get();
        $kabupaten = Kabupaten::all();

        return view('paket-wisata.list-paket',compact('paket', 'jenis', 'kabupaten'));
    }

    public function indexFilter(Request $request)
    {
        $kabupaten = Kabupaten::all();
        $id_kab = $request->kabupaten;
        $jeniss = $request->jenis;
        $jenis = DB::table('paket_wisata')->select('jenis_paket')->groupBy('jenis_paket')->get();
        $pakets = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $paket_lainnya = $pakets->take(3);

        if ($request->jenis == 'Tipe/Jenis Perjalanan') {
            if ($request->kabupaten == 'Kabupaten') {
                $paket = paketWisata::where('status', 1)->orderBy('created_at', 'DESC')->paginate(20);
            } else {
                $paket = paketWisata::where([['kabupaten_id', $id_kab], ['status', 1]])->orderBy('created_at', 'DESC')->paginate(20);
            }
        } else {
            if ($request->kabupaten == 'Kabupaten') {
                $paket = paketWisata::where([['jenis_paket', 'LIKE', '%' . $request->jenis . '%'], ['status', 1]])->orderBy('created_at', 'DESC')->paginate(20);
            } else {
                $paket = paketWisata::where([['status', 1], ['kabupaten_id', $id_kab], ['jenis_paket', 'LIKE', '%' . $request->jenis . '%']])->orderBy('created_at', 'DESC')->paginate(20);
            }
        }

        return view('paket-wisata.list-paket',compact('paket', 'jenis', 'kabupaten','paket_lainnya', 'jeniss', 'id_kab'));
    }

    public function show($id_paket)
    {
        $paket = PaketWisata::where('id_paket', $id_paket)->with(['getKabupaten', 'getIncludedNotIncluded', 'getPaketLayanan'])->first();
        $sesi = Sesi::where('paket_id', $id_paket)->orderBy('status', 'DESC')->paginate(10);
        return view('admin.paket.detail', compact('sesi', 'paket'));
    }

    public function create()
    {
        $status = 'create';
        $kabupaten = Kabupaten::all();
        $options = $this->fill_unit_select_box();
        $c = 1;
        $ci = 1;
        $cu = 1;
        return view('admin.paket.create', compact('status', 'kabupaten', 'options', 'c', 'ci', 'cu'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('gambar') ) {
            $file = $request->file('gambar');
            $filename = time() . Str::slug($request->nama_paket_wisata) . '.' . $file->getClientOriginalExtension();

            $file->move('storage/img/paket', $filename);
            $paket = paketWisata::create([
                'nama_paket' => $request->nama_paket_wisata,
                'harga_paket' => $request->harga_paket_wisata,
                'availability' => $request->availability,
                'durasi' => $request->durasi,
                'jenis_paket' => $request->jenis,
                'deskripsi_paket' => $request->deskripsi,
                'rencana_perjalanan' => $request->rencana_perjalanan,
                'tambahan' => $request->tambahan,
                'gambar' => $filename,
                'kabupaten_id' => $request->daerah,
            ]);
            echo $paket->id_paket;
            for ($i = 1; $i <= $request->jlh_included; $i++) {
                $paket->getIncludedNotIncluded()->create([
                    'jenis_ini' => 'included',
                    'keterangan' => $_POST['included_' . $i],
                ]);
            }
            for ($i = 1; $i <= $request->jlh_not_included; $i++) {
                $paket->getIncludedNotIncluded()->create([
                    'jenis_ini' => 'not included',
                    'keterangan' => $_POST['not_included_' . $i],
                ]);
            }
            for ($i = 1; $i <= $request->jlh_layanan; $i++) {
                $paket->getPaketLayanan()->attach($_POST['layanan_' . $i]);
            }
            return redirect(route('admin.paket.show', $paket->id_paket));
        }
    }

    protected function fill_unit_select_box($paket = null)
    {
        $layanan = '';
        if ($paket == null) {
            foreach (LayananWisata::with('getKabupaten', 'getJenisLayanan')->get() as $layanans) {
                $layanan .= '<option value="' . $layanans['id'] . '">' . $layanans['nama_layanan'] . '</option>';
            }

        } else {
            foreach (LayananWisata::with('getKabupaten', 'getJenisLayanan')->get() as $layanans) {
                $s = 0;
                foreach ($paket->getPaketLayanan as $row) {
                    if ($row->id == $layanans['id']) {
                        $s = 1;
                    }
                }
                if ($s == 0) {
                    $layanan .= '<option value="' . $layanans['id'] . '">' . $layanans['nama_layanan'] . '</option>';
                }
            }
        }
        return $layanan;
    }

    public function editChoice($id_paket)
    {
        return view('admin.paket.choice', compact('id_paket'));
    }

    public function edit($id_paket)
    {
        $paket = paketWisata::find($id_paket);
        $kabupaten = Kabupaten::all();
        $status = 'edit';
        return view('admin.paket.edit', compact('paket', 'kabupaten', 'status'));
    }

    public function update(Request $request, $id_paket)
    {
        $paket = paketWisata::find($id_paket);
        $photo = $paket->gambar;

        if ($request->hasFile('gambar')) {
            !empty($photo) ? File::delete(public_path('storage/img/paket/' . $photo)) : null;
            $file = $request->file('gambar');
            $photo = time() . Str::slug($request->nama_paket_wisata) . '.' . $file->getClientOriginalExtension();

            $file->move('storage/img/paket', $photo);
        }

        $paket->update([
            'nama_paket' => $request->nama_paket_wisata,
            'harga_paket' => $request->harga_paket_wisata,
            'availability' => $request->availability,
            'durasi' => $request->durasi,
            'status' => $request->status,
            'jenis_paket' => $request->jenis,
            'deskripsi_paket' => $request->deskripsi,
            'rencana_perjalanan' => $request->rencana_perjalanan,
            'tambahan' => $request->tambahan,
            'gambar' => $photo,
            'kabupaten_id' => $request->daerah,
        ]);

        return redirect(route('admin.paket.editChoice', $id_paket));
    }

    public function createSesi($id_paket)
    {

        return view('admin.paket.create_sesi', compact('id_paket'));
    }

    public function storeSesi(Request $request, $id_paket)
    {
        $sesi = Sesi::create([
            'paket_id' => $id_paket,
            'kuota_peserta' => $request->kuota_peserta,
            'jadwal' => $request->jadwal,
            'status' => 1
        ]);

        return redirect(route('admin.paket.show', $id_paket));
    }

    public function editSesi($id_sesi)
    {
        $sesi = Sesi::find($id_sesi);
        return view('admin.paket.edit_sesi', compact('sesi'));
    }

    public function updateSesi(Request $request, $id_sesi)
    {
        $sesi = Sesi::find($id_sesi);
        $id_paket = $sesi->paket_id;
        $sesi->update([
            'kuota_peserta' => $request->kuota_peserta,
            'status' => $request->status,
            'jadwal' => $request->jadwal
        ]);

        return Redirect(Route('admin.paket.show', $id_paket));
    }


    public function nonaktifSesi($id_sesi)
    {
        $sesi = Sesi::find($id_sesi);
        $id_paket = $sesi->paket_id;
        $sesi->status = 0;
        $sesi->save();

        return redirect()->back();
    }

    public function aktifSesi($id_sesi)
    {
        $sesi = Sesi::find($id_sesi);
        $id_paket = $sesi->paket_id;
        $sesi->status = 1;
        $sesi->save();

        return redirect()->back();
    }

    public function destroySesi($id_sesi)
    {
        $sesi = Sesi::find($id_sesi);
        $id_paket = $sesi->paket_id;
        if ($sesi->getPemesanan->count() == 0) {
            $sesi->delete();

            return Redirect(Route('admin.paket.show', $id_paket));
        } else {
//            $error = 'Mohon Maaf Sesi ini memiliki pemesanan, Sehingga sesi ini tidak dapat dihapus.';
//            $paket = paketWisata::where('id_paket', $id_paket)->with(['getKabupaten', 'getIncludedNotIncluded', 'getPaketLayanan'])->first();
//            $sesi = Sesi::where('paket_id', $id_paket)->orderBy('status', 'DESC')->paginate(10);
            return redirect()->back()->with('error','Mohon Maaf Sesi ini memiliki pemesanan, Sehingga sesi ini tidak dapat dihapus.');
        }
    }

    public function nonaktifkanPaket($id_paket)
    {
        $paket = paketWisata::find($id_paket);
        $paket->status = 0;
        $paket->save();

        return redirect()->back();
    }

    public function aktifkanPaket($id_paket)
    {
        $paket = paketWisata::find($id_paket);
        $paket->status = 1;
        $paket->save();

        return redirect()->back();
    }

    public function editIni($id_paket)
    {
        $paket = paketWisata::where('id_paket', $id_paket)->with('getIncludedNotIncluded')->first();
        $ci = 0;
        $cu = 0;
        return view('admin.paket.edit_ini', compact('paket', 'ci', 'cu'));
    }

    public function updateIni(Request $request, $id_paket)
    {
        $paket = paketWisata::where('id_paket', $id_paket)->with('getIncludedNotIncluded')->first();
        if ($request->jlh_included != 0) {
            for ($i = 1; $i <= $request->jlh_included; $i++) {
                $paket->getIncludedNotIncluded()->create([
                    'jenis_ini' => 'included',
                    'keterangan' => $_POST['included_' . $i],
                ]);
            }

        }
        if ($request->jlh_not_included != 0) {
            for ($i = 1; $i <= $request->jlh_not_included; $i++) {
                $paket->getIncludedNotIncluded()->create([
                    'jenis_ini' => 'not included',
                    'keterangan' => $_POST['not_included_' . $i],
                ]);
            }
        }

        return redirect(route('admin.paket.editChoice', $id_paket));
    }

    public function hapusIni($id_ini)
    {
        $ini = IncludedNotIncluded::find($id_ini);
        $id_paket = $ini->paket_wisata_id;
        $ini->delete();

        return redirect(route('admin.paket.ini', $id_paket));
    }

    public function editLayanan($id_paket)
    {
        $paket = paketWisata::where('id_paket', $id_paket)->with('getPaketLayanan')->first();
        $options = $this->fill_unit_select_box($paket);
        $c = 0;
//        var_dump($paket->getPaketLayanan);
        return view('admin.paket.edit_layanan', compact('paket', 'c', 'options'));
    }

    public function updateLayanan(Request $request, $id_paket)
    {
        $paket = paketWisata::where('id_paket', $id_paket)->with('getPaketLayanan')->first();
        if ($request->jlh_layanan != 0) {
            for ($i = 1; $i <= $request->jlh_layanan; $i++) {
                $paket->getPaketLayanan()->attach($_POST['layanan_' . $i]);
            }
        }

        return redirect(route('admin.paket.editChoice', $id_paket));
    }

    public function recycle($id_paket)
    {
        $paket = paketWisata::find($id_paket);
        $paket->status = 0;
        $paket->save();

        return redirect(route('admin.paket'));
    }

    public function hapusLayanan($id_layanan, $id_paket)
    {

//        echo $id_layanan.' dan '.$id_paket;
        $paket = paketWisata::find($id_paket);
        $paket->getPaketLayanan()->detach($id_layanan);

        return redirect(route('admin.paket.layanan', $id_paket));
    }

    public function destroy($id_paket)
    {
        $paket = paketWisata::withCount(['getPaketLayanan'])->where('id_paket', $id_paket)->get();
        $count = null;
        foreach ($paket as $pakets) {
            $count = $pakets->get_paket_layanan_count;
        }
//        print_r($paket);
//        if ($count == 0) {
        $pakets = paketWisata::find($id_paket);
        $pakets->status = 2;
        $pakets->save();
        return redirect(route('admin.paket'));
//        }
//        return redirect(route('admin.paket'));
    }
    public function showC($id_kabupaten){
        $paket = paketWisata::where('kabupaten_id',$id_kabupaten)->get();
        return view('paket-wisata.detail_kabupaten',compact('paket'));
    }
}
