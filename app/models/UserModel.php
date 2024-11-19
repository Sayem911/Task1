<?php
 ?>
<?php
 class UserModel extends DB\SQL\Mapper { 
    public function __construct() { 
        parent::__construct(Database::getConnection(), 'user'); 
        return $this; 
    }
    
    public function all() { 
        $result = []; 
        $this->load(NULL, ['order' => 'id ASC']); 
        while(!$this->dry()) { 
            $result[] = $this->cast(); 
            $this->next(); 
        } 
        return $result;
    } 
    
    public function getById($id) { 
        $this->load(array('id=?', $id)); 
        return $this; 
    } 
    
    public function getByEmail($email) { 
        $this->load(array('email=?', $email)); 
        return $this->query; 
    } 
    
    public function add($fields) { 
        $this->copyFrom($fields); 
        $this->save(); 
        return $this->id;
    } 
    
    public function edit($fields) { 
        $fields+=array('updated' => Helper::timeStamp()); 
        $this->copyFrom($fields); 
        $this->update(); 
        return $this; 
    } 
    
    public function delete($id) { 
        $this->load(array('id=?', $id)); 
        $this->erase(); 
    } 
    
    public function countAll() { 
        return $this->count(); 
    } 
    
    public function getAll() { 
    return $this->db->exec('SELECT u.*,
                            (SELECT COUNT(*) FROM trade t WHERE t.user_id = u.id AND t.asset_id != 0) AS trades_count
                            FROM user u
                            ORDER BY approved DESC'); 
        
    } 

 }