<?php

class Script{
    private $id;
    private $describtion;
    private $script;
    private $dateAdded;
    private $dbConnection;
    private $dbTable = 'script';


public function __construct($dbConnection){
    $this->dbConnection = $dbConnection;
}
public function getId() {
    return $this->id;
}
public function getDescribtion() {
    return $this->describtion;
}
public function getScript() {
    return $this->script;
}
public function getDateAdded() {
    return $this->dateAdded;
}
public function setId($id) {
    $this->id = $id;
}
public function setDescribtion($describtion) {
    $this->describtion = $describtion;
}
public function setScript($script) {
    $this->script = $script;
}
public function setDateAdded($dateAdded) {
    $this->dateAdded = $dateAdded;
}

public function create(){
    $query = "INSERT INTO ". $this->dbTable. "(describtion, script, date_added) VALUES(:describtion,:script, now());";
    
    $stmt = $this->dbConnection->prepare($query);
    $stmt->bindParam(":describtion", $this->describtion);
    $stmt->bindParam(":script", $this->script);
    
    if($stmt->execute()){
        return true;
    }
    printf("Error: s%", $stmt->error);
    return false;
}

public function readAll(){
    $query = "SELECT id, describtion, script, date_added FROM ". $this->dbTable;
    $stmt = $this->dbConnection->prepare($query);
    if($stmt->execute() && $stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

public function delete() {
    $query = "DELETE FROM ". $this->dbTable ." WHERE id=:id";
    $stmt = $this->dbConnection->prepare($query);
    $stmt->bindParam(":id", $this->id);
    if($stmt->execute() && $stmt->rowCount() == 1){
    return true;
    }
    return false;
}

}