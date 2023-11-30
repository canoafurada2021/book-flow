<?php

class Crud {
    private $config = [
        "dbdriver" => "mysql", 
        "dbuser" => "root",
        "dbpass" => "aluno",
        "dbname" => "book_flow",
        "dbhost" => "localhost",
        "charset" => "utf8mb4"
    ];

    public function __construct(){
        $this->db();
    }

    function db() {
        $dbhost = $this->config['dbhost'];
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];
        $dbname = $this->config['dbname'];
        $charset = $this->config['charset'];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            if ($this->config["dbdriver"] == "mysql") {
                $conn = "mysql:host={$dbhost};dbname={$dbname};charset={$charset}";
            } else {
                echo "Unsupported DB Driver! Check the configuration.";
                exit(1);
            }

            $this->db = new PDO($conn, $dbuser, $dbpass, $options);
        } catch(PDOException $e) {
            throw $e;
        }
    }


  //Função para fazer um insert no banco
  function create($table, $data) {
    $fields = $this->filter($table, $data);

    $sql = "INSERT INTO " . $table . " (" . implode( ", ", $fields) . ") VALUES (:" . implode(", :", $fields) . ");";

    $bind = [];
    foreach($fields as $field)
      $bind[":$field"] = $data[$field];

    $result = $this->run($sql, $bind);
    return $this->db->lastInsertId();
  }

  function read($table, $where="", $bind=[], $fields="*") {
    $sql = "SELECT " . $fields . " FROM " . $table;
    if(!empty($where))
      $sql .= " WHERE " . $where;
    $sql .= ";";

    $result = $this->run($sql, $bind);
    $result->setFetchMode(PDO::FETCH_ASSOC);

    $rows = [];
    while($row = $result->fetch()) {
      $rows[] = $row;
    }

    return $rows;
  }

  // Função para fazer update de algo em alguma tabela do banco
  function update($table, $data, $where, $bind=[]) {
   // $data['update_date'] = date("Y-m-d h:i:ss"); // set update date 
    $fields = $this->filter($table, $data);
    $fieldSize = sizeof($fields);

    $sql = "UPDATE " . $table . " SET ";
    for($f = 0; $f < $fieldSize; ++$f) {
        if($f > 0)
            $sql .= ", ";
        $sql .= $fields[$f] . " = :update_" . $fields[$f]; 
    }
    //$sql .= " WHERE " . $where . ";";

    
    $result = $this->run($sql, $bind);
    return $result->rowCount();
  }

  function delete($table, $where, $bind="") {
    $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
    $result = $this->run($sql, $bind);
    return $result->rowCount();
  }

  private function filter($table, $data) {
    $driver = $this->config['dbdriver'];

    if($driver == 'sqlite') {
      $sql = "PRAGMA table_info('" . $table . "');";
      $key = "name";
    } elseif($driver == 'mysql') {
      $sql = "DESCRIBE " . $table . ";";
      $key = "Field";
    } else {    
      $sql = "SELECT DISTINCT COLUMN_NAME FROM information_schema.columns WHERE table_name = '" . $table . "';";
      $key = strtoupper("column_name");
    }   

    if(false !== ($list = $this->run($sql))) {
      $fields = [];
      //Helper::debugData($list);
      foreach($list as $record)
        $fields[] = $record[$key];
      return array_values(array_intersect($fields, array_keys($data)));
    }

    return [];
  }

  public function execute_query($sql, $bind = []){        
    if ( empty($sql) )
      throw new Exception("Instrução SQL não informada");

    return $this->run($sql, $bind)->fetchAll(PDO::FETCH_ASSOC);

  }

  public static function create_where_like($field, $value, $delimiter = " ", $prefix = "" ){                    
    $search_expression = [ $field ];
    $search_values = explode($delimiter, trim($value));
    $filter = "";

    if ($search_values ){            
      $binding_values = [];
      $counter = 0;
      foreach ($search_expression as $key => $data ) {
        foreach ( $search_values as $key2 => $value ){                    
          $parameter = $prefix . "_" . $counter . "_X" ;                    

          $filter .= " AND " . $data . " LIKE :" . $parameter . " \r\n";
          $binding_values[':'. $parameter] = "%" . $value . "%";                    
          $counter++;
            
        }
          
      }

    }
    
    return [ "query_filter" => $filter, "binding" => $binding_values ];

  }

  public function get_columns($parameters = []){

    if ( !isset($parameters['table']) || empty($parameters['table']) )
      throw new Exception("Tabela não informada, impossível buscar a lista de campos");

    $sql = "SHOW COLUMNS FROM {$parameters['table']}";

    return $this->execute_query($sql, $bind = []);

  }

  public function get_fields($parameters = [] ){ // return list of table fields
    
    $fields = $this->get_columns($parameters);
    
    $field_list = [];
    if ( $parameters['ignore_fields'] && is_array($parameters['ignore_fields']) ){
      foreach ( $fields as $key => $field ){
        if ( !in_array($field['Field'], $parameters['ignore_fields']) )
          $field_list[] = $field['Field'];
      }
    }else {
      foreach ( $fields as $key => $field ){
        $field_list[] = $field['Field'];
      }
    }
    if ( isset($parameters['return_query_field_list']) && $parameters['return_query_field_list']){
      $prefix = ( isset($parameters['prefix']) && !empty($parameters['prefix']) ? "{$parameters['prefix']}."  : "" );
      return "{$prefix}" . implode(",{$prefix}\r\n ", $field_list);
    }       

    return $field_list;
  }



  function run($sql, $bind=[]) {
    $sql = trim($sql);
    try {

      $result = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
      $result->execute($bind);
      return $result;

    } catch (PDOException $e) {
      throw $e;
    }
  }


}





?>