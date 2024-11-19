<?php
 ?>
<?php
 class WatchlistModel { private $userId; private $db; public function __construct($userId) { $this->db = Database::getConnection(); $this->userId = $userId; return $this; } public function getList() { return $this->db->exec('SELECT a.symbol, a.name
                FROM asset a, watchlist w
                WHERE a.id = w.asset_id AND w.user_id = :user_id ORDER BY symbol, name', [':user_id' => $this->userId] ); } public function removeSymbol($symbol) { return $this->db->exec('DELETE FROM watchlist WHERE user_id = :user_id AND asset_id = (SELECT id FROM asset a WHERE a.symbol = :symbol)', [':user_id' => $this->userId, ':symbol' => $symbol]); } public function addSymbol($symbol) { return $this->db->exec('INSERT INTO watchlist (user_id, asset_id) VALUES (:user_id, (SELECT id FROM asset WHERE symbol = :symbol)) ON DUPLICATE KEY UPDATE asset_id = asset_id', [':user_id' => $this->userId, ':symbol' => $symbol]); } public function addSymbols(array $symbols) { foreach ($symbols as $symbol) { $this->addSymbol($symbol); } } public function watched($symbol) { $result = $this->db->exec('SELECT COUNT(asset_id) AS watched
                FROM asset a, watchlist w
                WHERE a.id = w.asset_id AND w.user_id = :user_id AND a.symbol = :symbol', [':user_id' => $this->userId, ':symbol' => $symbol]); return isset($result[0]['watched']) ? intval($result[0]['watched']) : 0; } }