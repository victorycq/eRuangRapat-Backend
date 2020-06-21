<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Notulen extends Model
{
    protected $table = "notulen";
    protected $primaryKey = "id";
    protected $timestamp = true;

    public function pesertarapat()
    {
        return $this->hasOne('App\Model\Pesertarapat');
    }
    public function transaksi()
    {
        // return $this->hasMany('App\Model\Transaksi', 'id_notulen');
        return $this->hasMany('App\Model\Transaksi');

    }
}