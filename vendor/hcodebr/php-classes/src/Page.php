<?php

namespace Hcode;

use Rain\Tpl;

class Page
{

    private $tpl;
    private $options;
    private $defaults = [
        "header" => true,
        "footer" => true,
        "data" => []
    ];

    public function __construct($opts = array(), $tpl_dir = "/views/")
    {
        // $this->defaults["data"]["session"] = $_SESSION;

        $this->options = array_merge($this->defaults, $opts);
        // config
        $config = array(
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT'] . $tpl_dir,
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure($config);

        $this->tpl = new Tpl;

        $this->setData($this->options['data']);

        if ($this->options["header"]) {
            $this->tpl->draw("header");
        }
    }

    public function setData($data = array())
    {
        foreach ($this->options["data"] as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHtml = false)
    {
        $this->setData($data);
        return $this->tpl->draw($name, $returnHtml);
    }


    public function __destruct()
    {
        if ($this->options["footer"]) {
            $this->tpl->draw("footer");
        }
    }
}