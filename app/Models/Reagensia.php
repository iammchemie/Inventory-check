<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reagensia extends Model
{
    protected $table = "reagensia";
    use HasFactory;
    protected $guarded = ['id'];

    #gunakan protected table bila tidak berbahasa inggris atau sistem akan menambahkan s dibelakang kata. contoh : barang. menjadi : barangs


    public function Reagensia()
    {
        return $this->hasMany(Reagensia::class);
    }
}
