<?php 
// класс(синглтон) для работы с базой данных через PDO
class DB {

        protected static $_instance;
 
        public static function getInstance() {
            if (self::$_instance === null) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }
 
        private function __clone() {}
       
        private function __wakeup() {}
   
        private  function __construct() {
            try
            {
                $this->PDO = new PDO('mysql:host='.HOST.';dbname='.NAME_BD, USER, PASSWORD, array(
                    PDO::ATTR_PERSISTENT => true
                ));
                $this->PDO->exec("SET CHARACTER SET utf8");
            } catch (PDOException $e) {
              echo 'Error : '.$e->getMessage();
            }
        }
   
        // запрос в БД
        public static function query($sql) {
       
            $obj=self::$_instance;
       
            if(isset($obj->PDO))
            {
                $result = $obj->PDO->query($sql);
                $result = $result->FetchAll(PDO::FETCH_OBJ);
                return $result;
            }
            return false;
        }
        
        // запрос с параметрами в БД
        public static function insert($sql, $data) {
       
            $obj=self::$_instance;
       
            if(isset($obj->PDO))
            {
              try
              {
                $result = $obj->PDO->prepare($sql);
                $result = $result -> execute($data);
                return $result;
              }
                catch(PDOException $e){
                echo 'Error : '.$e->getMessage();
              }
            }
            return false;
        }
        
       
   
}