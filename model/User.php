<?php

include_once(__DIR__."/../configs/config.php");

include_once(__DIR__."/../model/Crud.php");


Class User {

    private $id;
    private $name;
    private $email;
    private $password;
    private $login;

    private $api_token;
    
    private $table_name = "user";
    const MIN_PASS_LEN = 8;

    public function get_id(){ return $this->id; }
    public function set_id($id): self { $this->id = $id; return $this; }

    public function get_login(){ return $this->login; }
    public function set_login($login): self { $this->login = $login; return $this; }


    public function get_name(){ return $this->name; }
    public function set_name($name): self { $this->name = $name; return $this; }

    public function get_email(){ return $this->email; }
    public function set_email($email): self { $this->email = $email; return $this; }

    public function get_password(){ return $this->password; }
    public function set_password($password): self { $this->password = $password; return $this; }
    
    public function get_table_name(){ return $this->table_name; }


    public function create_api_token($login, $password){
        return md5($login.$password.rand().API_TOKEN_SALT);
      }

   
      public function create_password($login, $password){
        if (strlen($password) < self::MIN_PASS_LEN) {
          throw new FormException("A senha deve conter ao menos " . self::MIN_PASS_LEN . " caracteres", "password");
        }
    
        return md5($login . $password . PW_SALT);
    }
    public function to_array(){            
      return get_object_vars($this);    
    }

    public function create_user() {
$Crud = new Crud();

 $user_data= $this->to_array();
     // $sql = "INSERT INTO user (name, email, login, password, api_token) VALUES (?, ?, ?, ?, ?)";
      //$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
      $api_token = $this->create_api_token($this->login, $this->password);
  
      try {
       //   $stmt = $conn->prepare($sql);
        //  $stmt->execute([$this->name, $this->email, $this->login,  $this->password, $api_token]);
          return $Crud->create($table= $this->get_table_name(), $user_data);
      } catch (Exception $e) {
          throw new Exception("Erro ao criar usuário: " . $e->getMessage());
      }
  }


  public function get_user_by_credentials($conn, $login, $password) {
    $sql = "SELECT * FROM user WHERE login = ? AND password = ?";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$login, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (Exception $e) {
        throw new Exception("Erro ao obter usuário por credenciais: " . $e->getMessage());
    }
}

public function list($filters = []) {
  $Crud = new Crud();
  $where = '';
  $field_list = "*";

  if (!isset($filters['return_all_fields']) || $filters['return_all_fields'] != true) {
      if (!isset($filters['ignore_fields']) || empty($filters['ignore_fields'])) {
          // remove password and token
          $ignore_fields = ["api_token"];
      } else {
          $ignore_fields = $filters['ignore_fields'];
      }
      $field_list = $Crud->get_fields(["table" => $this->get_table_name(), "ignore_fields" => $ignore_fields, "return_query_field_list" => true]);
  }

  $bind = [];
  if ($filters) {
      $sql_filter = self::create_sql_filter($filters);
      $where .= $sql_filter["where"];
      $bind = $sql_filter["bind"];
  }

  $users = $Crud->read($table = $this->get_table_name(), $where, $bind, $fields = $field_list);

  return $users;
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
public static function get_class_vars($object){
  return array_keys(get_class_vars(get_class($object))); // $object
}


}
?>

