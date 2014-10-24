<?php

class Model_News extends Model {
  const TABLES = 'news';
  
  // список новостей с лиммитом
  public function getAll($page = 1, $limit = PAGER) {
    $start = ($page - 1) * $limit;
    $result = $this->query("SELECT id,title, date FROM " . self::TABLES . " LIMIT " . $start . "," .$limit);
    return $result;
  }
  
  // колличество новостей
  public function getCount() {
    $result = $this->query("SELECT count(*) as count FROM " . self::TABLES);
    return (int)$result[0]->count;
  }
  
  // новость по id
  public function getById($id) {
    $result = $this->query("SELECT id,title, date, text FROM " . self::TABLES . " WHERE id=" . (int)$id);
    return $result[0];
  }
  
  // создание новости
  public function create($title, $text) {
    $date = date('Y-m-d H:i:s');
    $result = $this->insert("INSERT INTO " . self::TABLES . "  (title,text,date) VALUES (?,?,?)",
                          array($title, $text, $date));
    return $result;
  }
  
  // редактирование новости
  public function update($id, $title, $date, $text) {
    $result = $this->insert("UPDATE " . self::TABLES . "  SET title=?, date=?, text=? WHERE id=?",
                          array($title, $date, $text, $id));
    return $result;
  }
  
  // удаление новости
  public function delete($id) {
    $result = $this->insert("DELETE FROM " . self::TABLES . " WHERE id=?",
                          array($id));
    return $result;
  }
}