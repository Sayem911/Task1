<?php
 ?>
<?php
class PositionModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this; 
    } 
    
    public function getList() { 
        return $this->db->exec('SELECT
                              a.symbol,
                              a.currency,
                              a.name,
                              a.nominal,
                              sum(t.total*(CASE WHEN t.quantity>0 THEN 1 ELSE -1 END)) as total,
                              t.price,
                              sum(t.quantity) as quantity,
                              p.historical_cost,
                              CASE WHEN p.quantity>0 THEN 1 ELSE -1 END AS direction,
                              (SELECT balance FROM user WHERE id = :user_id) AS balance
                            FROM trade t, position p, asset a
                            WHERE t.asset_id = p.asset_id AND t.user_id = p.user_id AND p.asset_id = a.id AND p.user_id = :user_id AND p.quantity>0
                            GROUP BY t.asset_id
                            ', [':user_id' => $this->userId]); 
        // return $this->db->exec('SELECT
        //                       a.symbol,
        //                       a.currency,
        //                       a.name,
        //                       a.nominal,
        //                       p.quantity,
        //                       p.historical_cost,
        //                       CASE WHEN p.quantity>0 THEN 1 ELSE -1 END AS direction,
        //                       (SELECT balance FROM user WHERE id = :user_id) AS balance
        //                     FROM position p, asset a
        //                     WHERE p.asset_id = a.id AND p.user_id = :user_id AND p.quantity!=0', [':user_id' => $this->userId]); 
    } 
    
    public function get($symbol) { 
        $position = $this->db->exec('SELECT p.quantity, p.historical_cost
                            FROM position p, asset a
                            WHERE p.asset_id = a.id AND p.user_id = :user_id AND a.symbol = :symbol', [':user_id' => $this->userId, ':symbol' => $symbol]); return !empty($position) ? $position[0] : []; 
    }
}