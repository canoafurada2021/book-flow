<?php

class Book {
    private $id;
    private $name;
    private $author;
    private $genre;

    public function __construct($name, $author, $genre) {
        $this->name = $name;
        $this->author = $author;
        $this->genre = $genre;
    }


    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function get_author() {
        return $this->author;
    }

    public function set_author($author) {
        $this->author = $author;
    }

    public function get_genre() {
        return $this->genre;
    }

    public function set_genre($genre) {
        $this->genre = $genre;
    }

    // Métodos relacionados à persistência de dados (banco de dados, arquivo, etc.)

    public function save_to_database() {
 
    }

    public function update_in_database() {
    }

    public function delete_from_database() {
    }


    public function display_info() {
        // Exibe as informações do livro
        echo "ID: {$this->id}, Name: {$this->name}, Author: {$this->author}, Genre: {$this->genre}";
    }


}

?>