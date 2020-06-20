<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class File_Transaksi extends Model
{
    protected $table = "file_transaksi";
    public $timestamps = true;
    protected $primaryKey = "id";
}