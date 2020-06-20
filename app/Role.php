<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $table = "role";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'nama'

    ];

    public function user()
    {
        return $this->hasMany('App\User'); //pake local_key kalo nama id usernya bukan ' id'
    }
}