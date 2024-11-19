<?php

class PublicApiController extends PublicController {

  const HISTORY_START = '2011-01-01';
  //const LIVE_QUOTES_SOURCE = 'https://query%d.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=%s&fields=shortName,fullExchangeName,regularMarketPrice,regularMarketChange,regularMarketChangePercent,regularMarketDayLow,regularMarketDayHigh,regularMarketVolume,fiftyTwoWeekLow,fiftyTwoWeekHigh,fiftyTwoWeekLowChange,fiftyTwoWeekLowChangePercent,fiftyTwoWeekHighChange,fiftyTwoWeekHighChangePercent,regularMarketOpen,regularMarketPreviousClose,averageDailyVolume3Month,bid,ask,sharesOutstanding,marketCap,bookValue,ebitda,exDividendDate,dividendRate,dividendYield,totalCash,fiftyDayAverage,twoHundredDayAverage,beta,trailingPE,pegRatio&crumb=%s';
  const LIVE_QUOTES_SOURCE = 'https://query%d.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=%s&fields=%s&crumb=%s';
  //const LIVE_QUOTES_SOURCE = 'https://query%d.finance.yahoo.com/v7/finance/quote?corsDomain=finance.yahoo.com&symbols=%s&crumb=%s';
  const YQL_ENDPOINT = '/api/public/quotes?symbols=%s&env=store://datatables.org/alltableswithkeys&format=json';
  const HISORICAL_QUOTES_QUERY_TXT = 'https://www.google.com/finance/getprices?i=86400&f=d,c,v&df=cpct&x=%s&q=%s&p=%s';
  const CACHE_FOLDER = 'app/data';
  const QUOTE_CACHE_PERIOD = 60;
  private $latest_quote = array('regularMarketPrice','currency');

  protected $templates_directory = 'auth';

  function beforeroute($f3, $params) {
    // call Controller::beforeroute()
    parent::beforeroute($f3, $params);
  }

  /**
   * Symbol search autocomplete
   * @param $f3
   * @param $params
   */
  function apiSearchAsset($f3, $params) {
    $searchString = $this->f3->get('PARAMS.search');
    print json_encode(['results' => (new ApiModel())->searchAssetOnly($searchString)], JSON_NUMERIC_CHECK);
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
      header('Content-Type: application/json; charset=utf-8');
      print json_encode($historical_data, JSON_NUMERIC_CHECK);
    }
  }
  
  function getYahooCreds(){
        $ch = curl_init('https://fc.yahoo.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
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
        //$ch = curl_init("https://query1.finance.yahoo.com/v7/finance/quote?lang=en-US&region=US&corsDomain=finance.yahoo.com&symbols=".$f3->get('GET.symbols')."&crumb=".$cred['crumb']);
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
   * Get quotes for given symbols
   * @param array $symbols
   * @param array $fields
   * @param array $checkTradingEnabledSymbols
   *
   * Return associative array of quote objects
   */
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