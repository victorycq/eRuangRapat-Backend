<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Pegawai;
use App\Master_Skpd;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class MasterDataController extends Controller
{
    public function getPegawai(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                // $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_1', '=', 'master_skpd.kode_skpd')
                // ->get();

                $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_1', '=', 'master_skpd.kode_skpd')
                ->get();
                 return response()->json(['pegawai'=>$pegawai]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getPegawaiPage(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                // $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_1', '=', 'master_skpd.kode_skpd')
                // ->get();
                $date = explode("-",date("Y-m-d"));
                $date =  $date[1];
                if(substr($date,0,1) == "0")
                {
                    $date = substr($date,1,2);
                }
                $start = 0;
                if($request->get('page') != 1)
                {
                    $start = ($request->get('page') * $request->get('pageSize')) - 4;
                }
                if($request->get('opd') == "All")
                {
                    /**
                     * pegawai.kolok_[nomor bulan] -> artiyna status posisi skpd seorang pegawai di bulan itu
                     * ada variable $date untuk mendapatkan bulan saat ini, tapi bulan 6 kolok nya pada kosong jadi di set 1
                     */
                    $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_'.'1', '=', 'master_skpd.kode_skpd')
                    ->skip($start)->take($request->get('pageSize'))
                    ->get();
                }
                else
                {
                    $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_'.'1', '=', 'master_skpd.kode_skpd')
                    ->where('master_skpd.nama_skpd', '=', $request->get('opd'))
                    ->skip($start)->take($request->get('pageSize'))
                    ->get();
                }
                 return response()->json(['pegawai'=>$pegawai]);
                // return response()->json(['pegawai'=>$request->get('page')]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getSKPD(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $SKPD = Master_Skpd::All();
                 return response()->json(['SKPD'=>$SKPD]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getSKPDPage(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                // $pegawai = Pegawai::join('master_skpd', 'pegawai.kolok_1', '=', 'master_skpd.kode_skpd')
                // ->get();
                $start = 0;
                if($request->get('page') != 1)
                {
                    $start = ($request->get('page') * $request->get('pageSize')) - 4;
                }
                $SKPD = $SKPD = Master_Skpd::skip($start)
                ->take($request->get('pageSize'))
                ->get();
                 return response()->json(['SKPD'=>$SKPD]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function StoreSKPD(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $SKPD = new Master_Skpd();
                $SKPD->kode_skpd = $request->skpd['kode'];
                $SKPD->nama_skpd = $request->skpd['nama'];
                $SKPD->kepala_nip = $request->skpd['nipKepalaSkpd'];
                $SKPD->kepala_pangkat = $request->skpd['pangkatKepalaSkpd'];
                $SKPD->kepala_nama = $request->skpd['namaKepalaSkpd'];
                $SKPD->kepala_jabatan = $request->skpd['jabatanKepalaSkpd'];
                $SKPD->bendahara_nip = $request->skpd['nipBendahara'];
                $SKPD->bendahara_nama = $request->skpd['namaBendahara'];
                $SKPD->bendahara_jabatan = $request->skpd['jabatanBendahara'];
                $SKPD->bendahara_pangkat = $request->skpd['pangkatBendahara'];
                $SKPD->jumlevel = $request->skpd['jumlahLevel'];
                $SKPD->save();
                return response()->json(['message' => 'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
}