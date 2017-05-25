<?php

use ActiveRecord\Model;


class Movement extends Model
{
    static $validates_presence_of = array(
        array('data', 'message' => 'A data introduzida é inválida ou está vazia', 'on' => 'create'),
        array('tipo', 'message' => 'O tipo introduzido é inválido ou está vazio', 'on' => 'create'),
        array('descricao', 'message' => 'A descrição introduzida é inválida ou está vazia', 'on' => 'create'),
        array('valor', 'message' => 'O valor introduzido está vazio', 'on' => 'create'),
        array('saldo', 'message' => 'O saldo introduzido está vazio', 'on' => 'create')
    );
}
