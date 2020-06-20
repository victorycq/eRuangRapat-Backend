<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Acara extends Model
{
    protected $table = "acara";
    public $timestamps = false;
    protected $primaryKey = "id";

    public function notulen()
    {
        return $this->belongsTo('App\Model\Notulen', 'id_notulen');
    }
}