<?php
 ?>
<?php
 class FixedDepositModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this;
    } 
    
    public function create($symbol, $total, $amount, $interestRate, $building, $totalvalue, $notes) { 
        $depositId = 1;
        $this->db->begin();
        $depositId = $this->db->exec('SELECT UUID_SHORT() AS id')[0]['id']; 
        $this->db->exec('INSERT INTO fixed_deposit (id, asset_id, user_id, amount, total, interest_rate, building, totalvalue, notes, created)
                          VALUES (:id, 
                                    (SELECT id FROM asset WHERE symbol = :symbol), 
                                    :user_id, 
                                    :amount,
                                    :total, 
                                    :interest_rate, 
                                    :building, 
                                    :totalvalue, 
                                    :notes,
                                    :created)',
                                    [':id' => $depositId, 
                                    ':symbol' => $symbol, 
                                    ':user_id' => $this->userId, 
                                    ':amount' => $amount, 
                                    ':total' => $total, 
                                    ':interest_rate' => $interestRate, 
                                    ':building' => $building, 
                                    ':totalvalue' => $totalvalue,
                                    ':notes' => $notes,
                                    ':created' => Helper::timeStamp()]
                                    );
        $this->db->commit(); 
        
        return $depositId; 
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
                                  h.amount,
                                  h.total,
                                  h.interest_rate,
                                  h.building,
                                  h.totalvalue,
                                  h.notes
                                FROM fixed_deposit h, asset a, market m
                                WHERE h.asset_id = a.id AND a.market_id = m.id AND h.user_id = :user_id AND a.id != 0
                                ORDER BY h.created DESC', [':user_id' => $this->userId]); 
        } 

        public function count() { 
            return $this->db->exec('SELECT COUNT(*) AS count FROM fixed_deposit WHERE user_id=:user_id AND asset_id!=0', array(':user_id' => $this->userId))[0]['count']; 
        } 

        public function delete($id) { 
            return $this->db->exec('DELETE FROM fixed_deposit WHERE id = :id', [':id' => $id]);
        }

        public function updateAll($id, $symbol, $total, $amount, $interestRate, $building, $totalvalue, $notes) { 
            return $this->db->exec('UPDATE fixed_deposit 
                                    SET 
                                    asset_id = (SELECT id FROM asset WHERE symbol = :symbol),
                                    amount = :amount,
                                    total = :total,
                                    interest_rate = :interest_rate, 
                                    building = :building, 
                                    totalvalue = :totalvalue,
                                    notes = :notes
                                    WHERE id = :id', 
                                    [
                                        ':symbol' => $symbol, 
                                        ':amount' => $amount, 
                                        ':total' => $total, 
                                        ':interest_rate' => $interestRate, 
                                        ':building' => $building, 
                                        ':totalvalue' => $totalvalue, 
                                        ':notes' => $notes, 
                                        ':id' => $id
                                    ]
                                ); 
        }
 }
