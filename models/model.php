<?php

require_once 'db.php';
require_once 'cache.php';

class Model{
  
  public  function __construct() {
    DB::getInstance();
    Cache::getInstance(); 
  }
  
  // запрос на получение данных из БД и кеша
  protected  function query($sql) {
    $cache = Cache::get($sql);
    if($cache)
    {
      $result = $cache;
    }
    else
    {
      $result = DB::query($sql);
      Cache::set($sql, $result);
    }
    
    return $result ;
  }
  
  // запрос на изменения данных в БД и очистка кеша
  protected  function insert($sql, $params) {
    $result = DB::insert($sql, $params);
    Cache::delete();
    
    return $result ;
  }
}