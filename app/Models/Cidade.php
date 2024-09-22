<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $fillable = ['cid_nome', 'estado_id'];
    protected $primaryKey = 'cidade_id';
    protected $table = 'cidades';

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function representantes()
    {
        return $this->belongsToMany(Representante::class, 'representante_cidade', 'cidade_id', 'representante_id');
    }
}
