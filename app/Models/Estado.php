<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['est_nome', 'est_sigla'];
    protected $primaryKey = 'estado_id';
    protected $table = 'estados';

    public function cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}
