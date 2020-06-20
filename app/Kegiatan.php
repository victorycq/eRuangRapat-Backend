<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Kegiatan extends Model
{
    protected $table = "kegiatan";
    public $timestamps = false;
    protected $primaryKey = "id";

    public function ruangrapat()
    {
        return $this->belongsTo('App\Model\Notulen', 'id_notulen');
    }
}