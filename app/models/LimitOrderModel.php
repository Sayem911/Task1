<?php
 ?>
<?php
 class LimitOrderModel extends DB\SQL\Mapper {
    
    public function __construct() {
        parent::__construct(Database::getConnection(), 'signals');
        return $this; 
    }
    
    public function getById($id) {
        $this->first_name = "SELECT first_name FROM user WHERE user.id=signals.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=signals.user_id";
        $this->symbol = "SELECT symbol FROM asset WHERE asset.id=signals.asset_id";
        $this->name = "SELECT name FROM asset WHERE asset.id=signals.asset_id";
        $this->exchange_name = "SELECT m.name FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
        $this->exchange_country_code = "SELECT m.country_code FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
        $this->t_id = "CONCAT('id', id)";
        $this->load(array('id=?', $id)); 
        return $this; 
    } 
    
    public function all() { 
        $result = [];
        $this->first_name = "SELECT first_name FROM user WHERE user.id=signals.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=signals.user_id";
        $this->symbol = "SELECT symbol FROM asset WHERE asset.id=signals.asset_id";
        $this->name = "SELECT name FROM asset WHERE asset.id=signals.asset_id";
        $this->exchange_name = "SELECT m.name FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
        $this->exchange_country_code = "SELECT m.country_code FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
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
        $this->first_name = "SELECT first_name FROM user WHERE user.id=signals.user_id";
        $this->last_name = "SELECT last_name FROM user WHERE user.id=signals.user_id";
        $this->symbol = "SELECT symbol FROM asset WHERE asset.id=signals.asset_id";
        $this->name = "SELECT name FROM asset WHERE asset.id=signals.asset_id";
        // $this->exchange_name = "SELECT m.name FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
        // $this->exchange_country_code = "SELECT m.country_code FROM market m, asset a WHERE a.market_id = m.id AND a.id=signals.asset_id";
        $this->t_id = "CONCAT('id', id)";
        $this->load(array('user_id=?', $user_id), ['order' => 'id ASC']); 
        while(!$this->dry()) { 
            $result[] = $this->cast(); 
            $this->next(); 
        } 
        return $result; 
    } 
    
    public function add($fields) {
        $fields += ['id' => Database::getConnection()->exec('SELECT UUID_SHORT() as id')[0]['id']];
        $this->copyFrom($fields); 
        $this->save(); 
        return $this;
    }

    public function delete($id) { 
        $this->load(array('id=?', $id)); 
        $this->erase(); 
    } 
    
    public function approve($id) {
        $fields = ['id' => $id, 'updated' => Helper::timeStamp(), 'approved' => 1]; 
        $this->copyFrom($fields); 
        $this->update(); 
        return $this; 
    } 
    
    public function countAll() { 
        return $this->count(); 
    }

 }