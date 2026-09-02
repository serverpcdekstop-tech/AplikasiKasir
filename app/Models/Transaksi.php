<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $guarded = [];

    public function transaksi_detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}