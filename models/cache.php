<?php 
// класс(синглтон) для работы с Memcashe
class Cache {

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
            $this->memcacheObj = new Memcache;
            $this->memcacheObj->connect(HOST, MEMCAHE_PORT) or die("Could not connect Memcache");
        }
        
        // добавления данных по ключу в кешь
        public static function set($key, $row) {
          $obj=self::$_instance;
       
          if(isset($obj->memcacheObj))
          {
            $key = md5($key);
            $obj->memcacheObj->set($key, $row, false, MEMCAHE_TIME);
            return true;
          }
          return false;
        }
        
        // получение данныx по ключу из кеша
        public static function get($key) {
          $obj=self::$_instance;
       
          if(isset($obj->memcacheObj))
          {
            $key = md5($key);
            $result = $obj->memcacheObj->get($key);
            return $result;
          }
          return false;
        }
        
        // очистка кеша
        public static function delete() {
          $obj=self::$_instance;
       
          if(isset($obj->memcacheObj))
          {
            $obj->memcacheObj->flush();
            return true;
          }
          return false;
        }
}