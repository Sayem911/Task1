<?php
 ?>
<?php
 class TradeModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this;
    } 
    
    public function create($symbol, $quantity, $price, $fxRate, $commission, $total, $balance, $historicalCost = NULL) { 
        $this->db->begin();
        $tradeId = $this->db->exec('SELECT UUID_SHORT() AS id')[0]['id']; 
        $this->db->exec('INSERT INTO trade (id, asset_id, user_id, quantity, price, fx_rate, commission, total, balance, created)
                          VALUES (:id, (SELECT id FROM asset WHERE symbol = :symbol), :user_id, :quantity, :price, :fx_rate, :commission, :total, :balance, :created)', [':id' => $tradeId, ':symbol' => $symbol, ':user_id' => $this->userId, ':quantity' => $quantity, ':price' => $price, ':fx_rate' => $fxRate, ':commission' => $commission, ':total' => $total, ':balance' => $balance, ':created' => Helper::timeStamp()]);
        if ($symbol!='%CASH%') { 
            $this->db->exec('INSERT INTO position (asset_id, user_id, quantity, historical_cost)
                          VALUES ((SELECT id FROM asset WHERE symbol = :symbol), :user_id, :quantity1, :historical_cost1) ON DUPLICATE KEY UPDATE quantity = quantity + :quantity2, historical_cost = :historical_cost2', array(':symbol' => $symbol, ':user_id' => $this->userId, ':quantity1' => $quantity, ':quantity2' => $quantity, ':historical_cost1' => $historicalCost, ':historical_cost2' => $historicalCost));
        }
        $this->db->exec('UPDATE user SET balance = :balance WHERE id=:user_id', array(':balance' => $balance, ':user_id' => $this->userId)); 
        $this->db->commit(); 
        
        return $tradeId; 
    } 
    
    public function getAll() {
        return $this->db->exec('SELECT
                                  CONCAT("id",t.id) AS id,
                                  t.user_id,
                                  a.symbol,
                                  a.name,
                                  a.currency,
                                  m.name AS exchange_name,
                                  m.country_code AS exchange_country_code,
                                  ABS(t.quantity) AS quantity,
                                  CASE WHEN t.quantity>0 THEN 1 ELSE -1 END AS direction,
                                  t.price,
                                  t.fx_rate,
                                  t.commission,
                                  t.start_date,
                                  t.end_date,
                                  t.duration,
                                  t.total,
                                  t.balance,
                                  t.created
                                FROM trade t, asset a, market m
                                WHERE t.asset_id = a.id AND a.market_id = m.id AND t.user_id = :user_id AND a.id != 0
                                ORDER BY t.created DESC', [':user_id' => $this->userId]); 
        } 
        
        public function getBalanceHistory() { 
            return $this->db->exec('SELECT
                                  a.symbol,
                                  a.currency,
                                  t.quantity,
                                  t.price,
                                  t.balance,
                                  t.total,
                                  t.created
                                FROM trade t, asset a
                                WHERE t.asset_id = a.id AND t.user_id = :user_id
                                ORDER BY t.created ASC', [':user_id' => $this->userId]);
        } 
        
        public function count() { 
            return $this->db->exec('SELECT COUNT(*) AS count FROM trade WHERE user_id=:user_id AND asset_id!=0', array(':user_id' => $this->userId))[0]['count']; 
        } 
        
        public function getListAfter($id) { return $this->db->exec('SELECT * FROM trade
                                  WHERE user_id = :user_id AND asset_id != 0
                                          AND created >= (SELECT created FROM trade WHERE id = :trade_id)
                                  ORDER BY created ASC', [':user_id' => $this->userId, ':trade_id' => $id]); 
        } 
        
        public function update($id, $price, $total, $balance) {
            return $this->db->exec('UPDATE trade SET price = :price, total = :total, balance = :balance WHERE id = :id', [':price' => $price, ':total' => $total, ':balance' => $balance, ':id' => $id]); 
        }
        
        public function delete($id) {
            $query = $this->db->exec('SELECT asset_id, user_id FROM trade WHERE id = :id', [':id' => $id]);
            $asset_id = $query[0]['asset_id'];
            $user_id = $query[0]['user_id'];
            $positionQuantity = $this->db->exec('SELECT quantity FROM position WHERE asset_id = :asset_id AND user_id = :user_id', [':asset_id' => $asset_id, ':user_id' => $user_id])[0]['quantity'];
            $query2 = $this->db->exec('SELECT quantity, total FROM trade WHERE id = :id', [':id' => $id]);
            $tradeQuantity = $query2[0]['quantity'];
            $tradeTotal = $query2[0]['total'];
            if($positionQuantity >= $tradeQuantity){
                $this->db->begin();
                $op1 = $this->db->exec('DELETE FROM trade WHERE id = :id', [':id'=>$id]);
                $op2 = $this->db->exec('UPDATE position SET quantity = quantity - :tradeQuantity, historical_cost = historical_cost - :t_total WHERE asset_id = :asset_id AND user_id = :user_id;', ['tradeQuantity' => $tradeQuantity, ':t_total' => $tradeTotal, ':asset_id' => $asset_id, ':user_id' => $user_id]);
                $this->db->commit();
                return $op1 and $op2;
            }else{
                $this->db->begin();
                $op1 = $this->db->exec('DELETE FROM trade WHERE id = :id', [':id'=>$id]);
                $op2 = $this->db->exec('DELETE FROM position WHERE asset_id = :asset_id AND user_id = :user_id;', [':asset_id' => $asset_id, ':user_id' => $user_id]);
                $this->db->commit();
                return $op1 and $op2;
            }
        }

        public function updateAll($id, $price, $total, $rate, $quantity, $start, $end, $duration) { 
            return $this->db->exec('UPDATE trade 
                                    SET 
                                    price = :price, 
                                    total = :total, 
                                    fx_rate = :rate,
                                    quantity = :quantity,
                                    start_date = :start,
                                    end_date = :end,
                                    duration = :duration 
                                    WHERE id = :id', 
                                    [
                                        ':price' => $price, 
                                        ':total' => $total, 
                                        ':rate' => $rate, 
                                        ':quantity' => $quantity, 
                                        ':start' => $start, 
                                        ':end' => $end, 
                                        ':duration' => $duration, 
                                        ':id' => $id
                                    ]
                                );
        }
        
        public function updatePrice($id, $price) {
            $asset_id = $this->db->exec('SELECT asset_id FROM trade WHERE id = :id', [':id' => $id]);
            $user_id = $this->db->exec('SELECT user_id FROM trade WHERE id = :id', [':id' => $id]);
            // $positionUpdate = $this->db->exec('UPDATE trade SET price = :price WHERE id = :id', [':price' => $price, ':id' => $id]); 
            return $this->db->exec('UPDATE trade SET price = :price WHERE id = :id', [':price' => $price, ':id' => $id]); 
        }
        
        public function updateTotal($id, $total) { 
            return $this->db->exec('UPDATE trade SET total = :total WHERE id = :id', [':total' => $total, ':id' => $id]); 
        }

        public function updateBalance($id, $balance) { 
            return $this->db->exec('UPDATE trade SET balance = :balance WHERE id = :id', [':balance' => $balance, ':id' => $id]);
        }
        
        public function updateFxRate($id, $rate) { 
            return $this->db->exec('UPDATE trade SET fx_rate = :rate WHERE id = :id', [':rate' => $rate, ':id' => $id]); 
        }

        public function updateQuantity($id, $quantity) { 
            return $this->db->exec('UPDATE trade SET quantity = :quantity WHERE id = :id', [':quantity' => $quantity, ':id' => $id]); 
        }
        
        // public function updateStartDate($id, $date) { 
        //     return $this->db->exec('UPDATE trade SET start_date = :date WHERE id = :id', [':date' => $date, ':id' => $id]); 
        // }
        
        // public function updateEndDate($id, $date) { 
        //     return $this->db->exec('UPDATE trade SET end_date = :date WHERE id = :id', [':date' => $date, ':id' => $id]); 
        // }
        
        // public function updateDuration($id, $duration) { 
        //     return $this->db->exec('UPDATE trade SET duration = :quantity WHERE id = :id', [':duration' => $duration, ':id' => $id]); 
        // }
        
 }
