<?php
 ?>
<?php
 class OffersAnleihenModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this;
    } 
    
    public function create($symbol, $quantity, $fxRate, $price, $startDate, $endDate, $currentFx, $currentPrice, $total, $interestDate, $notes) { 
        $tradeId = 1;
        $this->db->begin();
        $tradeId = $this->db->exec('SELECT UUID_SHORT() AS id')[0]['id']; 
        $this->db->exec('INSERT INTO anleihen (id, asset_id, user_id, quantity, fx_rate, price, start_date, end_date, current_fx, current_price, total, interest_date, notes, created)
                          VALUES (:id, 
                                    (SELECT id FROM asset WHERE symbol = :symbol), 
                                    :user_id, 
                                    :quantity, 
                                    :fx_rate, 
                                    :price,
                                    :start_date, 
                                    :end_date, 
                                    :current_fx, 
                                    :current_price,
                                    :total,
                                    :interest_date,
                                    :notes,
                                    :created)',
                                    [':id' => $tradeId, 
                                    ':symbol' => $symbol, 
                                    ':user_id' => $this->userId, 
                                    ':quantity' => $quantity, 
                                    ':fx_rate' => $fxRate, 
                                    ':price' => $price, 
                                    ':start_date' => $startDate,
                                    ':end_date' => $endDate,
                                    ':current_fx' => $currentFx, 
                                    ':current_price' => $currentPrice, 
                                    ':total' => $total,
                                    ':interest_date' => $interestDate,
                                    ':notes' => $notes,
                                    ':created' => Helper::timeStamp()]
                                    );
        // $this->db->exec('UPDATE user SET balance = :balance WHERE id=:user_id', array(':balance' => $balance, ':user_id' => $this->userId)); 
        $this->db->commit(); 
        
        return $tradeId; 
    } 
    
    public function getAll() {
        return file_get_contents('config/offersanleihen20230802.json');
        /*
        $this->db->exec('SELECT
                                  CONCAT("id",h.id) AS id,
                                  h.user_id,
                                  a.symbol,
                                  a.name,
                                  a.currency,
                                  m.name AS exchange_name,
                                  m.country_code AS exchange_country_code,
                                  ABS(h.quantity) AS quantity,
                                  CASE WHEN h.quantity>0 THEN 1 ELSE -1 END AS direction,
                                  h.price,
                                  h.fx_rate,
                                  h.current_price,
                                  h.current_fx,
                                  h.commission,
                                  h.start_date,
                                  h.end_date,
                                  h.interest_date,
                                  h.duration,
                                  h.total,
                                  h.balance,
                                  h.notes,
                                  h.created
                                FROM anleihen h, asset a, market m
                                WHERE h.asset_id = a.id AND a.market_id = m.id AND h.user_id = :user_id AND a.id != 0
                                ORDER BY h.created DESC', [':user_id' => $this->userId]); 
        */
        } 

        public function count() { 
            return $this->db->exec('SELECT COUNT(*) AS count FROM anleihen WHERE user_id=:user_id AND asset_id!=0', array(':user_id' => $this->userId))[0]['count']; 
        } 
        
        public function getListAfter($id) { return $this->db->exec('SELECT * FROM anleihen
                                  WHERE user_id = :user_id AND asset_id != 0
                                          AND created >= (SELECT created FROM trade WHERE id = :trade_id)
                                  ORDER BY created ASC', [':user_id' => $this->userId, ':trade_id' => $id]); 
        } 
        
        public function delete($id) { 
            return $this->db->exec('DELETE FROM anleihen WHERE id = :id', [':id' => $id]);
        }

        public function updateAll($id, $symbol, $quantity, $fxRate, $price, $startDate, $endDate, $currentFx, $currentPrice, $total, $interestDate, $notes) { 
            return $this->db->exec('UPDATE anleihen 
                                    SET 
                                    asset_id = (SELECT id FROM asset WHERE symbol = :symbol),
                                    quantity = :quantity,
                                    fx_rate = :fx_rate,
                                    price = :price, 
                                    start_date = :start_date,
                                    end_date = :end_date,
                                    current_fx = :current_fx,
                                    current_price = :current_price, 
                                    total = :total, 
                                    interest_date = :interest_date,
                                    notes = :notes
                                    WHERE id = :id', 
                                    [
                                        ':symbol' => $symbol, 
                                        ':quantity' => $quantity, 
                                        ':fx_rate' => $fxRate, 
                                        ':price' => $price, 
                                        ':start_date' => $startDate, 
                                        ':end_date' => $endDate, 
                                        ':current_fx' => $currentFx, 
                                        ':current_price' => $currentPrice, 
                                        ':total' => $total, 
                                        ':interest_date' => $interestDate, 
                                        ':notes' => $notes, 
                                        ':id' => $id
                                    ]
                                ); 
        }
 }
