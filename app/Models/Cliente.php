<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['cli_cpf', 'cli_nome', 'cli_nascimento', 'cli_sexo', 'cli_endereco', 'cidade_id', 'estado_id'];
    protected $primaryKey = 'cliente_id';
    protected $table = 'clientes';

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function representantes()
    {
        return $this->belongsToMany(Representante::class, 'representante_cliente','cidade_id', 'representante_id');
    }
}
