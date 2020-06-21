<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Ruang_Rapat extends Model
{
    protected $table = "ruang_rapat";
    public $timestamps = false;
    protected $primaryKey = "id";

    public function transaksi()
    {
        return $this->hasMany('App\Model\Transaksi');
    }

    public function fr()
    {
        return $this->hasOne('App\Model\FasilitasRapat');
    }
    
    // public function masterskpd()
    // {
    //     return $this->belongsTo('App\Model\Master_Skpd', 'opd');
    // }
}