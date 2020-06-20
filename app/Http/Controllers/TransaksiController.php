<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\Peserta_Rapat;
use App\Ruang_Rapat;
use App\Acara;
use App\Kegiatan;
use App\File_Pendukung;
use App\File_Transaksi;
use App\Notulen;
use App\Waktu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                    $user = $this->parseToken();
                    $detailPinjaman = json_decode($request->get('detailPinjaman'));
                    $detailPinjaman->tanggalRapat = explode("T",$detailPinjaman->tanggalRapat)[0];
                    
                    $notulen = new Notulen();
                    $notulen->waktu_start = $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuMulai->hour.":".$detailPinjaman->waktuMulai->hour;
                    $notulen->waktu_finish = $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuSelesai->hour.":".$detailPinjaman->waktuSelesai->hour;
                    $notulen->lokasi =$detailPinjaman->opd;
                    $notulen->nip_notulen = explode(" - ",$detailPinjaman->namaNotulen)[0];
                    $notulen->nama_notulen = explode(" - ",$detailPinjaman->namaNotulen)[1];
                    $notulen->nip_pimpinan = explode(" - ",$detailPinjaman->namaPemimpinRapat)[0];
                    $notulen->nama_pimpinan = explode(" - ",$detailPinjaman->namaPemimpinRapat)[1];
                    $notulen->status = "Tidak Aktif";
                    $notulen->id_user = $user->id;
                    $notulen->token = rand(1000000000,9999999999);
                    $notulen->save();
                    $waktu = new Waktu();
                    $waktu->nama = $detailPinjaman->judulRapat;
                    $waktu->start = $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuMulai->hour.":".$detailPinjaman->waktuMulai->hour;
                    $waktu->finish = $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuSelesai->hour.":".$detailPinjaman->waktuSelesai->hour;
                    $waktu->save();
            
                    $transaksi = new Transaksi();
                    $transaksi->judul_rapat = $detailPinjaman->judulRapat;
                    $transaksi->start =  $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuMulai->hour.":".$detailPinjaman->waktuMulai->hour;
                    $transaksi->finish = $detailPinjaman->tanggalRapat." ".$detailPinjaman->waktuSelesai->hour.":".$detailPinjaman->waktuSelesai->hour;
                    $transaksi->nip_pimpinan = explode(" - ",$detailPinjaman->namaPemimpinRapat)[0];
                    $transaksi->pimpinan_rapat = explode(" - ",$detailPinjaman->namaPemimpinRapat)[1];
                    if ($detailPinjaman->opd != '') {
                        $transaksi->opd_peminjam = $detailPinjaman->opd;
                    } else {
                        $transaksi->opd_peminjam = $user->opd;
                    }
                    $transaksi->nip_pj = explode(" - ",$detailPinjaman->namaPeminjam)[0];
                    $transaksi->nip_pemesan = explode(" - ",$detailPinjaman->namaPeminjam)[0];
                    $transaksi->waktu_id = $waktu->id;
                    $transaksi->id_user = $user->id;
                    $transaksi->nama_peminjam = $user->first_name . ' ' . $user->last_name;
                    $transaksi->keterangan = $detailPinjaman->keterangan;
                    $transaksi->date_order = date('Y-m-d H:i:s', time());
                    $transaksi->id_lokasi = $detailPinjaman->idLokasi;
                    $transaksi->status = 'Belum disetujui';
                    $transaksi->id_notulen = $notulen->id;
                    $transaksi->save();

                        for ($i=0; $i < $request->fileLength; $i++) { 
                            $file      = $request->file('file'.$i);
                            $filename  = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $path      = $file->storeAs("file_transaksi/".$transaksi->id."/".$request->idNotulen,$filename);
        
                            $fileTransaksi = new File_Transaksi();
                            $fileTransaksi->namafile = $filename;
                            $fileTransaksi->transaksi_id = $transaksi->id;
                            $fileTransaksi->path = $path;
                            $fileTransaksi->save(); 
                        }


                    return response()->json($detailPinjaman);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getAll()
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $rapat = Transaksi::
                join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                ->select('transaksi.id','transaksi.id_notulen', 'transaksi.judul_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd',)
                ->get();

                 return response()->json(['rapat'=>$rapat]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getdetailstatus()
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $rapat = Transaksi::join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                ->where('status',"=",'Disetujui')
                ->select('transaksi.id', 'transaksi.judul_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd','pimpinan_rapat', 'lokasi', 'nama_skpd')
                ->get();

                 return response()->json(['rapat'=>$rapat]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getDetailTransaksi()
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                if($user['role_id'] == '3')
                {
                    $rapat = Transaksi::join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                    ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                    ->where('status',"=",'Disetujui')
                    ->select('transaksi.id', 'transaksi.judul_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd','pimpinan_rapat', 'lokasi', 'nama_skpd')
                    ->get();

                }
                else
                {
                    $rapat = Transaksi::join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                    ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                    ->where('status',"=",'Disetujui')
                    ->where('master_skpd.kode_skpd', '=', $user['opd'])
                    ->select('transaksi.id', 'transaksi.judul_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd','pimpinan_rapat', 'lokasi', 'nama_skpd')
                    ->get();

                }

                 return response()->json(['rapat'=>$rapat]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function getRapatOpd(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $rapat = Transaksi::join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                ->where('master_skpd.kode_skpd', '=', $request->get('idOpd'))
                ->select('transaksi.id', 'transaksi.judul_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd',)
                ->get();

                 return response()->json(['rapat'=>$rapat]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function detailRapat(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                // $detailRapat = Transaksi::join('notulen', 'notulen.id', '=', 'transaksi.id_notulen')
                // ->where('transaksi.id', '=', $request->get('idRapat'))
                // ->firstOrFail();
                $detailRapat = Notulen::where('id', '=', $request->get('idNotulen'))
                ->firstOrFail();
                $acara = Acara::where('id_notulen', '=',$request->get('idNotulen'))->get();
                $kegiatan = Kegiatan::where('id_notulen', '=',$request->get('idNotulen'))->get();
                $filePendukung = File_Pendukung::where('notulen_id', '=', $request->get('idNotulen'))->get();
                $pesertaRapat = Peserta_Rapat::where('id_notulen', '=', $request->get('idNotulen'))->get();
                 return response()->json(['detailRapat'=>$detailRapat, 'acara'=>$acara, 'kegiatan' => $kegiatan, 'filePendukung' => $filePendukung, 'pesertaRapat'=>$pesertaRapat]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function detailPermohonan(Request $request)
    {
        try {
            $user = $this->parseToken();
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $permohonan = Transaksi::join('ruang_rapat', 'transaksi.id_lokasi', '=', 'ruang_rapat.id')
                ->join('master_skpd', 'master_skpd.kode_skpd', "=", "transaksi.opd_peminjam")
                ->join('notulen', 'transaksi.id_notulen', '=', 'notulen.id')
                ->select('nip_pemesan', 'transaksi.judul_rapat', 'notulen.nip_notulen', 'notulen.nama_notulen', 'transaksi.nip_pimpinan', 'transaksi.pimpinan_rapat', 'transaksi.status', 'start', 'finish', 'ruang_rapat.nama', 'transaksi.start', 'transaksi.finish','master_skpd.nama_skpd',)
                ->where('transaksi.id', '=', $request->get('idPermohonan'))
                ->firstOrFail();
                $fileTransaksi = File_Transaksi::where('transaksi_id', '=', $request->get('idPermohonan'))->get();
                 return response()->json(['permohonan'=>$permohonan, 'fileTransaksi'=>$fileTransaksi]);
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
                $transaksi = Transaksi::find($request->get('idPermohonan'));

                $transaksi->status = $request->get('status');
                
                $transaksi->save();

                 return response()->json(['message'=>'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function tambahFilePendukung(Request $request)
    {
        try {
            $user = $this->parseToken();
            $filename = "";
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                for ($i=0; $i < $request->fileLength; $i++) { 
                    $file      = $request->file('file'.$i);
                    $filename  = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $path      = $file->storeAs("notulen/".$request->idNotulen,$filename);

                    $filePendukung = new File_Pendukung();
                    $filePendukung->name = $filename;
                    $filePendukung->notulen_id = $request->idNotulen;
                    $filePendukung->path = $path;
                    $filePendukung->save(); 
                }
                return response()->json(['message'=>'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function tambahPeserta(Request $request)
    {
        try {
            $user = $this->parseToken();
            $filename = "";
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                    $pesertaRapat = new Peserta_Rapat();
                    $pesertaRapat->id_notulen = $request->get('idNotulen');
                    $pesertaRapat->nip = explode(" - ",$request->get('namaPeserta'))[0];
                    $pesertaRapat->nama = explode(" - ",$request->get('namaPeserta'))[1];
                    $pesertaRapat->save(); 
                return response()->json(['message'=>'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function editDetailRapat(Request $request)
    {
        try {
            $user = $this->parseToken();
            $filename = "";
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                $detailRapat = $request->get('detailRapat');
                $notulen = Notulen::find($request->get('idNotulen'));
                $notulen->nip_pimpinan = explode(" - ",$detailRapat['ketua'])[0];
                $notulen->nama_pimpinan = explode(" - ",$detailRapat['ketua'])[1];
                $notulen->nip_notulen = explode(" - ",$detailRapat['pencatat'])[0];
                $notulen->nama_notulen = explode(" - ",$detailRapat['pencatat'])[1];
                $notulen->nip_sekretaris = explode(" - ",$detailRapat['sekretaris'])[0];
                $notulen->nama_sekretaris = explode(" - ",$detailRapat['sekretaris'])[1];
                $notulen->kata_pembuka = $detailRapat['kataPembuka'];
                $notulen->peraturan = $detailRapat['peraturan'];
                $notulen->hasil_rapat = $detailRapat['pembahasan'];
                $notulen->save();
                for($i=0; $i<sizeof($detailRapat['kegiatan']); $i++)
                {
                    $kegiatan = Kegiatan::where('id_notulen', '=', $request->get('idNotulen'))
                    ->where('nama', '=', $detailRapat['kegiatan'][$i]['nama'])
                    ->get();
                    if(sizeof($kegiatan) == 0)
                    {
                        $kegiatan = new Kegiatan();
                        $kegiatan->id_notulen = $request->get('idNotulen');
                        $kegiatan->nama = $detailRapat['kegiatan'][$i]['nama'];
                        $kegiatan->save();
                    }
                }
                for($i=0; $i<sizeof($detailRapat['acara']); $i++)
                {
                    $acara = Acara::where('id_notulen', '=', $request->get('idNotulen'))
                    ->where('nama', '=', $detailRapat['acara'][$i]['nama'])
                    ->get();
                    if(sizeof($acara) == 0)
                    {
                        $acara = new Acara();
                        $acara->id_notulen = $request->get('idNotulen');
                        $acara->nama = $detailRapat['acara'][$i]['nama'];
                        $acara->save();
                    }
                }
                return response()->json(['message' =>"success"]);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function hapusAcara(Request $request)
    {
        try {
            $user = $this->parseToken();
            $filename = "";
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                    $acara = Acara::where('nama', '=', $request->get('namaAcara'));
                    $acara->delete();
                return response()->json(['message'=>'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    public function hore()
    {
        return Response()->json('haha');
    }
    public function hapusKegiatan(Request $request)
    {
        try {
            $user = $this->parseToken();
            $filename = "";
            if(isset($user['message'])){
                return response()->json(['message' => $user['message']], $user['code']);
            }
            else{
                    $kegiatan = Kegiatan::where('nama', '=', $request->get('namaKegiatan'));
                    $kegiatan->delete();
                return response()->json(['message'=>'success']);
            }
        } catch (\Exception $ex) {
            dd($ex);
            return $this->error("Terjadi kesalahan", 404);
        }
    }
    function path_fixer($path) {
        // Laravel uses / separator by default.
        
        if (DIRECTORY_SEPARATOR != '/') { // Let's check the current system default is this.
            return str_replace('/', DIRECTORY_SEPARATOR, $path); // Change the separator for current system.
        }
    
        return $path; // Use coming path.
    }
    public function downloadFilePendukung(Request $request, $idNotulen,$extension, $namaFile )
    {
        $nameFile = str_replace('%20'," ", $namaFile).".".$extension;
        $pathToFile = $this->path_fixer(storage_path('app/notulen/'.$idNotulen.'/'.$nameFile)); 
        //  $pathToFile = $this->path_fixer(storage_path('app/notulen/'.'56'.'/'.'informatika2.pdf'));    
         return response()->download($pathToFile);
                //  $namaFile = str_replace('%20'," ", $namaFile);
        // return response()->json($namaFile);
    }
    public function downloadFileTransaksi(Request $request,$idTransaksi, $extension, $namaFile)
    {
        $nameFile = str_replace('%20'," ", $namaFile).".".$extension;
        $name = 'Slow Motion Sound Effect (original).mp3';
        $pathToFile = $this->path_fixer(storage_path('app/file_transaksi/'.$idTransaksi.'/'.$nameFile)); 
         return response()->download($pathToFile);
        // $namaFile = str_replace('%20'," ", $namaFile);
        // return response()->json($namaFile);
    }
}