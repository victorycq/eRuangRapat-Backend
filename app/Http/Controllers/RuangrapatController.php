<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ruang_Rapat;
use App\Fasilitas;
use App\Notulen;
use App\Master_Skpd;
use App\Transaksi;
use DB;

class RuangrapatController extends Controller
{
    public function getRuangan(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $ruangan = Ruang_Rapat::join('master_skpd', 'master_skpd.kode_skpd', '=', 'ruang_rapat.opd')
                //AFTER FIX : sebelumnya gk ada select
                ->select("ruang_rapat.id", "ruang_rapat.nama", "ruang_rapat.lokasi", "ruang_rapat.kapasitas", "ruang_rapat.koor_x", "ruang_rapat.koor_y", "ruang_rapat.contact", "master_skpd.nama_skpd")
                ->get();
                 return response()->json(['ruangan'=>$ruangan]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getFasilitas(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $fasilitas = Fasilitas::where('id_ruangrapat', '=', $request->get('idRuangan'))->firstOrFail();
                 return response()->json(['fasilitas'=>$fasilitas]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function detailRuangan(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $detailRuangan = Ruang_Rapat::join('fasilitas_rapat', 'ruang_rapat.id',   '=', 'fasilitas_rapat.id_ruangrapat')
                ->join('master_skpd', 'master_skpd.kode_skpd', '=', 'ruang_rapat.opd')
            ->where('fasilitas_rapat.id_ruangrapat', $request->get('id_ruangrapat'))
            ->firstOrFail();
                $skpd = Master_Skpd::find($detailRuangan['opd']);
                 return response()->json(['detailRuangan'=>$detailRuangan, 'opd'=>$skpd]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function Store(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            
            else{
                $detailRuangan =  json_decode($request->get('detailRuangan'));
                $ruangRapat = new Ruang_Rapat();
                $ruangRapat->nama = $detailRuangan->nama;
                $ruangRapat->lokasi = $detailRuangan->lokasi;
                if ($detailRuangan->opd != '') {
                    $ruangRapat->opd = $detailRuangan->opd;
                } else {
                    $ruangRapat->opd = $ruangRapat->opd;
                }
                $ruangRapat->kapasitas = $detailRuangan->kapasitas;
                $ruangRapat->keterangan = $detailRuangan->keterangan;
                $ruangRapat->koor_x = $detailRuangan->koorX;
                $ruangRapat->koor_y = $detailRuangan->koorY;
                $ruangRapat->contact = $detailRuangan->contact;
                $ruangRapat->save();


                $fasilitasRuangan = json_decode($request->get('fasilitasRuangan'));
                $fasilitasRapat = new Fasilitas();
                $fasilitasRapat->id_ruangrapat = $ruangRapat->id;
                $fasilitasRapat->meja_pimpinan = $fasilitasRuangan->mejaPimpinan;
                $fasilitasRapat->podium = $fasilitasRuangan->podium;
                $fasilitasRapat->ruang_transit= $fasilitasRuangan->ruangTransit;
                $fasilitasRapat->ruang_makan = $fasilitasRuangan->ruangMakan;
                $fasilitasRapat->meja_peserta = $fasilitasRuangan->mejaPeserta;
                $fasilitasRapat->kursi_peserta = $fasilitasRuangan->kursiPeserta;
                $fasilitasRapat->papan_tulis = $fasilitasRuangan->papanTulis;
                $fasilitasRapat->ac = $fasilitasRuangan->ac;
                $fasilitasRapat->lcd_tv = $fasilitasRuangan->lcdTv;
                $fasilitasRapat->projektor = $fasilitasRuangan->projektor;
                $fasilitasRapat->microphone = $fasilitasRuangan->microphone;

                $fasilitasRapat->save();
                
                 return response()->json($detailRuangan);
                
                 
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function Update(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $detailRuangan = $request->get('detailRuangan');
                $ruangRapat = Ruang_Rapat::find($request->get('idRuangan'));
                $ruangRapat->nama = $detailRuangan['nama'];
                $ruangRapat->lokasi = $detailRuangan['lokasi'];
                if ($detailRuangan['opd'] != '') {
                    $ruangRapat->opd = $detailRuangan['opd'];
                } else {
                    $ruangRapat->opd = $ruangRapat->opd;
                }
                $ruangRapat->kapasitas = $detailRuangan['kapasitas'];
                $ruangRapat->keterangan = $detailRuangan['keterangan'];
                $ruangRapat->koor_x = $detailRuangan['koorX'];
                $ruangRapat->koor_y = $detailRuangan['koorY'];
                $ruangRapat->contact = $detailRuangan['contact'];
                $ruangRapat->save();


                $fasilitasRuangan = $request->get('fasilitasRuangan');
                $fasilitasRapat = Fasilitas::where('id_ruangrapat', '=', $request->get('idRuangan'))->firstOrFail();
                $fasilitasRapat->meja_pimpinan = $fasilitasRuangan['mejaPimpinan'];
                $fasilitasRapat->podium = $fasilitasRuangan['podium'];
                $fasilitasRapat->ruang_transit= $fasilitasRuangan['ruangTransit'];
                $fasilitasRapat->ruang_makan = $fasilitasRuangan['ruangMakan'];
                $fasilitasRapat->meja_peserta = $fasilitasRuangan['mejaPeserta'];
                $fasilitasRapat->kursi_peserta = $fasilitasRuangan['kursiPeserta'];
                $fasilitasRapat->papan_tulis = $fasilitasRuangan['papanTulis'];
                $fasilitasRapat->ac = $fasilitasRuangan['ac'];
                $fasilitasRapat->lcd_tv = $fasilitasRuangan['lcdTv'];
                $fasilitasRapat->projektor = $fasilitasRuangan['projektor'];
                $fasilitasRapat->microphone = $fasilitasRuangan['microphone'];
        
                $fasilitasRapat->id_ruangrapat = $request->get('idRuangan');

                $fasilitasRapat->save();
                
                 return response()->json(['message'=>'success', 'status' => 200]);
                 
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function Destroy(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $ruangRapat = Ruang_rapat::find($request->get("idRuangan"));
                $fasilitas = Fasilitas::where('id_ruangrapat', $request->get("idRuangan"));
                $notulen = Notulen::where('lokasi', '=', $ruangRapat->id)->get();
                $isi = "";
                foreach ($notulen as $key => $value) {
                    DB::table('acara')->where('id_notulen', '=', $value['id'])->delete();
                    DB::table('kegiatan')->where('id_notulen', '=', $value['id'])->delete();
                }
                Transaksi::where('id_lokasi', '=', $ruangRapat->id)->delete();
                Notulen::where('lokasi', '=', $ruangRapat->id)->delete();
                $fasilitas->delete();
                $ruangRapat->delete();
                return response()->json(['message'=>'success', 'status' => 200]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }

}