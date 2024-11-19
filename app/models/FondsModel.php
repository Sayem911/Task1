<?php
 ?>
<?php
 class FondsModel { 
    private $userId; 
    private $db; 
    public function __construct($userId) { 
        $this->db = Database::getConnection(); 
        $this->userId = $userId; 
        return $this;
    } 
    
    public function create($symbol, $issuer, $domicile, $profitLoss, $currentValue, $ROI, $originValue, $notes) { 
        $tradeId = 1;
        $this->db->begin();
        $tradeId = $this->db->exec('SELECT UUID_SHORT() AS id')[0]['id']; 
        $this->db->exec('INSERT INTO fonds (id, asset_id, user_id, issuer, domicile, profit_loss, current_value, roi, origin_value, notes, created)
                          VALUES (:id, 
                                    (SELECT id FROM asset WHERE symbol = :symbol), 
                                    :user_id,
                                    :issuer,
                                    :domicile,
                                    :profit_loss, 
                                    :current_value,
                                    :roi, 
                                    :origin_value,
                                    :notes,
                                    :created)',
                                    [':id' => $tradeId, 
                                    ':symbol' => $symbol, 
                                    ':user_id' => $this->userId, 
                                    ':issuer' => $issuer, 
                                    ':domicile' => $domicile, 
                                    ':profit_loss' => $profitLoss, 
                                    ':current_value' => $currentValue, 
                                    ':roi' => $ROI, 
                                    ':origin_value' => $originValue, 
                                    ':notes' => $notes,
                                    ':created' => Helper::timeStamp()]
                                    );
        $this->db->commit(); 
        return $tradeId; 
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
                                  h.current_value,
                                  h.issuer,
                                  h.domicile,
                                  h.profit_loss,
                                  h.origin_value,
                                  h.roi,
                                  h.notes,
                                  h.created
                                FROM fonds h, asset a, market m
                                WHERE h.asset_id = a.id AND a.market_id = m.id AND h.user_id = :user_id AND a.id != 0
                                ORDER BY h.created DESC', [':user_id' => $this->userId]); 
        } 

        public function count() { 
            return $this->db->exec('SELECT COUNT(*) AS count FROM fonds WHERE user_id=:user_id AND asset_id!=0', array(':user_id' => $this->userId))[0]['count']; 
        } 
        
        public function getListAfter($id) { return $this->db->exec('SELECT * FROM fonds
                                  WHERE user_id = :user_id AND asset_id != 0
                                          AND created >= (SELECT created FROM trade WHERE id = :trade_id)
                                  ORDER BY created ASC', [':user_id' => $this->userId, ':trade_id' => $id]); 
        } 
        
        public function delete($id) { 
            return $this->db->exec('DELETE FROM fonds WHERE id = :id', [':id' => $id]);
        }

        public function updateAll($id, $symbol, $issuer, $domicile, $profitLoss, $currentValue, $ROI, $originValue, $notes) { 
            return $this->db->exec('UPDATE fonds 
                                    SET 
                                    asset_id = (SELECT id FROM asset WHERE symbol = :symbol),
                                    issuer = :issuer,
                                    domicile = :domicile,
                                    profit_loss = :profit_loss,
                                    current_value = :current_value, 
                                    roi = :roi,
                                    origin_value = :origin_value, 
                                    notes = :notes
                                    WHERE id = :id', 
                                    [
                                        ':symbol' => $symbol, 
                                        ':issuer' => $issuer,
                                        ':domicile' => $domicile,
                                        ':profit_loss' => $profitLoss, 
                                        ':current_value' => $currentValue, 
                                        ':roi' => $ROI, 
                                        ':origin_value' => $originValue, 
                                        ':notes' => $notes, 
                                        ':id' => $id
                                    ]
                                ); 
        }
 }
