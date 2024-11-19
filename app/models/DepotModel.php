<?php
 ?>
<?php
 class DepotModel extends DB\SQL\Mapper { 
    public function __construct() {
        parent::__construct(Database::getConnection(), 'depot');
        return $this; 
    }
    
    public function getById($id) {
        $this->first_name = "SELECT first_name FROM user WHERE user.id=depot.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=depot.user_id";
        $this->load(array('id=?', $id)); 
        return $this; 
    } 
    
    public function all() { 
        $result = [];
        $this->first_name = "SELECT first_name FROM user WHERE user.id=depot.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=depot.user_id";
        $this->t_id = "CONCAT('id', id)";
        $this->load(NULL, ['order' => 'id ASC']); 
        while(!$this->dry()) { 
            $result[] = $this->cast(); 
            $this->next(); 
        } 
        return $result;
    } 
    

    public function getByUserId($user_id) { 
        $result = [];
        $this->first_name = "SELECT first_name FROM user WHERE user.id=depot.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=depot.user_id";
        $this->t_id = "CONCAT('id', id)";
        $this->load(array('user_id=?', $user_id), ['order' => 'id ASC']); 
        while(!$this->dry()) { 
            $result[] = $this->cast(); 
            $this->next(); 
        } 
        return $result; 
    } 
    
    public function add($fields) {
        $this->copyFrom($fields); 
        $this->save(); 
        return $this;
    }
    
    public function edit($fields) { 
        $this->copyFrom($fields); 
        $this->update(); 
        return $this->id; 
    } 
    
    public function delete($id) { 
        $this->load(array('id=?', $id)); 
        $this->erase(); 
    } 
    
    public function countAll() { 
        return $this->count(); 
    }
    
    public function countUnprocessed() {
        return $this->count(array('processed IS NULL')); 
    }
    
 }