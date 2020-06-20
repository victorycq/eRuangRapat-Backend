<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Fasilitas extends Model
{
    protected $table = "fasilitas_rapat";
    protected $primaryKey = "id";

    public function ruangrapat()
    {
        return $this->belongsTo('App\Model\Ruangrapat', 'id_ruangrapat');
    }
}