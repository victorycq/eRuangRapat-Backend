<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Master_Skpd extends Model
{
    protected $table = "master_skpd";
    public $timestamps = false;
    protected $primaryKey = "kode_skpd";
}