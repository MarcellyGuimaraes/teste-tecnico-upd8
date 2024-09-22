<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = ['rep_nome'];
    protected $primaryKey = 'representante_id';
    protected $table = 'representantes';

    public function cidades()
    {
        return $this->belongsToMany(Cidade::class, 'representante_cidade');
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'representante_cliente');
    }
}
