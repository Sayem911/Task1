<?php
 ?>
<?php
 class AssetModel { 
    private $db; 
    public function __construct() { 
        $this->db = Database::getConnection(); 
        return $this; 
    } 
    
    public function allAnleihenAssets() {
        if ($assets = $this->db->exec('SELECT 
                                            a.*,
                                            m.code AS exchange_code,
                                            m.name AS exchange_name,
                                            m.country_code AS country_code,
                                            m.trading_start AS trading_start,
                                            m.trading_end AS trading_end,
                                            m.timezone AS timezone
                                        FROM 
                                            asset a,
                                            market m
                                        WHERE a.market_id = m.id AND a.market_id = 13')) { 
            return (object) $assets; 
        } 
        
        
        return NULL;
    }
    public function allFondsAssets() {
        if ($assets = $this->db->exec('SELECT 
                                            a.*,
                                            m.code AS exchange_code,
                                            m.name AS exchange_name,
                                            m.country_code AS country_code,
                                            m.trading_start AS trading_start,
                                            m.trading_end AS trading_end,
                                            m.timezone AS timezone
                                        FROM 
                                            asset a,
                                            market m
                                        WHERE a.market_id = m.id AND a.market_id = 16')) { 
            return (object) $assets; 
        } 
        
        
        return NULL;
    }
    
    public function allFundAssets() {
        if ($assets = $this->db->exec('SELECT 
                                            a.*,
                                            m.code AS exchange_code,
                                            m.name AS exchange_name,
                                            m.country_code AS country_code,
                                            m.trading_start AS trading_start,
                                            m.trading_end AS trading_end,
                                            m.timezone AS timezone
                                        FROM 
                                            asset a,
                                            market m
                                        WHERE a.market_id = m.id AND a.market_id = 14')) { 
            return (object) $assets; 
        } 
        
        
        return NULL;
    }
    
    public function allFixedDepositAssets() {
        if ($assets = $this->db->exec('SELECT 
                                            a.*,
                                            m.code AS exchange_code,
                                            m.name AS exchange_name,
                                            m.country_code AS country_code,
                                            m.trading_start AS trading_start,
                                            m.trading_end AS trading_end,
                                            m.timezone AS timezone
                                        FROM 
                                            asset a,
                                            market m
                                        WHERE a.market_id = m.id AND a.market_id = 15')) { 
            return (object) $assets; 
        } 
        
        
        return NULL;
    }
        
    public function getAnleihenAsset($symbol) { 
        if ($asset = $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id = 13 AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 
   
    public function getFondsAsset($symbol) { 
        if ($asset = $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id = 16 AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 
   
    public function getFundsAsset($symbol) { 
        if ($asset = $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id = 14 AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 

    public function getFixedDepositAsset($symbol) { 
        if ($asset = $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id = 15 AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 
    
    public function findAsset($symbol) { 
        if ($asset = $this->db->exec('SELECT a.*, m.code AS market_code FROM asset a, market m WHERE a.market_id = m.id AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 
    
    public function all() {
        if ($assets = $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id < 13 OR a.market_id > 16')) { 
            return (object) $assets; 
        } 
        
        return NULL;
    }
    
    public function get($symbol) { 
        if ($asset = $this->db->exec('SELECT a.* FROM asset a WHERE (a.market_id < 13 OR a.market_id > 16) AND a.symbol = :symbol', array(':symbol' => $symbol))) { 
            return (object) $asset[0]; 
        } 
        
        return NULL;
    } 
    
    public function getInfo($symbol) { 
        return $this->db->exec('SELECT
                                  a.symbol,
                                  a.name,
                                  m.code AS exchange_code,
                                  m.name as exchange_name,
                                  m.country_code AS exchange_country_code,
                                  m.trading_start,
                                  m.trading_end,
                                  m.timezone AS exchange_timezone
                              from
                                  asset a,
                                  market m
                              where
                                  a.market_id = m.id and m.id <> 13 AND a.symbol = :symbol', [':symbol' => $symbol])[0]; 
    } 

    public function getByMarketId($marketId) { 
        return $this->db->exec('SELECT a.* FROM asset a WHERE a.market_id = :market_id', [':market_id' => $marketId]); 
    } 
    public function updateNominal($symbol, $nominal) { 
        return $this->db->exec('UPDATE asset a SET a.nominal=:nominal WHERE a.symbol=:symbol', [':nominal' => $nominal, ':symbol' => $symbol]); 
    } 
    
    public function getMostActive() { 
        return $this->db->exec('SELECT a.symbol, a.name, COUNT(*) AS trades_count
                                FROM asset a, trade t
                                WHERE a.id = t.asset_id 
                                GROUP BY a.symbol, a.name 
                                ORDER BY trades_count DESC, symbol, name LIMIT 10'); 
    }
    
    
    public function add($market, $symbol, $name,$currency, $nominal){
        return $this->db->exec('INSERT INTO asset(market_id, symbol, name, currency, nominal) VALUES(:market_id, :symbol, :name, :currency, :nominal)', [':market_id' => $market, ':symbol' => $symbol, ':name' => $name, ':currency' => $currency, ':nominal' => $nominal]);
    }
    
    public function update($id, $market, $symbol, $name, $currency, $nominal){
        return $this->db->exec('UPDATE asset SET market_id=:market_id, symbol=:symbol, name=:name, currency=:currency, nominal=:nominal WHERE id=:id', [':id' => $id, ':market_id' => $market, ':symbol' => $symbol, ':name' => $name, ':currency' => $currency, ':nominal' => $nominal]);
    }

    public function delete($symbol){
        return $this->db->exec('DELETE FROM asset WHERE symbol=:symbol', [':symbol' => $symbol]);
    }    
 }