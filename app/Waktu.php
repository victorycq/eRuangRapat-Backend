<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Waktu extends Model
{
    protected $table = 'waktu';
    public $timestamps = false;

    protected $fillable = [
        'id', 'nama', 'start', 'finish'

    ];
    public function transaksi()
    {
        return $this->hasMany('transaksi');
    }
}