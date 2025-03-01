<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kodepos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class KodeposController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('15', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kodepos',
                'label' => 'data kodepos',
            ];
            return view('kodepos.list_kodepos')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function data_ajax(Request $request)
    {
        $kodepos = Kodepos::select(['*']);
        return Datatables::of($kodepos)
            ->addColumn('status', function ($model) {
                $model->status === "1" ? $flag = 'success' : $flag = 'danger';
                $model->status === "1" ? $status = 'Aktif' : $status = 'Non Aktif';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'kodepos.button')
            ->rawColumns(['status', 'action'])
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = strtolower($request->get('search'));
                        if ($search === 'aktif') {
                            $w->Wherenotnull('status');
                        } elseif ($search === 'non' or $search === 'non aktif') {
                            $w->Wherenull('status')
                                ->orWhere('provinsi', 'LIKE', "%$search%")
                                ->orWhere('kabupaten', 'LIKE', "%$search%")
                                ->orWhere('kecamatan', 'LIKE', "%$search%")
                                ->orWhere('kelurahan', 'LIKE', "%$search%")
                                ->orWhere('kodepos', 'LIKE', "%$search%");
                        } else {
                            $w->orWhere('provinsi', 'LIKE', "%$search%")
                                ->orWhere('kabupaten', 'LIKE', "%$search%")
                                ->orWhere('kecamatan', 'LIKE', "%$search%")
                                ->orWhere('kelurahan', 'LIKE', "%$search%")
                                ->orWhere('kodepos', 'LIKE', "%$search%");
                        }
                    });
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('15', $session_menu)) {
        } else {
            return view('not_found');
        }
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'kodepos',
            'label' => 'tambah kodepos',
        ];
        return view('kodepos.add_kodepos')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('16', $session_menu)) {
            $request->validate([
                'provinsi' => 'required|max:100',
                'kabupaten' => 'required|max:100',
                'kecamatan' => 'required|max:100',
                'kelurahan' => 'required|max:100',
                'kodepos' => 'required|max:5',
            ]);
            DB::beginTransaction();
            try {
                $kodepos = new Kodepos();
                $kodepos->provinsi = $request->provinsi;
                $kodepos->kabupaten = $request->kabupaten;
                $kodepos->kecamatan = $request->kecamatan;
                $kodepos->kelurahan = $request->kelurahan;
                $kodepos->kodepos = $request->kodepos;
                $kodepos->status = '1';
                $kodepos->user_created = Auth::user()->id;
                $kodepos->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('kodepos');
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                // something went wrong
            }
        } else {
            return view('not_found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function show(Kodepos $kodepos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('17', $session_menu)) {
            $id_decrypted = Crypt::decryptString($request->id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kodepos',
                'label' => 'ubah kodepos',
                'kodepos' => Kodepos::findorfail($id_decrypted)
            ];
            return view('kodepos.edit_kodepos')->with($data);
        } else {
            return view('not_found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kodepos $kodepos)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('17', $session_menu)) {
            DB::beginTransaction();
            try {
                $kodepos = Kodepos::findorfail($request->id);
                $kodepos->provinsi = $request->provinsi;
                $kodepos->kabupaten = $request->kabupaten;
                $kodepos->kecamatan = $request->kecamatan;
                $kodepos->kelurahan = $request->kelurahan;
                $kodepos->kodepos = $request->kodepos;
                $kodepos->status = isset($request->Status) ? '1' : '0';
                $kodepos->user_updated = Auth::user()->id;
                $kodepos->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('kodepos');
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                // something went wrong
            }
        } else {
            return view('not_found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('18', $session_menu)) {
            $id_decrypted = Crypt::decryptString($request->id);
            DB::beginTransaction();
            try {
                $kodepos = Kodepos::findorfail($id_decrypted);
                $kodepos->status = 0;
                $kodepos->user_deleted = Auth::user()->id;
                $kodepos->deleted_at = Carbon::now();
                $kodepos->save();

                DB::commit();
                AlertHelper::deleteAlert(true);
                return back();
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::deleteAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function dropdown()
    {
        $provinsi = Kodepos::select('provinsi')->groupBy('provinsi')->get();
        return $provinsi;
    }

    public function provinsi(Request $request)
    {
        $provinsi = Kodepos::select('kabupaten')
            ->where('provinsi', '=', $request->Provinsi)
            ->groupBy('kabupaten')->get();
        return $provinsi;
    }

    public function kota(Request $request)
    {
        $kecamatan = Kodepos::select('kecamatan')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->groupBy('kecamatan')->get();
        return $kecamatan;
    }

    public function kecamatan(Request $request)
    {
        $kelurahan = Kodepos::select('kelurahan')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->where('kecamatan', '=', $request->Kecamatan)
            ->groupBy('kelurahan')->get();
        return $kelurahan;
    }

    public function kelurahan(Request $request)
    {
        $kodepos = Kodepos::select('kodepos')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->where('kecamatan', '=', $request->Kecamatan)
            ->where('kelurahan', '=', $request->Kelurahan)
            ->groupBy('kodepos')->get();
        return $kodepos;
    }

    public function get_villages_by_district($district)
    {
        $villages = Kodepos::select('kelurahan')
            ->where('kecamatan', $district)->get();

        if (count($villages) > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $villages
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function get_postal_code_by_village($village)
    {
        $postal_codes = Kodepos::select('kodepos')->where('kelurahan', $village)->groupBy('kodepos')->get();

        if (count($postal_codes) > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $postal_codes
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not Found',
                'data' => $village
            ]);
        }
    }
}
