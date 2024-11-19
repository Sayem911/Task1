<?php
 ?>
<?php
 class TradeController extends Controller { 
    protected $templates_directory = 'main'; 
    
    function beforeroute($f3, $params) { 
        parent::beforeroute($f3, $params); 
        parent::checkSubscription(); 
    } 
     
    function renderMarketsPage($f3, $params) { 
        $markets = new MarketModel(); 
        $assets = new AssetModel(); 
        $watchlist = new WatchlistModel($this->f3->get('USER')->id); 
        $f3->set('vars.stock_indexes', $this->f3->get('MARKETS.STOCK_INDEXES')); 
        $f3->set('vars.currencies', $this->f3->get('MARKETS.CURRENCIES')); 
        $f3->set('vars.markets', $markets->getList()); 
        $f3->set('vars.watchlist', $watchlist->getList()); 
        $f3->set('vars.most_active', $assets->getMostActive()); 
        $this->setPageTitle('title.markets'); 
        $this->setTemplate('tpl.content', 'trade/markets.php'); 
        $this->renderPage();
    }
     
    function renderTradePage($f3, $params) { 
        if ($symbol = $this->f3->get('GET.s')) { 
            $this->f3->set('SESSION.symbol', $symbol); 
        } elseif (!$symbol = $this->f3->get('SESSION.symbol')) { 
            $symbol = $this->f3->get('TRADE.DEFAULT_SYMBOL'); 
        } 
        
        if ($this->f3->get('CREDITS.ENABLED')) { 
            $user = $this->f3->get('USER'); 
            if (!$this->f3->get('COOKIE.low_credit_notified') && $user->balance < floatval($this->f3->get('CREDITS.NOTIFICATION_LIMIT'))) { 
                $this->f3->set('COOKIE.low_credit_notified', TRUE, 604800); 
                $f3->set('vars.low_credit_notification', TRUE);
            } 
        } 
        
        $watchlist = new WatchlistModel($this->f3->get('USER')->id); 
        $asset = new AssetModel(); 
        $f3->set('vars.symbol', $symbol); 
        $f3->set('vars.asset', $asset->getInfo($symbol)); 
        $f3->set('vars.symbol_watched', $watchlist->watched($symbol)); 
        $f3->set('vars.yahoo_rss_lang_domain', Helper::getYahooRssLangDomain($this->f3->get('USER')->language)); 
        $this->setPageTitle('title.trade'); 
        $this->setTemplate('tpl.content', 'trade/trade.php'); 
        $this->renderPage(); 
    } 
     
    function renderPortfolioPage($f3, $params) { 
        $this->setPageTitle('title.portfolio'); 
        $this->setTemplate('tpl.content', 'trade/portfolio.php'); 
        $this->renderPage(); 
    }
     
    function renderOffersPage($f3, $params) { 
        $this->setPageTitle('title.Offers'); 
        $this->setTemplate('tpl.content', 'trade/offers.php'); 
        $this->renderPage(); 
    }
     
    function renderTransactionsPage($f3, $params) { 
        $this->setPageTitle('title.transactions'); 
        $this->setTemplate('tpl.content', 'trade/transactions.php'); 
        $this->renderPage(); 
    }

    function renderSignalsPage($f3, $params) { 
        $this->setPageTitle('title.signals'); 
        $this->setTemplate('tpl.content', 'trade/signals.php'); 
        $this->renderPage(); 
    }
 }