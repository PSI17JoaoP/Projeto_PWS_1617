<?php

use ActiveRecord\Model;


class User extends Model
{
    static $validates_presence_of = array(
        array('nome_completo', 'message' => 'O nome introduzido é inválido ou está vazio', 'on' => 'create'),
        array('data_nascimento', 'message' => 'A data de nascimento introduzida é inválida ou está vazia', 'on' => 'create'),
        array('email', 'message' => 'O email introduzido é inválido ou está vazio', 'on' => 'create'),
        array('username', 'message' => 'O username introduzido é inválido ou está vazio', 'on' => 'create'),
        array('password', 'message' => 'A password introduzida está vazia', 'on' => 'create')
    );

    /*static $validates_uniqueness_of = array(
        array('email', 'message' => 'O email introduzido já existe'),
        array('username', 'message' => 'O username introduzido já existe')
    );*/
}
