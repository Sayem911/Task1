<?php
 ?>
<?php
class ApiModel { 
    private $db; 
    
    public function __construct() { 
        $this->db = Database::getConnection(); 
        return $this; 
    } 
    
    public function searchAsset($searchString, $userID) { 
        return $this->db->exec('SELECT a.id AS id, a.symbol AS symbol, a.name AS name, m.code AS exchange_code, m.name AS exchange_name, m.country_code AS exchange_country_code,
                (SELECT count(w.asset_id) FROM watchlist w WHERE w.asset_id = a.id AND w.user_id = :user_id) AS watched
                FROM asset a, market m
                WHERE a.market_id = m.id AND (a.market_id < 13 OR a.market_id > 15) AND (a.symbol LIKE :string1 OR LOWER(a.name) LIKE :string2) AND a.id != 0 ORDER BY symbol, name LIMIT 15', [':user_id' => $userID, ':string1' => strtoupper($searchString) . '%', ':string2' => '%' . strtolower($searchString) . '%'] ); 
    } 
        
    public function searchAssetOnly($searchString) { 
        return $this->db->exec('SELECT a.id AS id, a.symbol AS symbol, a.name AS name, m.code AS exchange_code, m.name AS exchange_name, m.country_code AS exchange_country_code
                                FROM asset a, market m
                                WHERE a.market_id = m.id AND (a.market_id < 13 OR a.market_id > 15) AND (a.symbol LIKE :string1 OR LOWER(a.name) LIKE :string2) AND a.id != 0 ORDER BY symbol, name LIMIT 15', 
                                [':string1' => strtoupper($searchString) . '%', ':string2' => '%' . strtolower($searchString) . '%'] ); 
    }
    
    public function searchUser($searchString) { 
        return $this->db->exec('SELECT id, first_name, last_name, avatar, balance, currency
                FROM user
                WHERE LOWER(CONCAT(first_name," ",last_name)) LIKE :search ORDER BY first_name, last_name, balance LIMIT 15', [':search' => '%' . strtolower($searchString) . '%'] ); 
    }
    
    public function deleteUser($userId) { 
        if ($userId > 0) { 
            $this->db->begin(); 
            $this->db->exec('DELETE FROM password_reset WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM trade WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM anleihen WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM funds WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM position WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM watchlist WHERE user_id = :user_id', [':user_id' => $userId]); 
            $this->db->exec('DELETE FROM user WHERE id = :user_id', [':user_id' => $userId]); 
            $this->db->commit(); 
            return TRUE; 
        } 
        
        return FALSE; 
    } 
}