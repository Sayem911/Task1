<?php

/**

 * Virtual Stock Exchange

 * Version 1.7.0

 * Copyright (c) Financial Plugins <info@financialplugins.com>. All rights reserved.

 * http://financialplugins.com/products/virtual-stock-exchange/

 */

?>
<?php



class ApiController extends Controller {



    const HISTORY_START = '2011-01-01';

    //const LIVE_QUOTES_SOURCE = 'https://query%d.finance.yahoo.com/v6/finance/quote?formatted=false&symbols=%s&fields=shortName,fullExchangeName,regularMarketPrice,regularMarketChange,regularMarketChangePercent,regularMarketDayLow,regularMarketDayHigh,regularMarketVolume,fiftyTwoWeekLow,fiftyTwoWeekHigh,fiftyTwoWeekLowChange,fiftyTwoWeekLowChangePercent,fiftyTwoWeekHighChange,fiftyTwoWeekHighChangePercent,regularMarketOpen,regularMarketPreviousClose,averageDailyVolume3Month,bid,ask,sharesOutstanding,marketCap,bookValue,ebitda,exDividendDate,dividendRate,dividendYield,totalCash,fiftyDayAverage,twoHundredDayAverage,beta,trailingPE,pegRatio';

    const LIVE_QUOTES_SOURCE = 'https://query%d.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=%s&fields=%s&crumb=%s';

    const YQL_ENDPOINT = '/api/public/quotes?symbols=%s&env=store://datatables.org/alltableswithkeys&format=json';

    const HISORICAL_QUOTES_QUERY_TXT = 'https://www.google.com/finance/getprices?i=86400&f=d,c,v&df=cpct&x=%s&q=%s&p=%s';

    const CACHE_FOLDER = 'app/data';

    const QUOTE_CACHE_PERIOD = 60;



    const IDENTITY_UPLOAD_DIR = 'files'.DIRECTORY_SEPARATOR.'ids'.DIRECTORY_SEPARATOR; 

    const MAX_IDENTITIY_SIZE = 5*1024*1024;

    const DOC_UPLOAD_DIR = 'files'.DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR; 

    const MAX_DOC_SIZE = 10*1024*1024;



  private $latest_quote = array('regularMarketPrice','currency');



  protected $templates_directory = 'auth';



  function beforeroute($f3, $params) {

    // call Controller::beforeroute()

    parent::beforeroute($f3, $params);

    parent::checkSubscription();

  }



  /**

   * Symbol search autocomplete

   * @param $f3

   * @param $params

   */

  function apiSearchAsset($f3, $params) {

    $searchString = $this->f3->get('PARAMS.search');

    print json_encode(['results' => (new ApiModel())->searchAsset($searchString, $this->f3->get('USER')->id)], JSON_NUMERIC_CHECK);

  }



  function apiGetAllAnleihenAssets($f3, $params) {

    print json_encode(['results' => (new AssetModel())->allAnleihenAssets()], JSON_NUMERIC_CHECK);

  }



  function apiGetAllFondsAssets($f3, $params) {

    print json_encode(['results' => (new AssetModel())->allFondsAssets()], JSON_NUMERIC_CHECK);

  }



  function apiGetAllFundsAssets($f3, $params) {

    print json_encode(['results' => (new AssetModel())->allFundAssets()], JSON_NUMERIC_CHECK);

  }



  function apiGetAllFixedDepositAssets($f3, $params) {

    print json_encode(['results' => (new AssetModel())->allFixedDepositAssets()], JSON_NUMERIC_CHECK);

  }



  function apiGetAllMarkets($f3, $params) {

    print json_encode(['results' => (new MarketModel())->getList()], JSON_NUMERIC_CHECK);

  }



  /**

   * User search autocomplete

   * @param $f3

   * @param $params

   */

  function apiSearchUser($f3, $params) {

    $searchString = $this->f3->get('PARAMS.search');

    $searchResult = $this->f3->get('USER')->is_admin ? (new ApiModel())->searchUser($searchString) : [];

    print json_encode(['results' => $searchResult], JSON_NUMERIC_CHECK);

  }



  /**

   * Retrieve market data

   * @param $f3

   * @param $params

   */

  function apiGetQuotes($f3, $params) {

    /*if (($symbols = $this->f3->get('GET.symbols')) && ($fields = $this->f3->get('GET.fields'))) {

    }*/

    //$symbols = $this->f3->get('GET.symbols');

    //$fields = $this->f3->get('GET.fields');

    $symbols = $this->f3->get('GET.symbols') ? explode(',', $this->f3->get('GET.symbols')) : []; // transform to an array

    $fields = $this->f3->get('GET.fields') ? explode(',', $this->f3->get('GET.fields')) : []; // transform to an array

    $checkTradingEnabledSymbols = $this->f3->get('GET.check') ? explode(',', $this->f3->get('GET.check')) : [];

    if ($quote = $this->getQuotes($symbols, $fields, $checkTradingEnabledSymbols)) {

        header('Content-Type: application/json; charset=utf-8');

        print json_encode($quote, JSON_NUMERIC_CHECK);

    }

    

  }

    function apiGetQuotesTest($symbols) {

    $s[] = $symbols; 
    $r = explode(',', 'quoteType,shortName,regularMarketTime,regularMarketPrice,currency,regularMarketChangePercent,c4,regularMarketChange,bid,sharesOutstanding,ask,marketCap,bookValue,regularMarketDayLow,regularMarketDayHigh,ebitda,fiftyTwoWeekLow,fiftyTwoWeekHigh,exDividendDate,fiftyTwoWeekLowChange,fiftyTwoWeekLowChangePercent,dividendRate,fiftyTwoWeekHighChange,fiftyTwoWeekHighChangePercent,dividendYield,regularMarketOpen,totalCash,regularMarketPreviousClose,fiftyDayAverage,regularMarketVolume,fiftyDayAverageChange,averageDailyVolume3Month,fiftyDayAverageChangePercent,beta,twoHundredDayAverage,trailingPE,twoHundredDayAverageChange,pegRatio,twoHundredDayAverageChangePercent');

    if ($quote = $this->getQuotes($s, $r, $s)) {

        header('Content-Type: application/json; charset=utf-8');

        return json_encode($quote, JSON_NUMERIC_CHECK);

    }

    

  }

  

   function getYahooCreds(){
     $r = [];
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://query2.finance.yahoo.com/v1/test/getcrumb');
        $cookie = 'A3=d=AQABBJZleWUCEKNvvWSPKF6YOPLqkpa5yyUFEgABCAGsemWpZe2Nb2UB9qMAAAcIk2V5ZaAQdmQ&S=AQAAAvW9Xw7J7fG8vpn4YPBs6nQ;';
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Host: query2.finance.yahoo.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language: tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate, br',
            'Upgrade-Insecure-Requests: 1',
            'Te: trailers',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $cc = curl_exec($ch);
        
        $getInfo = curl_getinfo($ch);
        $getInfo = $getInfo['http_code'];
        
        if($getInfo == 500){
           return getYahooCreds_first();
        }else{
            $r = ['crumb' => $cc, 'cookie' => $cookie];
            return $r;
        }

        curl_close($ch);
  }
  
  function getYahooCreds_first(){
        $ch = curl_init('https://fc.yahoo.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        var_dump($result);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        $ch = curl_init('https://query1.finance.yahoo.com/v1/test/getcrumb');
        $cookie = 'A3='.$cookies['A3'].'&S='.$cookies['S'].';';
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt_array($ch, [CURLOPT_COOKIE => $cookie]);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0');
        $crumb = curl_exec($ch);
        $r = ['crumb' => $crumb, 'cookie' => $cookie];
        return $r;
  }

  function apiGetData($f3, $params) {
      
        $cred = $this->getYahooCreds();
        
        $url = sprintf(self::LIVE_QUOTES_SOURCE, rand(1, 2), $f3->get('GET.symbols'), $cred['crumb']);
        $ch = curl_init("https://query1.finance.yahoo.com/v7/finance/quote?lang=en-US&region=US&corsDomain=finance.yahoo.com&symbols=".$f3->get('GET.symbols')."&crumb=".$cred['crumb']);
        //$ch = curl_init("https://query1.finance.yahoo.com/v8/finance/chart/AAPL?metrics=high?&interval=1d&range=5d");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt_array($ch, [CURLOPT_COOKIE => $cred['cookie']]);
        $result = curl_exec($ch);
        $rarr = array();
        $result = json_decode($result);
        foreach($result->quoteResponse->result as $val) {
            $rarr[$val->symbol] = $val;
        }
        header('Content-Type: application/json; charset=utf-8');
        print json_encode($rarr, JSON_NUMERIC_CHECK);       
  }


  /**

   * Add or remove symbols to/from user watchlist

   * @param $f3

   * @param $params

   */

  function apiChangeWatchlist($f3, $params) {

    if ($symbol = $this->f3->get('PARAMS.symbol')) {

      $action = $this->f3->get('PARAMS.action');

      $watchlist = new WatchlistModel($this->f3->get('USER')->id);

      $count = 0;

      if ($action == 'add') {

        $count = $watchlist->addSymbol($symbol);

      } elseif ($action == 'remove') {

        $count = $watchlist->removeSymbol($symbol);

      }

      print $count>0 ? json_encode(array('success' => TRUE)) : json_encode(array('success' => FALSE));

    }

  }



  /**

   * Store current symbol in user session

   * @param $f3

   * @param $params

   */

  function apiSetActiveSymbol($f3, $params) {

    if ($symbol = $this->f3->get('PARAMS.symbol')) {

      $this->f3->set('SESSION.symbol', $symbol);

    }

  }

  

  function apiAssets($f3, $params){

    $success = FALSE;

    $message = '';

    $action = $f3->get('PARAMS.action');

    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }

    $user = $this->f3->get('USER');

    $user_id = $user->id;

    $asset = new AssetModel();

    if($action=='info'){

        $symbol = $this->f3->get('PARAMS.symbol');

        print json_encode(['results' => $asset->findAsset($symbol)], JSON_NUMERIC_CHECK);

    }

    if($action == 'add'){

        $market = $f3->get('POST.market');

        $symbol = $f3->get('POST.symbol');

        $name = $f3->get('POST.name');

        $currency = $f3->get('POST.currency');

        $nominal = $f3->get('POST.nominal');

        

        if(!isset($market) || $market == ''){

            $message = $this->f3->get('trade.assets.market_incorrect');

        }elseif(!isset($symbol) || $symbol == ''){

            $message = $this->f3->get('trade.assets.symbol_incorrect');

        }elseif(!isset($name) || $name == ''){

            $message = $this->f3->get('trade.assets.name_incorrect');

        }elseif(!isset($currency) || $currency == ''){

            $message = $this->f3->get('trade.assets.currency_incorrect');

        }elseif(!isset($nominal) || $nominal == ''){

            $message = $this->f3->get('trade.assets.nominal_incorrect');

        }

        

        if($asset->findAsset($symbol) != NULL){

            $message = $this->f3->get('trade.assets.asset_exist');

        }

        

        if($message == '') {

            if($asset->add($market, $symbol, $name, $currency, $nominal)){

                Logger::log(sprintf('Asset added.  Market: "%s", Symbol: "%s", Name: "%s"', $market, $symbol, $name));

                $success = TRUE;

                $message = $this->f3->get('trade.assets.save_success');

            }else{

                $message = $this->f3->get('trade.assets.save_error');

            }

        }

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    if($action == 'update'){

        $id = $f3->get('POST.id');

        $market = $f3->get('POST.market');

        $symbol = $f3->get('POST.symbol');

        $name = $f3->get('POST.name');

        $currency = $f3->get('POST.currency');

        $nominal = $f3->get('POST.nominal');

        

        if(!isset($market) || $market == ''){

            $message = $this->f3->get('trade.assets.market_incorrect');

        }elseif(!isset($symbol) || $symbol == ''){

            $message = $this->f3->get('trade.assets.symbol_incorrect');

        }elseif(!isset($name) || $name == ''){

            $message = $this->f3->get('trade.assets.name_incorrect');

        }elseif(!isset($currency) || $currency == ''){

            $message = $this->f3->get('trade.assets.currency_incorrect');

        }elseif(!isset($nominal) || $nominal == ''){

            $message = $this->f3->get('trade.assets.nominal_incorrect');

        }

        

        if($message == '') {

            if($asset->update($id,$market,$symbol,$name,$currency,$nominal)){

                Logger::log(sprintf('Asset updated.  Market: "%s", Symbol: "%s", Name: "%s"', $market, $symbol, $name));

                $success = TRUE;

                $message = $this->f3->get('trade.assets.save_success');

            }else{

                $message = $this->f3->get('trade.assets.save_error');

            }

        }

        

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    

    if($action == 'delete'){

        $symbol = $f3->get('POST.symbol');

        if($asset->delete($symbol)){

            $success = TRUE;

            $message = $this->f3->get('trade.assets.delete_success');

        }

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

  }

  

  function apiDepot($f3, $params){

    $success = FALSE;

    $message = '';

    $action = $f3->get('PARAMS.action');

    

    $user = $this->f3->get('USER');

    $user_id = $user->id;

    

    if($action == 'save'){

        $amount = $f3->get('POST.amount');

        $type = $f3->get('POST.type');

        $date = $f3->get('POST.date');

        $time = $f3->get('POST.time');

        $notes = $f3->get('POST.notes');

        

        if(!isset($amount) || $amount == '' || !is_numeric($amount)){

            $message = $this->f3->get('depot.amount_incorrect');

        }elseif(!isset($type) || $type == ''){

            $message = $this->f3->get('depot.type_incorrect');

        }elseif(!isset($date) || $date == ''){

            $message = $this->f3->get('depot.date_incorrect');

        }elseif(!isset($time) || $time == ''){

            $message = $this->f3->get('depot.time_incorrect');

        }

        

        if($message == ''){

            if (isset($_FILES['receipt_doc']) && $_FILES['receipt_doc']['name']!='') {

                $uploadedFileName = $_FILES['receipt_doc']['name']; 

                $uploadedFilePath = $_FILES['receipt_doc']['tmp_name']; 

                $uploadedFileSize = $_FILES['receipt_doc']['size'];

                $uploadedFileType = $_FILES['receipt_doc']['type'];

                $uploadedFileExt = pathinfo($uploadedFileName, PATHINFO_EXTENSION); 

                $storedFileName = sha1($user_id.$user->first_name.$user->last_name.microtime(true)).'.'.$uploadedFileExt; 

                

                if (!file_exists(self::DOC_UPLOAD_DIR)) { 

                    mkdir(self::DOC_UPLOAD_DIR, 0777, TRUE);

                }

                

                if (!in_array($uploadedFileType, ['application/pdf'])){

                    $message = $this->f3->get('depot.incorrect_file_extension');

                } elseif ($uploadedFileSize > self::MAX_DOC_SIZE) { 

                    $message = $this->f3->get('depot.file_size_too_big'); 

                } elseif (!move_uploaded_file($uploadedFilePath, self::DOC_UPLOAD_DIR.$storedFileName)) { 

                    $message = $this->f3->get('depot.file_not_saved'); 

                }

    

                if ($message == '') {

                    $depot = new DepotModel();

                    if ($depot->add(['user_id' => $user_id, 

                                     'amount' => $amount, 

                                     'type' => $type, 

                                     'date' => $date, 

                                     'time' => $time, 

                                     'notes' => $notes, 

                                     'doc_path' => $storedFileName,

                                     'status' => 0

                                    ])) { 

                        Logger::log(sprintf('Depot request added.  File: "%s", Status: "%s", ID: "%s"', $depot->doc_path, $depot->status, $depot->id));

                        $success = TRUE;

                        $message = $this->f3->get('depot.save_success'); 

                    }

                }

            }else{

                $message = $this->f3->get('depot.file_not_found');

            }

        }

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    // Works with admin privileges 

    if($action == 'update'){

        if(!$this->f3->get('USER')->is_admin){

            $message = $this->f3->get('portfolio.edit.permission.message');

            print json_encode(array('success' => $success, 'message' => $message));

            exit;

        }

        $depot_id = $f3->get('POST.depot_id');

        $status = $f3->get('POST.status');

        $depot = (new DepotModel())->getById($depot_id);

        $data = null;

        $data = ['status' => $status, 'processed' => $status ? Helper::timeStamp() : null];

        if ($depot->edit($data)) {

            Logger::log(sprintf('Depot updated. Status: "%s", ID: "%s"', $depot->status, $depot->id));

            $success = TRUE;

            $message = $this->f3->get('depot.edit_success'); 

        }else{

            $message = $this->f3->get('depot.edit_failed'); 

        }

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    if($action == 'delete'){

        if(!$this->f3->get('USER')->is_admin){

            $message = $this->f3->get('portfolio.edit.permission.message');

            print json_encode(array('success' => $success, 'message' => $message));

            exit;

        }

        $depot_id = $this->f3->get('POST.depot_id');

        if ((new DepotModel())->delete($depot_id)) {

            Logger::log(sprintf('Depot deleted. ID: "%s"', $depot_id));

            $success = TRUE;

            $message = $this->f3->get('depot.delete_success'); 

        }else{

            $message = $this->f3->get('depot.delete_failed'); 

        }

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    if($action == 'upcount'){

        if(!$this->f3->get('USER')->is_admin){

            $message = $this->f3->get('portfolio.edit.permission.message');

            print json_encode(array('success' => $success, 'message' => $message));

            exit;

        }

        $success = TRUE;

        $count = (new DepotModel())->countUnprocessed();

        print json_encode(array('success' => $success, 'message' => $count));

    }

    

    if($action == 'history'){

        // check if user id is passed to filter by user (only for admin)

        $depotModel = new DepotModel();

        if(isset($params['user_id'])){

            if(!$this->f3->get('USER')->is_admin){

                $message = $this->f3->get('portfolio.edit.permission.message');

                print json_encode(array('success' => $success, 'message' => $message));

                exit;

            }else{

                $userId = $params['user_id'];

                $transactions = $depotModel->getByUserId($userId);

                print json_encode($transactions, JSON_NUMERIC_CHECK);

            }

        }else{

            if(!$this->f3->get('USER')->is_admin){

                $userId = $this->f3->get('USER')->id;

                $transactions = $depotModel->getByUserId($userId);

                print json_encode($transactions, JSON_NUMERIC_CHECK);

            }else{

                $transactions = $depotModel->all();

                print json_encode($transactions, JSON_NUMERIC_CHECK);

            }

        }

    }

    

  }



  function apiPortfolio($f3, $params){

    $success = FALSE;

    $message = '';

    $action = $f3->get('PARAMS.action');

    

    $trade_id = $f3->get('POST.trade_id');

    $user_id = $f3->get('POST.user_id');



    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }



    // get user from passed user id if trading on behalf of other user (admin feature)

    $user = $this->f3->get('USER')->is_admin && intval($user_id)>0 ? (new UserModel())->getById(intval($user_id)) : $this->f3->get('USER');

    

    $trade = new TradeModel($user_id);



    if($action == 'price'){

        $price = $f3->get('POST.price');

        if($trade->updatePrice($trade_id, $price)>0){

            $success = TRUE;

            $message = sprintf($this->f3->get('portfolio.edit.price.success.message', $price));

        }else{

            $message = $this->f3->get('portfolio.edit.price.error.message');

        }

        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

        

    }

    

    if($action == 'quantity'){

        $quantity = $f3->get('POST.quantity');

        

        if($trade->updateQuantity($trade_id, $quantity)>0){

            $success = TRUE;

        }

        $message = sprintf($this->f3->get('portfolio.edit.quantity.success.message', $quantity));

        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    

    if($action == 'rate'){

        $rate = $f3->get('POST.rate');

        

        if($trade->updateFxRate($trade_id, $rate)>0){

            $success = TRUE;

        }

        $message = sprintf($this->f3->get('portfolio.edit.rate.success.message', $rate));

        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    

    if($action == 'total'){

        $total = $f3->get('POST.total');

        

        if($trade->updateTotal($trade_id, $total)>0){

            $success = TRUE;

            $message = sprintf($this->f3->get('portfolio.edit.total.success.message', $total));

        }else{

            $message = $this->f3->get('portfolio.edit.total.error.message');

        }

        

        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

    if($action == 'all'){

        $price = $f3->get('POST.price');

        $total = $f3->get('POST.total');

        $rate = $f3->get('POST.rate');

        $quantity = $f3->get('POST.quantity');

        $start = $f3->get('POST.start_date');

        $end = $f3->get('POST.end_date');

        $duration = $f3->get('POST.duration');



        if($trade->updateAll($trade_id, $price, $total, $rate, $quantity, $start, $end, $duration)){

            $success = TRUE;

            $message = $this->f3->get('portfolio.edit.success.message');

        }else{

            $message = $this->f3->get('portfolio.edit.error.message');

        }

        

        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }  

    

    if ($action == 'delete') {

        $id = $f3->get('POST.id');

        $user_id = $this->f3->get('USER')->id;

        $trade = new TradeModel($id);

        

        Logger::log('Delete portfolio');



       if($trade->delete($id)){

           $success = TRUE;

           $message = "Portfolio deleted";

       }else{

           $message = "An error occured while deleting the portfolio!";

       }



        Logger::log($message);

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }

  }



  function apiAnleihenEdit($f3, $params){

    $success = FALSE;

    $message = '';



    $bond_id = $f3->get('POST.anleihen_id');

    $user_id = $f3->get('POST.user_id');



    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }



    // get user from passed user id if trading on behalf of other user (admin feature)

    $user = $this->f3->get('USER')->is_admin && intval($user_id)>0 ? (new UserModel())->getById(intval($user_id)) : $this->f3->get('USER');

    

    $trade = new AnleihenModel($user_id);



    

    $symbol = $this->f3->get('POST.symbol');                                    // Name

    $fxRate = floatval($this->f3->get('POST.fx_rate'));                         // Kaufkurs

    $currentFx = floatVal($this->f3->get('POST.current_fx'));                   // aktueller Kurs

    $quantity = abs(intval($this->f3->get('POST.quantity')));                   // St���ck

    $price = floatval($this->f3->get('POST.price'));                            // Kaufwert

    $currentPrice = floatval($this->f3->get('POST.current_price'));             // Wert

    $startDate = $this->f3->get('POST.start_date');                             // Laufzeitbeginn

    $endDate = $this->f3->get('POST.end_date');                                 // Laufzeitende

    $interestDate = $this->f3->get('POST.interest_date');                       // Zinstermin

    $total = $this->f3->get('POST.total');                                      // ges.

    $notes = $this->f3->get('POST.notes');                                      // 



    if($trade->updateAll($bond_id, $symbol, $quantity, $fxRate, $price, $startDate, $endDate, $currentFx, $currentPrice, $total, $interestDate, $notes)>0){

        $success = TRUE;

        $message = $this->f3->get('portfolio.edit.anleihen.success.message');

    }else{

        $message = $this->f3->get('portfolio.edit.anleihen.error.message');

    }

    

    Logger::log($message);

    print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

  }



  function apiFondsEdit($f3, $params){

    $success = FALSE;

    $message = '';



    $bond_id = $f3->get('POST.fonds_id');

    $user_id = $f3->get('POST.user_id');



    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }



    // get user from passed user id if trading on behalf of other user (admin feature)

    $user = $this->f3->get('USER')->is_admin && intval($user_id)>0 ? (new UserModel())->getById(intval($user_id)) : $this->f3->get('USER');

    

    $trade = new FondsModel($user_id);



    

    $symbol = $this->f3->get('POST.symbol');                                    // Name

    $profitLoss = floatval($this->f3->get('POST.profit_loss'));             // Kaufkurs

    $ROI = floatVal($this->f3->get('POST.roi'));                   // aktueller Kurs

    $issuer = $this->f3->get('POST.issuer');

    $domicile = $this->f3->get('POST.domicile');

    $currentValue = floatval($this->f3->get('POST.current_value'));                            // Kaufwert

    $originValue = floatval($this->f3->get('POST.origin_value'));             // Wert

    $notes = $this->f3->get('POST.notes');                                      // 



    if($trade->updateAll($bond_id, $symbol, $issuer, $domicile, $profitLoss, $currentValue, $ROI, $originValue, $notes)>0){

        $success = TRUE;

        $message = $this->f3->get('portfolio.edit.fonds.success.message');

    }else{

        $message = $this->f3->get('portfolio.edit.fonds.error.message');

    }

    

    Logger::log($message);

    print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

  }



  function apiLimitOrder($f3, $params){

    $success = FALSE;

    $message = '';

    

    $action = $this->f3->get('PARAMS.action');

    

    $orderModel = new LimitOrderModel();

    

    if($action == 'add'){

        $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user'))) : $this->f3->get('USER');

        $symbol = $f3->get("POST.symbol");

        $currentPrice = $f3->get("POST.current_price");

        $stopPrice = $f3->get("POST.stop_price");

        $limitPrice = $f3->get("POST.limit_price");

        $limitType = $f3->get("POST.limit_type");

        $orderType = $f3->get("POST.order_type");

        $orderTimeType = $f3->get("POST.ordertime_type");

        $marketAmount = $f3->get("POST.market_amount");

        $limitAmount = $f3->get("POST.limit_amount");

        $total = $f3->get("POST.total");

        

        if($total = ''){

            if($limitType == 0){

                $total = $limitPrice * $limitAmount;

            }else if($limitType == 1){

                $total = $currentPrice * $marketAmount;

            }else if($limitType == 2){

                $total = $stopPrice * $limitAmount;

            }

        }

        

        if($user && $symbol != '' && $currentPrice != '' && $limitType != '' && ($marketAmount != '' || $limitAmount != '')){

            $direction = $orderType == 'buy' ? -1 : 1;

            if ($asset = (new AssetModel())->get($symbol)) {

                if($orderModel->add([

                    'user_id' => $user->id,

                    'asset_id' => $asset->id,

                    'current_price' => $currentPrice,

                    'stop_price' => $stopPrice,

                    'limit_price' => $limitPrice,

                    'limit_type' => $limitType,

                    'order_type' => $direction,

                    'ordertime_type' => $orderTimeType,

                    'market_amount' => $marketAmount,

                    'limit_amount' => $limitAmount,

                    'total' => $total

                    ])){

                    $success = TRUE;

                    $message = $this->f3->get('signals.add.success');

                }else{

                    $message = $this->f3->get('signals.add.error');

                }

            }else{

                $message = $this->f3->get('signals.add.asset_not_found');

            }

        } else {

            $message = $this->f3->get('signals.add.required_field');

        }

    }else if($action == 'delete'){

        $signal_id = $this->f3->get('POST.signal_id');

        $signal = $orderModel->getById($signal_id);

        if(!$this->f3->get('USER')->is_admin && $this->f3->get('USER')->id != $signal->user_id){

            $message = 'You don\'t have permission to delete this item!';

        }else {

           if($orderModel->delete($signal_id)){

                $success = TRUE;

                $message = $this->f3->get('signals.delete.success');

            }else{

                $message = $this->f3->get('signals.delete.error');

            }

        }

    }else if($action == 'approve'){

        $signal_id = $this->f3->get('POST.signal_id');

        $signal = $orderModel->getById($signal_id);

        if(!$this->f3->get('USER')->is_admin){

            $message = 'You don\'t have permission to delete this item!';

        }else {

            if($orderModel->approve($signal_id)){

                $success = TRUE;

                $message = $this->f3->get('signals.approve.success');

            }else{

                $message = $this->f3->get('signals.approve.error');

            }

        }

    }else if($action == 'all'){

        $user = $this->f3->get('PARAMS.user');

        $signals = [];

        if($this->f3->get('USER')->is_admin){

            if($user != ''){

                $signals = $orderModel->getByUserId($user);

            }

            else{

                $signals = $orderModel->all();

            }

        }else{

            $signals = $orderModel->getByUserId($this->f3->get('USER')->id);

        }

        print json_encode($signals, JSON_NUMERIC_CHECK);

        exit;

    }else{

        $message='Your query is invalid!';

    }



    print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

  }



  function apiTrade($f3, $params) {

    $success = FALSE;

    $message = '';



    if (($symbol = $this->f3->get('POST.symbol')) && ($quantity = abs(intval($this->f3->get('POST.quantity')))) && ($action = $this->f3->get('POST.action'))) {

      Logger::log(sprintf('New trade: %s %d %s', $action, $quantity, $symbol));

      // get user from passed user id if trading on behalf of other user (admin feature)

      $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user'))) : $this->f3->get('USER');



      if ($asset = (new AssetModel())->get($symbol)) {

        $accountCurrency = $user->currency;

        // when asset currency and user account currency are different we need to retrieve FX rate

        if ($asset->currency != $accountCurrency) {

          // When translating from USD to other currencies we use a shortcut, like EUR=X (USD/EUR), GBP=X (USD/GBP)

          // in other cases we use normal pair like EURUSD=X (EUR/USD), GBPUSD=X (GBP/USD)

          $fxSymbol = $asset->currency=='USD' ? $accountCurrency.'=X' : $asset->currency.$accountCurrency.'=X';

        }



        // Retrieve latest market data. When currencies are different we also retrieve FX rate to convert from asset currency to balance currency

        if ($quote = $this->getQuotes(isset($fxSymbol) ? [$symbol, $fxSymbol] : [$symbol], $this->latest_quote)) {

          $direction = $action == 'buy' ? 1 : -1;

          $position = (new PositionModel($user->id))->get($symbol);

          $currentQuantity = isset($position['quantity']) ? $position['quantity'] : 0;

          $currentHistoricalCost = isset($position['historical_cost']) ? $position['historical_cost'] : 0;

          $shortSaleQuantity = $direction == -1 ? ($currentQuantity>0 ? abs(min(0,$currentQuantity-$quantity)) : $quantity) : 0; // need to take into account current long position in this asset

          $lastPrice = isset($quote[$symbol]->regularMarketPrice) ? floatval($quote[$symbol]->regularMarketPrice) : 0;

          $nominal = $asset->nominal;

          $fxRate = isset($fxSymbol) && isset($quote[$fxSymbol]->regularMarketPrice) ? floatval($quote[$fxSymbol]->regularMarketPrice) : 1;

          $commission = floatval($this->f3->get('TRADE.COMMISSION'));

          $tradeAmount = round($lastPrice * $nominal * $quantity * $direction * $fxRate, 2);

          $shortSaleTradeAmount = $shortSaleQuantity ? round($lastPrice * $nominal * $shortSaleQuantity * $direction * $fxRate, 2) : 0;

          $currentBalance = !empty($user->balance)?$user->balance:0;

          $newBalance = $currentBalance - $tradeAmount - $commission;



          // Calculate historical cost

          //http://quant.stackexchange.com/questions/9002/calculate-average-price-cost-unrealized-pl-of-a-position-based-on-executed/9037#9037

          if ($currentQuantity != 0) {

            $closingQty = Helper::sign($currentQuantity) != $direction ? min(abs($currentQuantity), $quantity) * $direction : 0;

            $openingQty = Helper::sign($currentQuantity) == $direction ? $quantity * $direction : $quantity * $direction - $closingQty;

            $newHistoricalCost = $currentHistoricalCost + $openingQty * $lastPrice * $nominal * $fxRate + $closingQty * $currentHistoricalCost / $currentQuantity + $commission;

          } else {

            $newHistoricalCost = $tradeAmount + $commission;

          }



          Logger::log(sprintf('Qty: %d, Price: %f %s (%f), FX: %f, Com: %f, Amount: %f, Prev Balance: %f, New Balance: %f, New Hist Cost: %f', $quantity * $direction, $lastPrice, $asset->currency, $nominal, $fxRate, $commission, abs($tradeAmount), $currentBalance, $newBalance, $newHistoricalCost));

          if ($quantity == 0) {

            $message = $this->f3->get('trade.form.error1');

          } elseif ($lastPrice==0) {

            $message = $this->f3->get('trade.form.error2');

          } elseif (isset($fxSymbol) && $fxRate==1) {

            $message = $this->f3->get('trade.form.error3', [$asset->currency, $accountCurrency]);

          } elseif (!(new MarketModel())->isOpen($symbol)) {

            $message = $this->f3->get('trade.form.error4');

          } elseif ($newBalance < 0) {

            $message = $this->f3->get('trade.form.error5');

          // do not allow short sales if it's disabled

          } elseif ($shortSaleQuantity > 0 && $this->f3->get('TRADE.SHORT_TRADING')==0) {

            $message = $this->f3->get('trade.form.error10');

          // if selling short and trade amount is greater than current balance

          } elseif ($shortSaleQuantity > 0 && $shortSaleTradeAmount > $currentBalance) {

            $message = $this->f3->get('trade.form.error6');

          } elseif ($tradeId = (new TradeModel($user->id))->create($symbol, $quantity * $direction, $lastPrice, $fxRate, $commission, abs($tradeAmount), $newBalance, $newHistoricalCost)) {

            $success = TRUE;

            $currentBalance = $newBalance;

            $message = sprintf($this->f3->get('trade.form.trade.success.message',

              [

                ($direction == 1 ? $this->f3->get('trade.form.trade.success.action.buy') : $this->f3->get('trade.form.trade.success.action.sell')),

                $quantity,

                ($quantity > 1 ? $this->f3->get('trade.form.trade.success.shares') : $this->f3->get('trade.form.trade.success.share')),

                $symbol,

                Helper::formatNumber($lastPrice, 2),

                $asset->currency,

                (isset($fxSymbol)?' ('.str_replace('=X','',$fxSymbol).' '.$this->f3->get('trade.form.trade.success.fxrate').' '.round($fxRate,4).')':''),

                Helper::formatNumber(abs($tradeAmount), 2),

                $accountCurrency,

                Helper::formatNumber($commission, 2),

                $accountCurrency

              ])

            );

          } else {

            $message = $this->f3->get('trade.form.error7');

          }

        } else {

          $message = $this->f3->get('trade.form.error8');

        }

      } else {

        $message = $this->f3->get('trade.form.error9');

      }

    }

    Logger::log($message);

    print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);

  }



  function apiAnleihenDelete($f3, $params){

      $success = FALSE;

      $message = '';

      if ($id = $this->f3->get('POST.id')){

          if((new AnleihenModel($user->id))->delete($id)>0){

              $success = TRUE;

              $message = 'Deleted successfully';

          }

      }

      Logger::log($message);

      print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);



  }



  function apiAnleihenTrade($f3, $params) {

    $success = FALSE;

    $message = '';



    if (($symbol = $this->f3->get('POST.symbol')) &&                            // Name

        ($quantity = abs(intval($this->f3->get('POST.quantity')))) &&           // St���ck

        ($fxRate = floatval($this->f3->get('POST.fx_rate'))) &&                 // Kaufkurs

        ($currentFx = floatval($this->f3->get('POST.current_fx'))) &&           // aktueller Kurs

        ($startDate = $this->f3->get('POST.start_date')) &&                     // Laufzeitbeginn

        ($endDate = $this->f3->get('POST.end_date')) &&                         // Laufzeitende

        ($currentPrice = floatval($this->f3->get('POST.current_price')))        // Wert

        ) {

        $price = floatval($this->f3->get('POST.price'));                         // Kaufwert

        $interestDate = $this->f3->get('POST.interest_date');                   // Zinstermin

        $total = floatval($this->f3->get('POST.total'));

        $notes = $this->f3->get('POST.notes');

        

    //   Logger::log(sprintf('New bond: %s %d %s', $symbol, $quantity, $price));



      // get user from passed user id if trading on behalf of other user (admin feature)

      $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

      

      if ($asset = (new AssetModel())->getAnleihenAsset($symbol)) {

        $accountCurrency = $user->currency;

        // when asset currency and user account currency are different we need to retrieve FX rate

        if ($asset->currency != $accountCurrency) {

          // When translating from USD to other currencies we use a shortcut, like EUR=X (USD/EUR), GBP=X (USD/GBP)

          // in other cases we use normal pair like EURUSD=X (EUR/USD), GBPUSD=X (GBP/USD)

          $fxSymbol = $asset->currency=='USD' ? $accountCurrency.'=X' : $asset->currency.$accountCurrency.'=X';

        }

        $lastPrice = $price;

        $message = $lastPrice;

        // $nominal = $asset->nominal;

        $commission = floatval($this->f3->get('TRADE.COMMISSION'));

        $tradeAmount = $total;

        // $tradeAmount = round($lastPrice * $nominal * $quantity * $fxRate, 2);

        $currentBalance = !empty($user->balance)?$user->balance:0;

        $newBalance = $currentBalance; // - $tradeAmount - $commission;

        // Logger::log(sprintf('Qty: %d, Price: %f %s (%f), FX: %f, Com: %f, Amount: %f, Prev Balance: %f, New Balance: %f, New Hist Cost: %f', $quantity * $direction, $lastPrice, $asset->currency, $nominal, $fxRate, $commission, abs($tradeAmount), $currentBalance, $newBalance, $newHistoricalCost));

        if ($quantity == 0) {

            $message = $this->f3->get('trade.form.error1');

        } elseif ($lastPrice==0) {

            $message = $this->f3->get('trade.form.error2');

        } elseif (isset($fxSymbol) && $fxRate==1) {

            $message = $this->f3->get('trade.form.error3', [$asset->currency, $accountCurrency]);

        } elseif (!(new MarketModel())->isOpen($symbol)) {

            $message = $this->f3->get('trade.form.error4');

        } elseif ($tradeId = (new AnleihenModel($user->id))->create($symbol, $quantity, $fxRate, $price, $startDate, $endDate, $currentFx, $currentPrice, $total, $interestDate, $notes)) {

            $success = TRUE;

            $currentBalance = $newBalance;

            $message = sprintf($this->f3->get('portfolio.add.anleihen.success.message',

              [

                $quantity,

                ($quantity > 1 ? $this->f3->get('portfolio.add.anleihen.success.shares') : $this->f3->get('portfolio.add.anleihen.success.share')),

                $symbol,

                Helper::formatNumber($lastPrice, 2),

                $asset->currency,

                (isset($fxSymbol)?' ('.str_replace('=X','',$fxSymbol).' '.$this->f3->get('trade.form.trade.success.fxrate').' '.round($fxRate,4).')':''),

                Helper::formatNumber(abs($tradeAmount), 2),

                $accountCurrency,

                Helper::formatNumber($commission, 2),

                $accountCurrency

              ])

            );

        } 

        else {

            $message = $this->f3->get('trade.form.error7');

        }

      } else {

        $message = $this->f3->get('trade.form.error9');

      }

    } else{

        $message = $this->f3->get('trade.form.field_fill_error');

    }

    Logger::log($message);

    print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);

  }



  function apiFondsDelete($f3, $params){

      $success = FALSE;

      $message = '';

      if ($id = $this->f3->get('POST.id')){

          if((new FondsModel($user->id))->delete($id)>0){

              $success = TRUE;

              $message = 'Deleted successfully';

          }

      }

      Logger::log($message);

      print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);



  }



  function apiFondsTrade($f3, $params) {

    $success = FALSE;

    $message = '';



    if (($symbol = $this->f3->get('POST.symbol')) &&                            // Name

        //($quantity = abs(intval($this->f3->get('POST.quantity')))) &&           // St���ck

        ($issuer = $this->f3->get('POST.issuer')) &&    

        ($domicile = $this->f3->get('POST.domicile')) &&    

        ($profitLoss = floatval($this->f3->get('POST.profit_loss'))) &&         // Kaufkurs

        ($ROI = floatval($this->f3->get('POST.roi'))) &&           // aktueller Kurs

        ($originValue = floatval($this->f3->get('POST.origin_value')))        // Wert

        ) {

        $currentValue = floatval($this->f3->get('POST.current_value'));                         // Kaufwert

        $notes = $this->f3->get('POST.notes');

        

    //   Logger::log(sprintf('New bond: %s %d %s', $symbol, $quantity, $price));



      // get user from passed user id if trading on behalf of other user (admin feature)

      $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

      

      if ($asset = (new AssetModel())->getFondsAsset($symbol)) {

        $accountCurrency = $user->currency;

        // when asset currency and user account currency are different we need to retrieve FX rate

        if ($asset->currency != $accountCurrency) {

          // When translating from USD to other currencies we use a shortcut, like EUR=X (USD/EUR), GBP=X (USD/GBP)

          // in other cases we use normal pair like EURUSD=X (EUR/USD), GBPUSD=X (GBP/USD)

          $fxSymbol = $asset->currency=='USD' ? $accountCurrency.'=X' : $asset->currency.$accountCurrency.'=X';

        }

        

        $quantity = 2;

        //$lastPrice = $price;

        //$message = $lastPrice;

        /*

        if ($quantity == 0) {

            $message = $this->f3->get('trade.form.error1');

        } elseif ($lastPrice==0) {

            $message = $this->f3->get('trade.form.error2');

        } elseif (isset($fxSymbol) && $fxRate==1) {

            $message = $this->f3->get('trade.form.error3', [$asset->currency, $accountCurrency]);

        } else */

        if (!(new MarketModel())->isOpen($symbol)) {

            $message = $this->f3->get('trade.form.error4');

        } elseif ($tradeId = (new FondsModel($user->id))->create($symbol, $issuer, $domicile, $profitLoss, $currentValue, $ROI, $originValue, $notes)) {

            $success = TRUE;

            $currentBalance = $newBalance;

            $message = sprintf($this->f3->get('portfolio.add.fonds.success.message',

              [

                $quantity,

                ($quantity > 1 ? $this->f3->get('portfolio.add.fonds.success.shares') : $this->f3->get('portfolio.add.fonds.success.share')),

                $symbol,

                Helper::formatNumber($lastPrice, 2),

                $asset->currency,

                (isset($fxSymbol)?' ('.str_replace('=X','',$fxSymbol).' '.$this->f3->get('trade.form.trade.success.fxrate').' '.round($fxRate,4).')':''),

                Helper::formatNumber(abs($tradeAmount), 2),

                $accountCurrency,

                Helper::formatNumber($commission, 2),

                $accountCurrency

              ])

            );

        } 

        else {

            $message = $this->f3->get('trade.form.error7');

        }

      } else {

        $message = $this->f3->get('trade.form.error9');

      }

    } else{

        $message = $this->f3->get('trade.form.field_fill_error');

    }

    Logger::log($message);

    print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);

  }



  function apiFunds($f3, $params) {

    $success = FALSE;

    $message = '';

    

    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }

    

    $action = $this->f3->get('PARAMS.action');

    

    if($action == 'add'){

        $symbol = $this->f3->get('POST.symbol');                                // Name

        $quantity = $this->f3->get('POST.quantity');               // St端ck

        $price = $this->f3->get('POST.price');                        // Kaufkurs

        $issuePrice = ($this->f3->get('POST.issue_price'));             // Emissionskurs

        $currentPrice = ($this->f3->get('POST.current_price'));         // heutiger Kurs

        $totalPrice = floatval($this->f3->get('POST.total_price'));             // Gesamtkaufpreis

        $value = floatval($this->f3->get('POST.value'));                        // Wert

        $notes = $this->f3->get('POST.notes');                                  // Erstnotiz

        $interestDate = $this->f3->get('POST.interest_date');                       // Zinstermin

        

        $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

        

        if ((new AssetModel())->getFundsAsset($symbol)) {

            if ($quantity == 0) {

                $message = $this->f3->get('portfolio.fund.quantity_error');

            } elseif (!(new MarketModel())->isOpen($symbol)) {

                $message = $this->f3->get('portfolio.fund.market_error');

            } 

            elseif ((new FundsModel($user->id))->create($symbol, $quantity, $price, $issuePrice, $currentPrice, $totalPrice, $value, $notes, $interestDate)) {

                $success = TRUE;

                $message = $this->f3->get('portfolio.fund.add_success');

            } 

            else {

                $message = $this->f3->get('portfolio.fund.submit_error');

            }

        } else {

            $message = $this->f3->get('portfolio.fund.unknown_symbol');

        }

        

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

        

    } else if($action == 'edit') {

        $fundId = $this->f3->get('POST.fund_id');

        $symbol = $this->f3->get('POST.symbol');                                // Name

        $quantity = $this->f3->get('POST.quantity');               // St端ck

        $price = $this->f3->get('POST.price');                        // Kaufkurs

        $issuePrice = ($this->f3->get('POST.issue_price'));             // Emissionskurs

        $currentPrice = ($this->f3->get('POST.current_price'));         // heutiger Kurs

        $totalPrice = floatval($this->f3->get('POST.total_price'));             // Gesamtkaufpreis

        $value = floatval($this->f3->get('POST.value'));                        // Wert

        $notes = $this->f3->get('POST.notes');                                  // Erstnotiz

        $interestDate = $this->f3->get('POST.interest_date');                       // Zinstermin

        

        $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

        

        if ((new AssetModel())->getFundsAsset($symbol)) {

            if ($quantity == 0) {

                $message = $this->f3->get('portfolio.fund.quantity_error');

            } elseif (!(new MarketModel())->isOpen($symbol)) {

                $message = $this->f3->get('portfolio.fund.market_error');

            } elseif ((new FundsModel($user->id))->updateAll($fundId, $symbol, $quantity, $price, $issuePrice, $currentPrice, $totalPrice, $value, $notes, $interestDate)) {

                $success = TRUE;

                $message = $this->f3->get('portfolio.fund.edit_success');

            } else {

                $message = $this->f3->get('portfolio.fund.submit_error');

            }

        } else {

            $message = $this->f3->get('portfolio.fund.unknown_symbol');

        }

        

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

        

    } else if($action == 'delete') {

      $success = FALSE;

      $message = '';

      if ($id = $this->f3->get('POST.id')){

          if((new FundsModel($user->id))->delete($id)>0){

              $success = TRUE;

              $message = $this->f3->get('portfolio.fund.delete_success');

          }

      }

      print json_encode(array('success' => $success, 'message' => $message, 'balance' => $currentBalance), JSON_NUMERIC_CHECK);

    }

  }







  function apiFixedDeposit($f3, $params) {

    $success = FALSE;

    $message = '';

    

    if(!$this->f3->get('USER')->is_admin){

        $message = $this->f3->get('portfolio.edit.permission.message');

        print json_encode(array('success' => $success, 'message' => $message));

        exit;

    }

    

    $action = $this->f3->get('PARAMS.action');

    

    if($action == 'add'){

        $symbol = $this->f3->get('POST.symbol');                                // Name

        $amount = $this->f3->get('POST.amount');                                  // Datum

        $total = floatval($this->f3->get('POST.total'));                      // Summe

        $interestRate = floatval($this->f3->get('POST.interest_rate'));         // Zinssatz

        $notes = $this->f3->get('POST.notes'); 

        $building = 0;//$this->f3->get('POST.building');                         // Beginn

        $totalvalue = 0;//$this->f3->get('POST.totalvalue');                             // Ende



        $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

        

        if ((new AssetModel())->getFixedDepositAsset($symbol)) {

            if (!(new MarketModel())->isOpen($symbol)) {

                $message = $this->f3->get('portfolio.fixed_deposit.market_error');

            } 

            elseif ((new FixedDepositModel($user->id))->create($symbol, $total, $amount, $interestRate, $building, $totalvalue, $notes)) {

                $success = TRUE;

                $message = $this->f3->get('portfolio.fixed_deposit.add_success');

            } 

            else {

                $message = $this->f3->get('portfolio.fixed_deposit.submit_error');

            }

        } else {

            $message = $this->f3->get('portfolio.fixed_deposit.unknown_symbol');

        }

        

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

        

    } else if($action == 'edit') {

        $depositId = $this->f3->get('POST.deposit_id');

        $symbol = $this->f3->get('POST.symbol');                                // Name

        $amount = $this->f3->get('POST.amount');                                  // Datum

        $total = floatval($this->f3->get('POST.total'));                      // Summe

        $interestRate = floatval($this->f3->get('POST.interest_rate'));         // Zinssatz

        $notes = $this->f3->get('POST.notes');                            

        $building = 0;//$this->f3->get('POST.building');                         // Beginn

        $totalvalue = 0;//$this->f3->get('POST.totalvalue');                             // Ende



        $user = $this->f3->get('USER')->is_admin && $this->f3->get('POST.user_id')>0 ? (new UserModel())->getById(intval($this->f3->get('POST.user_id'))) : $this->f3->get('USER');

        

        if ((new AssetModel())->getFixedDepositAsset($symbol)) {

            if (!(new MarketModel())->isOpen($symbol)) {

                $message = $this->f3->get('portfolio.fixed_deposit.market_error');

            } elseif ((new FixedDepositModel($user->id))->updateAll($depositId, $symbol, $total, $amount, $interestRate, $building, $totalvalue)) {

                $success = TRUE;

                $message = $this->f3->get('portfolio.fixed_deposit.edit_success');

            } else {

                $message = $this->f3->get('portfolio.fixed_deposit.submit_error');

            }

        } else {

            $message = $this->f3->get('portfolio.fixed_deposit.unknown_symbol');

        }

        

        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

        

    } else if($action == 'delete') {

      $success = FALSE;

      $message = '';

      if ($id = $this->f3->get('POST.id')){

          if((new FixedDepositModel($user->id))->delete($id)>0){

              $success = TRUE;

              $message = $this->f3->get('portfolio.fixed_deposit.delete_success');

          }

      }

      print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);

    }
 
  }





  /**

   * Get trades history for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetTradesHistory($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $tradeModel = new TradeModel($userId);

    $trades = $tradeModel->getAll();

    foreach ($trades as $key => $value) {
      
      $ex = $value['symbol'];
      $url = "https://query1.finance.yahoo.com/v8/finance/chart/$ex?region=US&lang=en-US&includePrePost=false&interval=1h&useYfid=true&range=1d";
      $stock_data = json_decode(file_get_contents($url), true);
      $trades[$key]['price']  = $stock_data['chart']['result'][0]['meta']['regularMarketPrice'];
      /* $value['price'] = $exchange->price; */


    }

    print json_encode($trades, JSON_NUMERIC_CHECK);

  }



  /**

    * Get offers anleihen for current or given user

    * @param $f3

    * @param $params

  */

  function apiGetOffersAnleihen($f3, $params) {

      // check if user id is passed to filter by user (only for admin)

      $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

      $anleihenModel = new OffersAnleihenModel($userId);

      $anleihe = $anleihenModel->getAll();

      print $anleihe;//json_encode($anleihe, JSON_NUMERIC_CHECK);

  }

    

  /**

   * Get anleihen history for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetAnleihenHistory($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $anleihenModel = new AnleihenModel($userId);

    $anleihe = $anleihenModel->getAll();

    print json_encode($anleihe, JSON_NUMERIC_CHECK);

  }

  /**

   * Get fonds history for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetFondsHistory($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $fondsModel = new FondsModel($userId);

    $fond = $fondsModel->getAll();

    print json_encode($fond, JSON_NUMERIC_CHECK);

  }

  

  /**

   * Get fund history for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetFundsHistory($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $fundsModel = new FundsModel($userId);

    $funds = $fundsModel->getAll();

    print json_encode($funds, JSON_NUMERIC_CHECK);

  }



  /**

   * Get fund history for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetFixedDepositHistory($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $depositModel = new FixedDepositModel($userId);

    $deposit = $depositModel->getAll();

    print json_encode($deposit, JSON_NUMERIC_CHECK);

  }

   

  /**

   * Get positions for current or given user

   * @param $f3

   * @param $params

   */

  function apiGetPositions($f3, $params) {

    // check if user id is passed to filter by user (only for admin)

    $userId = isset($params['user_id']) && $this->f3->get('USER')->is_admin ? intval($params['user_id']) : $this->f3->get('USER')->id;

    $positionModel = new PositionModel($userId);

    $positions = $positionModel->getList();

    print json_encode($positions, JSON_NUMERIC_CHECK);

  }



    function apiUsersApproval($f3, $params){

        $action = $this->f3->get('PARAMS.action');

        $user = $this->f3->get('USER'); 

        $success = FALSE;

        $message = 'An error occured!';

        if($action == 'upload'){

            if (isset($_FILES['identity']) && $_FILES['identity']['name']!='') {

                $uploadedFileName = $_FILES['identity']['name']; 

                $uploadedFilePath = $_FILES['identity']['tmp_name']; 

                $uploadedFileSize = $_FILES['identity']['size'];

                $uploadedFileType = $_FILES['identity']['type'];

                $uploadedFileExt = pathinfo($uploadedFileName, PATHINFO_EXTENSION); 

                $storedFileName = sha1($user->id.$user->first_name.$user->last_name).'.'.$uploadedFileExt; 

                

                if (!file_exists(self::IDENTITY_UPLOAD_DIR)) { 

                    mkdir(self::IDENTITY_UPLOAD_DIR, 0777, TRUE);

                }

                

                if (!getimagesize($uploadedFilePath) || !in_array($uploadedFileType, ['image/png', 'image/jpeg', 'image/jpg'])){

                    $imageUploadError = $this->f3->get('profile.identity.incorrect_file_extension');

                } elseif ($uploadedFileSize > self::MAX_IDENTITIY_SIZE) { 

                    $imageUploadError = $this->f3->get('profile.identity.image_size_too_big'); 

                } elseif (!move_uploaded_file($uploadedFilePath, self::IDENTITY_UPLOAD_DIR.$storedFileName)) { 

                    $imageUploadError = $this->f3->get('profile.identity.image_not_saved'); 

                }

    

                $message = $imageUploadError;

                

                if (is_null($imageUploadError)) { 

                    if ($user->edit(['identity_img' => $storedFileName, 'approved' => '1'])) { 

                        Logger::log(sprintf('User identity uploaded.  Identity Image File: "%s", Approval Status: "%s"', $user->identity_img, $user->approved));

                        $success = TRUE;

                        $message = $this->f3->get('profile.identity.upload_success'); 

                    }

                }

            }else{

                $message = $this->f3->get('profile.identity.file_not_found');

            }

        }elseif($action == 'approval'){

            if($f3->get('USER')->is_admin){

                $status = $this->f3->get('POST.status');

                $userid = $this->f3->get('POST.id');

                $user = new UserModel();

                $user->getById($userid);

                if($status == 'valid'){

                    if ($user->edit(['approved' => '2'])) {

                        $success = TRUE;

                        $message = $this->f3->get('profile.identity.approval_valid'); 

                    }

                }

                if($status == 'renew'){

                    if ($user->edit(['approved' => '0'])) {

                        $success = TRUE;

                        $message = $this->f3->get('profile.identity.approval_renew'); 

                    }

                }

            }

        }

        print json_encode(array('success' => $success, 'message' => $message));

    }





  /**

   * Add/modify users

   * @param $f3

   * @param $params

   */

  function apiModifyUsers($f3, $params) {

    // check that current user is admin

    if ($this->f3->get('USER')->is_admin) {

      $action = $this->f3->get('PARAMS.action');

      // Add new users

      if ($action == 'add') {

        $firstName = $f3->get('POST.first_name');

        $lastName = $f3->get('POST.last_name');

        $email = $f3->get('POST.email');

        $phone = $f3->get('POST.phone');

        $landPhone = $f3->get('POST.land_phone');

        $fax = $f3->get('POST.fax');

        $streetNr = $f3->get('POST.street_nr');

        $postNr = $f3->get('POST.post_nr');

        $town = $f3->get('POST.town');

        $newBalance = !empty($f3->get('POST.balance'))?$f3->get('POST.balance'):0;

        $accountNumber = $f3->get('POST.account_number');

        $isAdmin = $f3->get('POST.admin') == 'on' ? 1 : 0;

        $g2faEnabled = $f3->get('POST.g2fa_enabled') == 'on' ? 1 : 0;

        $sendWelcomeEmail = $f3->get('POST.welcome_email');



        $user = new UserModel();

        $user->getByEmail($email);



        if (!$user->dry()) {

          print json_encode([

            'success' => FALSE,

            'message' => $this->f3->get('users.add.error.user_exists')

          ]);

          exit;

        }



        $token = LoginController::generateToken();



        if ($user->add([

            'first_name' => $firstName,

            'last_name' => $lastName,

            'email' => $email,

            'phone' => $phone,

            'land_phone' => $landPhone,

            'fax' => $fax,

            'street_nr' => $streetNr,

            'post_nr' => $postNr,

            'town' => $town,

            'balance' => $newBalance,

            'currency' => $this->f3->get('TRADE.ACCOUNT_CURRENCY'),

            'password' => password_hash($token, PASSWORD_BCRYPT),

            'timezone' => $this->f3->get('SITE.TIMEZONE'),

            'language' => $this->f3->get('SITE.LANGUAGE'),

            'is_admin' => $isAdmin,

            'g2fa_enabled' => $g2faEnabled,

            'created' => Helper::timeStamp(),

            'account_number' => $accountNumber

          ])) {

          Logger::log(sprintf('User %d (%s) created by admin', $user->id, $email));

          // create a link for password reset

          $password_reset = new PasswordResetModel();

          $password_reset->add($user->id, $token);

          // add default watchlist symbols

          $watchlist = new WatchlistModel($user->id);

          $watchlist->addSymbols($this->f3->get('MARKETS.DEFAULT_WATCHLIST'));

          // send welcome email

          if ($sendWelcomeEmail) {

            $f3->set('vars.first_name', $lastName);

            $f3->set('vars.password_reset_url', Helper::baseUrl() . 'password-reset/' . $user->id . '/' . $token);

            $email = new Email($email, $this->f3->get('email.signup.subject', $f3->get('website.title')), 'email/signup.php');

          }

          print json_encode([

            'success' => TRUE,

            'message' => $this->f3->get('users.add.success')

          ]);

        } else {

          print json_encode([

            'success' => FALSE,

            'message' => $this->f3->get('users.add.general_error')

          ]);

        }

      } elseif ($action == 'edit') {

        $id = $f3->get('POST.id');

        $firstName = $f3->get('POST.first_name');

        $lastName = $f3->get('POST.last_name');

        $email = $f3->get('POST.email');

        $phone = $f3->get('POST.phone');

        $landPhone = $f3->get('POST.land_phone');

        $fax = $f3->get('POST.fax');

        $streetNr = $f3->get('POST.street_nr');

        $postNr = $f3->get('POST.post_nr');

        $town = $f3->get('POST.town');

        $password = $f3->get('POST.password');

        $blocked = $f3->get('POST.blocked')=='on' ? 1 : 0;

        $g2faEnabled = $f3->get('POST.g2fa_enabled') == 'on' ? 1 : 0;

        

        $user = new UserModel();

        $user->getById($id);



        // check if correct ID passed

        if ($user->dry()) {

          print json_encode([

            'success' => FALSE,

            'message' => $this->f3->get('users.edit.error.general_error')

          ]);

          exit;

        }



        // if email is updated check if it's unique

        if ($user->email != $email) {

          $userEmailCheck = new UserModel();

          $userEmailCheck->getByEmail($email);

          if (!$userEmailCheck->dry()) {

            print json_encode([

              'success' => FALSE,

              'message' => $this->f3->get('users.edit.error.dup_email')

            ]);

            exit;

          }

        }



        // Logger::log(sprintf('Edit user details, name: %s, email: %s, blocked: %s', $firstName.' '.$lastName, $email, $blocked));

        $user->edit([

          'first_name' => $firstName,

          'last_name' => $lastName,

          'email' => $email,

          'phone' => $phone,

          'land_phone' => $landPhone,

          'fax' => $fax,

          'street_nr' => $streetNr,

          'post_nr' => $postNr,

          'town' => $town,

          'password' => ($password ? password_hash($password, PASSWORD_BCRYPT) : $user->password),

          'blocked' => $blocked,

          'g2fa_enabled' => $g2faEnabled,

          'google_secret_code' => $g2faEnabled == 1 ? $user->google_secret_code : null

        ]);



        print json_encode([

          'success' => TRUE,

          'message' => $this->f3->get('users.edit.success')

        ]);



      // Add/remove funds

      } elseif ($action == 'funds') {

        $id = $f3->get('POST.id');

        $amount = floatval($f3->get('POST.amount'));

        $user = new UserModel();

        $user->getById($id);



        if (!$user->dry() && $amount!=0) {

          Logger::log(sprintf('Add/remove funds, amount: %f, current balance: %f', $amount, $user->balance));

          $tradeId = $this->cashTransaction($amount, $user);

        }



        if (isset($tradeId) && $tradeId>0) {

          print json_encode([

            'success' => TRUE,

            'message' => $this->f3->get('users.funds.success')

          ]);

        } else {

          print json_encode([

            'success' => FALSE,

            'message' => $this->f3->get('users.funds.general_error')

          ]);

        }

      // delete user

      } elseif ($action == 'delete') {

        $id = $f3->get('POST.id');

        $user = new UserModel();

        $user->getById($id);



        Logger::log(sprintf('Delete user %s %s (%s)', $user->first_name, $user->last_name, $user->email));



        $apiModel = new ApiModel();

        $apiModel->deleteUser($id);



        print json_encode([

          'success' => TRUE,

          'message' => $this->f3->get('users.delete.success')

        ]);

      }

    // if not admin just return negative status

    } else {

        print json_encode([

        'success' => FALSE

        ]);

    }

  }



  /**

   * Get balance change history for chart

   * @param $f3

   * @param $params

   */

  function apiGetBalanceHistory($f3, $params) {

    $result = [];

    // initial balance

    $result[] = [

      'date' => $this->f3->get('USER')->created,

      'action' => '',

      'balance' => $this->f3->get('TRADE.INITIAL_BALANCE')

    ];

    $tradeModel = new TradeModel($this->f3->get('USER')->id);

    foreach($tradeModel->getBalanceHistory() as $trade) {

      $result[] = [

        'date' => $trade['created'],

        'action' => ($trade['symbol']!='%CASH%' ? ($trade['quantity']>0 ? $this->f3->get('portfolio.balance.buy') : $this->f3->get('portfolio.balance.sell')).' '.abs($trade['quantity']).' '.$trade['symbol'].' '.$this->f3->get('portfolio.balance.actionat').' '.Helper::formatNumber($trade['price'],2).' '.$trade['currency'] : Helper::formatNumber($trade['total'],2).' '.($trade['quantity']>0 ? $this->f3->get('portfolio.balance.cash_removed') : $this->f3->get('portfolio.balance.cash_added'))),

        'balance' => $trade['balance']

      ];

    };

    print json_encode($result, JSON_NUMERIC_CHECK);

  }

  

  

  /**

   * Get balance change history for chart

   * @param $f3

   * @param $params

   */

  function apiGettrade_idHistory($f3, $params) {

    $result = [];

    // initial balance

    $result[] = [

      'date' => $this->f3->get('USER')->created,

      'action' => '',

      'trade_id' => $this->f3->get('TRADE.INITIAL_BALANCE')

    ];

    $tradeModel = new TradeModel($this->f3->get('USER')->id);

    foreach($tradeModel->getBalanceHistory() as $trade) {

      $result[] = [

        'date' => $trade['created'],

        'action' => ($trade['symbol']!='%CASH%' ? ($trade['quantity']>0 ? $this->f3->get('portfolio.balance.buy') : $this->f3->get('portfolio.balance.sell')).' '.abs($trade['quantity']).' '.$trade['symbol'].' '.$this->f3->get('portfolio.balance.actionat').' '.Helper::formatNumber($trade['price'],2).' '.$trade['currency'] : Helper::formatNumber($trade['total'],2).' '.($trade['quantity']>0 ? $this->f3->get('portfolio.balance.cash_removed') : $this->f3->get('portfolio.balance.cash_added'))),

        'trade_id' => $trade['trade_id']

      ];

    };

    print json_encode($result, JSON_NUMERIC_CHECK);

  }



  /**

   * Retrieve historical data for chart

   * @param $f3

   * @param $params

   */

  function apiGetHistoricalData($f3, $params) {

    if (($exchange = $this->f3->get('PARAMS.exchange')) && ($symbol = $this->f3->get('PARAMS.symbol'))) {

      $data_file = $symbol.'.json';

      $db = new DB\Jig('app/data/');

      if ($saved_data = $db->read($data_file)) {

        $start_date = strtotime('+1 Day', $saved_data[count($saved_data)-1]['date']/1000);

      } else {

        $start_date = strtotime(self::HISTORY_START);

      }

      $retrieved_data = $this->getHistoricalQuotes($exchange, $symbol, $start_date, time());

      $historical_data = array_merge($saved_data, $retrieved_data);

      // if new data received save all to history file

      if (!empty($retrieved_data)) {

        $db->write($data_file, $historical_data);

      }

      print json_encode($historical_data, JSON_NUMERIC_CHECK);

    }

  }



  /**

   * Get quotes for given symbols

   * @param array $symbols

   * @param array $fields

   * @param array $checkTradingEnabledSymbols

   *

   * Return associative array of quote objects

   */

  /*private function getQuotes(array $symbols, array $fields, array $checkTradingEnabledSymbols = array()) {

    $result = [];

    $now = time();



    // loop through each symbol and check if cache data can be served

    foreach ($symbols as $i => $symbol) {

      $cacheFileName = self::CACHE_FOLDER . '/' . $symbol . '_quote.json';

      if (file_exists($cacheFileName) && ($now - filemtime($cacheFileName) <= self::QUOTE_CACHE_PERIOD)) {

        Logger::log(sprintf('Reading quotes for %s from cache', $symbol));

        $result[$symbol] = json_decode(file_get_contents($cacheFileName));

        unset($symbols[$i]);

      }

    }



    // if cache data can no be served retrieve it from API and save to cache

    if (!empty($symbols)) {

      $creds = $this->getYahooCreds();

      $options = array(

        'header' => ['Cookie: '.$creds['cookie'],]

      );

      $url = sprintf(self::LIVE_QUOTES_SOURCE, rand(1, 2), implode(',', $symbols), $creds['crumb']);

      Logger::log($url);

      

      $response = \Web::instance()->request($url, $options);

      var_dump($response);

      if (isset($response['body']) && $response['body'] != '') {

        $json = json_decode($response['body']);

        if (isset($json->quoteResponse->result)) {

          foreach ($json->quoteResponse->result as $quote) {

            if (isset($quote->symbol)) {

              $result[$quote->symbol] = $quote;



              // override asset name from database

              if (strpos($quote->symbol, '^')===FALSE && strpos($quote->symbol, '=')===FALSE) {

                $asset = (new AssetModel())->get($quote->symbol);

                if (isset($asset->name)) {

                  $result[$quote->symbol]->shortName = $asset->name;

                }

              }



              file_put_contents(self::CACHE_FOLDER . '/' . $quote->symbol . '_quote.json', json_encode($quote));

            }

          }

        }

      }

    }



    foreach ($result as $symbol => $quote) {

      if (in_array($symbol, $checkTradingEnabledSymbols)) {

        $result[$symbol]->tradingEnabled = isset($result[$symbol]->regularMarketPrice) && $result[$symbol]->regularMarketPrice>0 && (new MarketModel())->isOpen($symbol);

      }

    }



    return $result;

  }*/

  

  

  private function getQuotes(array $symbols, array $fields, array $checkTradingEnabledSymbols = array()) {

    $result = [];

    $now = time();

    // loop through each symbol and check if cache data can be served



    foreach ($symbols as $i => $symbol) {

      $cacheFileName = self::CACHE_FOLDER . '/' . $symbol . '_quote.json';

      if (file_exists($cacheFileName) && ($now - filemtime($cacheFileName) <= self::QUOTE_CACHE_PERIOD)) {

        Logger::log(sprintf('Reading quotes for %s from cache', $symbol));

        $result[$symbol] = json_decode(file_get_contents($cacheFileName));

        unset($symbols[$i]);

      }

    }

    // if cache data can no be served retrieve it from API and save to cache

    if (!empty($symbols)) {

      $creds = $this->getYahooCreds();

      $options = ['header' => ['Cookie: '.$creds['cookie']]];

      $url = sprintf(self::LIVE_QUOTES_SOURCE, rand(1, 2), implode(',', $symbols), implode(',', $fields), $creds['crumb']);

      Logger::log($url);

      $response = \Web::instance()->request($url, $options);

      if (isset($response['body']) && $response['body'] != '') {

        $json = json_decode($response['body']);

        if (isset($json->quoteResponse->result)) {

          foreach ($json->quoteResponse->result as $quote) {

            if (isset($quote->symbol)) {

              $result[$quote->symbol] = $quote;



              // override asset name from database

              if (strpos($quote->symbol, '^')===FALSE && strpos($quote->symbol, '=')===FALSE) {

                $asset = (new AssetModel())->get($quote->symbol);

                if (isset($asset->name)) {

                  $result[$quote->symbol]->shortName = $asset->name;

                }

              }



              file_put_contents(self::CACHE_FOLDER . '/' . $quote->symbol . '_quote.json', json_encode($quote));

            }

          }

        }

      }

    }



    foreach ($result as $symbol => $quote) {

      if (in_array($symbol, $checkTradingEnabledSymbols)) {

        $result[$symbol]->tradingEnabled = isset($result[$symbol]->regularMarketPrice) && $result[$symbol]->regularMarketPrice>0 && (new MarketModel())->isOpen($symbol);

      }

    }



    return $result;

  }





  /**

   * Get historical data from Yahoo Finance in amCharts acceptable format

   * @param $symbol

   * @param $from

   * @param $to

   * @return array

   */

  private function getHistoricalQuotes($exchange, $symbol, $from, $to) {

    $result = [];

    $period = ($to - $from)/(60*60*24*30)<=1 ? '1M' : min(5, ceil(($to - $from)/(60*60*24*365))) . 'Y';

    list($gfExchange, $gfSymbol) = explode(':', Helper::getGoogleFinanceSymbol($exchange, $symbol));

    $url = sprintf(self::HISORICAL_QUOTES_QUERY_TXT, $gfExchange, $gfSymbol, $period);



    if ($rawMarketData = Helper::getRemoteData($url)) {

      if (preg_match_all("#^[a0-9.,]+$#m", $rawMarketData, $matches) && $strings = $matches[0]) {

        $baseDate = NULL;

        foreach ($strings as $string) {

          $values = explode(',', $string);

          if(count($values)==3) {

            if ($values[0][0]=='a') {

              $baseDate = intval(str_replace('a','',$values[0]));

              $currentDate = $baseDate;

            } else {

              $currentDate = $baseDate + $values[0]*24*60*60;

            }



            // if date is outside the required interval ocntinue to next row

            if ($currentDate < $from || $currentDate > $to) {

              continue;

            }



            $result[$currentDate] = [

              'date' => $currentDate * 1000,

              'value' => floatval($values[1]),

              'volume' => floatval($values[2])

            ];

          }

        }

      }

    }



    // important to sort the results in ascending order and then return indexed array

    ksort($result);

    return array_values($result);

  }

}