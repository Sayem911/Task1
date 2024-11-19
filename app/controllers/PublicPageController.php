<?php

class PublicPageController extends Controller
{
    protected $templates_directory = 'public';

    function beforeroute($f3, $params) { 
        parent::beforeroute($f3, $params); 
        parent::checkSubscription(); 
    } 

    function renderIndexPage($f3, $params)
    {
        $asset = new AssetModel();
        $symbol = $this->f3->get('TRADE.DEFAULT_SYMBOL');
        $f3->set('vars.symbol', $symbol);
        $f3->set('vars.asset', $asset->getInfo($symbol));
        $f3->set('vars.yahoo_rss_lang_domain', Helper::getYahooRssLangDomain('en'));
        $this->setPageTitle('title.index');
        $this->renderPage();
    }
}