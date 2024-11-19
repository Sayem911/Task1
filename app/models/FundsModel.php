<?php
 ?>
<?php
 class FundsModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this;
    } 
    
    public function create($symbol, $quantity, $price, $issuePrice, $currentPrice, $totalPrice, $value, $notes, $interest_date) { 
        $fundId = 1;
        $this->db->begin();
        $fundId = $this->db->exec('SELECT UUID_SHORT() AS id')[0]['id']; 
        $this->db->exec('INSERT INTO funds (id, asset_id, user_id, quantity, price, issue_price, current_price, total_price, value, notes, interest_date, created)
                          VALUES (:id, 
                                    (SELECT id FROM asset WHERE symbol = :symbol), 
                                    :user_id, 
                                    :quantity, 
                                    :price,
                                    :issue_price,
                                    :current_price,
                                    :total_price,
                                    :value,
                                    :notes,
                                    :interest_date,
                                    :created)',
                                    [':id' => $fundId, 
                                    ':symbol' => $symbol, 
                                    ':user_id' => $this->userId, 
                                    ':quantity' => $quantity, 
                                    ':price' => $price, 
                                    ':issue_price' => $issuePrice, 
                                    ':current_price' => $currentPrice, 
                                    ':total_price' => $totalPrice,
                                    ':value' => $value,
                                    ':notes' => $notes,
                                    ':interest_date' => $interest_date,
                                    ':created' => Helper::timeStamp()]
                                    );
        $this->db->commit(); 
        
        return $fundId; 
    } 
    
    public function getAll() {
        return $this->db->exec('SELECT
                                  CONCAT("id",h.id) AS id,
                                  h.user_id,
                                  a.symbol,
                                  a.name,
                                  a.currency,
                                  m.name AS exchange_name,
                                  m.country_code AS exchange_country_code,
                                  h.quantity,
                                  h.price,
                                  h.issue_price,
                                  h.current_price,
                                  h.total_price,
                                  h.value,
                                  h.notes,
                                  h.interest_date,
                                  h.created
                                FROM funds h, asset a, market m
                                WHERE h.asset_id = a.id AND a.market_id = m.id AND h.user_id = :user_id AND a.id != 0
                                ORDER BY h.created DESC', [':user_id' => $this->userId]); 
        } 

        public function count() { 
            return $this->db->exec('SELECT COUNT(*) AS count FROM funds WHERE user_id=:user_id AND asset_id!=0', array(':user_id' => $this->userId))[0]['count']; 
        } 

        public function delete($id) { 
            return $this->db->exec('DELETE FROM funds WHERE id = :id', [':id' => $id]);
        }

        public function updateAll($id, $symbol, $quantity, $price, $issuePrice, $currentPrice, $totalPrice, $value, $notes, $interest_date) { 
            return $this->db->exec('UPDATE funds 
                                    SET 
                                    asset_id = (SELECT id FROM asset WHERE symbol = :symbol),
                                    quantity = :quantity,
                                    price = :price, 
                                    issue_price = :issue_price, 
                                    current_price = :current_price, 
                                    total_price = :total_price, 
                                    value = :value,
                                    notes = :notes,
                                    interest_date = :interest_date
                                    WHERE id = :id', 
                                    [
                                        ':symbol' => $symbol, 
                                        ':quantity' => $quantity, 
                                        ':price' => $price, 
                                        ':issue_price' => $issuePrice, 
                                        ':current_price' => $currentPrice, 
                                        ':total_price' => $totalPrice, 
                                        ':value' => $value, 
                                        ':notes' => $notes, 
                                        ':interest_date' => $interest_date, 
                                        ':id' => $id
                                    ]
                                ); 
        }
 }
