<?php
include_once(__DIR__."/../model/Crud.php");

class Book {
    private $id;
    private $name;
    private $author;
    private $genre;
private $table_name = "book";


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
    public function to_array(){            
        return get_object_vars($this);    
      }
  
      public function get_table_name(){ return $this->table_name; }

    public function create_book() {
        $Crud = new Crud();

        echo "SQL Query: $query";

        $book_data = $this->to_array(); // Você precisa implementar a função to_array() para a classe Book
        try {
            return $Crud->create($table = $this->get_table_name(), $book_data);
        } catch (Exception $e) {
            throw new Exception("Erro ao criar livro: " . $e->getMessage());
        }
    }

    public function list_books($filters = []) {

        $bind = [];

        if ($filters) {
            $sql_filter = self::create_sql_filter($filters);
            $where .= $sql_filter["where"];
            $bind = $sql_filter["bind"];
        }

        $Crud = new Crud();
        $where = '';
        $field_list = "*";

        $books = $Crud->read($table = $this->get_table_name(), $where, $bind, $fields = $field_list);

        return $books;
    }
    public static function create_sql_filter($filters = []) {
        $where = '';
        $bind = [];
      
        if (!empty($filters)) {
            $where_parts = [];
            foreach ($filters as $field => $value) {
                $parameter = ':' . $field;
                $where_parts[] = "{$field} = {$parameter}";
                $bind[$parameter] = $value;
            }
      
            $where = implode(" AND ", $where_parts);
            $where = " AND {$where}"; // Adiciona um espaço no início para evitar problemas de concatenação.
        }
      
        return ["where" => $where, "bind" => $bind];
      }
    public function get_book_by_id($book_id) {
        $Crud = new Crud();
        $where = 'id = :id';
        $bind = [':id' => $book_id];
        $field_list = "*";

        $book = $Crud->read($table = $this->get_table_name(), $where, $bind, $fields = $field_list);

        return $book;
    }
}

?>