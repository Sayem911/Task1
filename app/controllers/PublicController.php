<?php

class PublicController
{
    protected $templates_directory = NULL;
    protected $page_template = 'html.php';
    protected $f3;

    function beforeroute($f3, $params)
    {
        $this->f3->set('LANGUAGE', 'en');
    }

    function afterroute($f3, $params)
    {
    }

    protected function setMessage($type, $text, $substitutes = NULL)
    {
        $this->f3->set('SESSION.message', ['type' => $type, 'text' => $this->f3->get($text, $substitutes)]);
    }

    protected function setPageTitle($titleString)
    {
        $this->f3->set('vars.title', $this->f3->get($titleString));
    }

    protected function renderPage()
    {
        echo Template::instance()->render($this->templates_directory . '/' . $this->page_template);
        $this->f3->set('SESSION.message', '');
    }

    protected function setTemplate($template_name, $template_file)
    {
        $this->f3->set($template_name, $this->templates_directory . '/' . $template_file);
    }

    protected function getLanguages()
    {
        $result = [];
        foreach (glob($this->f3->get('LOCALES') . '*.php') as $file) {
            if (preg_match('#([a-z]{2})\.php$#', $file, $matches)) $result[] = $matches[1];
        }
        return $result;
    }

    function __construct($f3, $params)
    {
        $this->f3 = $f3;
        if ($this->templates_directory) {
            foreach (glob($f3->get('UI') . $this->templates_directory . '/*.php') as $template_path) {
                if (preg_match('#/([a-z\.0-9-]+)\.php#i', $template_path, $matches) && isset($matches[1])) {
                    $f3->set('tpl.' . $matches[1], $this->templates_directory . '/' . $matches[1] . '.php');
                }
            }
        }
    }
}