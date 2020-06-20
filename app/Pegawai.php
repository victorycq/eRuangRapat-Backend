<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Pegawai extends Model
{
    protected $table = "pegawai";
    public $timestamps = false;
    protected $primaryKey = "nip18";
}