<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Vaga {
    /**
     * IDENTIFICADOR ÚNICO DA VAGA
     * @var integer
     */

     public $id;

     /**
     * TÍTULO DA VAGA
     * @var string
     */

     public $titulo;

     /**
     * DESCRIÇÃO DA VAGA
     * @var string
     */

     public $descricao;

     /**
     * IDENTIFICA SE VAGA ESTÁ ATIVA
     * @var string(s/n)
     */

     public $ativo;

     /**
     * DATA DE PUBLICAÇÃO DA VAGA
     * @var string
     */

     public $vaga;

      /**
     * MÉTODO DE CADASTRO DE VAGA NO BANCO
     * @return boolean
     */

     public function cadastrarVaga() {
         // DEFININDO O FUSO HORÁRIO
         date_default_timezone_set('America/Sao_Paulo');

         // DEFININDO A DATA
         $this->data = date('Y-m-d H:i:s');

         // INSERINDO A VAGA NO BANCO
         $objetoDatabase = new Database('empregos');
         $this->id = $objetoDatabase->insert([
                    'titulo' => $this->titulo,
                    'descricao' => $this->descricao,
                    'ativo' => $this->ativo,
                    'data' => $this->data
                  ]);

        //echo "<pre>"; print_r($this); echo "</pre>"; exit; DEBUG

        // RETORNAR SUCESSO
        return true;
     }

     /**
      * MÉTODO RESPONSÁVEL POR ATUALIZAR A VAGA NO BANCO DE DADOS
      *@return boolean
      */

     public function atualizarVaga() {
        return (new Database('empregos'))->update('id = '.$this->id, [
            'titulo' => $this->titulo,
                    'descricao' => $this->descricao,
                    'ativo' => $this->ativo,
                    'data' => $this->data
        ]);
     }

     /**
      * MÉTODO RESPONSÁVEL POR OBTER AS VAGAS DO BANCO DE DADOS
      *@param string $where
      *@param string $order
      *@param string $limit
      *@return array
      */

     public static function getVagas($where = null, $order = null, $limit = null) {
        return (new Database('empregos'))->select($where, $order, $limit)
                                        ->fetchAll(PDO::FETCH_CLASS, self::class);
     }

     /**
      * MÉTODO RESPONSÁVEL POR EXCLUIR A VAGA DO BANCO DE DADOS
      *@return boolean
      */

     public function excluir() {
        return (new Database('empregos'))->delete('id = '.$this->id);
     }

      /**
      * MÉTODO RESPONSÁVEL POR BUSCAR UMA VAGA COM BASE EM SEU ID
      *@param integer $id
      *@return Vaga
      */

     public static function getVaga($id) {
        return (new Database('empregos'))->select('id = '.$id)
                                ->fetchObject(self::class);
     }
}