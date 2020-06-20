<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Transaksi extends Model
{
    protected $table = "transaksi";
    public $timestamps = true;
    protected $primaryKey = "id";
    public function waktu()
    {
        return $this->belongsTo('App\Model\Waktu', 'waktu_id');
    }

    public function ruangrapat()
    {
        return $this->belongsTo('App\Model\Ruangrapat', 'id_lokasi');
    }
    public function notulen()
    {
        return $this->belongsTo('App\Model\Notulen', 'id_notulen');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}