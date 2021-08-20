<?php 

namespace App\Db;

use \PDO;
use \PDOException;

class Database {

     /**
     * HOST DE CONEXÃO COM O BANCO DE DADOS
     * @var string
     */

    const HOST = 'localhost';

     /**
     * NOME DO BANCO DE DADOS
     * @var string
     */

     const NAME = 'vagas';

       /**
     * USUÁRIO DO BANCO
     * @var string
     */

     const USER = 'root';

      /**
     * SENHA DE ACESSO AO BANCO DE DADOS
     * @var string
     */

     const PASS = '';

      /**
     * NOME DA TABELA A SER MANIPULADA
     * @var string
     */

     private $table;

      /**
     * INSTÂNCIA DE CONEXÃO COM O BANCO DE DADOS
     * @var PDO
     */

     private $connection;

      /**
     * DEFININDO A TABELA E INSTANCIANDO A CONEXÃO
     * @param string
     */

     public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
     }

        /**
     * MÉTODO RESPONSÁVEL POR CRIAR A CONEXÃO COM O BANCO DE DADOS
     */

     private function setConnection() {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
     }

           /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR QUERIES DENTRO DO BANCO DE DADOS
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */

     public function execute($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch (PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
     }

        /**
     * MÉTODO RESPONSÁVEL POR INSERIR DADOS NO BANCO DE DADOS
     * @param array $values [ field => values ]
     * @return integer ID inserido
     */

     public function insert($values) {
         // DADOS DA QUERY
         $fields = array_keys($values);
         $binds = array_pad([],count($fields), '?');

        // MONTAGEM DA QUERY
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
        
        // EXECUTANDO O INSERT
        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
     }

     /**
      * MÉTODO RESPONSÁVEL POR EXECUTAR UMA CONSULTA NO BANCO
      *@param string $where
      *@param string $order
      *@param string $limit
      *@param string $fields
      *@return PDOStatement
      */

     public function select($where = null, $order = null, $limit = null, $fields = '*') {
         // DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $where = strlen($order) ? 'ORDER BY '.$order : '';
        $where = strlen($limit) ? 'LIMIT '.$limit : '';

        // MONTAGEM DA QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        // EXECUTANDO A QUERY
        return $this->execute($query);
     }

     /**
      * MÉTODO RESPONSÁVEL POR EXECUTAR ATUALIZAÇÕES NO BANCO DE DADOS
      *@param string $where
      *@param array $values [ field => value ]
      *@return boolean
      */

     public function update($where, $values) {
        // DADOS DA QUERY
        $fields = array_keys($values);

        // MONTAGEM DA QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
      
        // EXECUTANDO A QUERY
        $this->execute($query, array_values($values));

        return true;
     }

     /**
      * MÉTODO RESPONSÁVEL POR EXCLUIR DADOS DO BANCO
      *@param string $where
      *@return boolean
      */

     public function delete($where) {
         // MONTAGEM DA QUERY
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        // EXECUTANDO A QUERY
        $this->execute($query);

        return true;
     }
}