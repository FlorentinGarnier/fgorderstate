<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class fgorderstate extends Module
{
    public function __construct()
    {
        $this->name = 'fgorderstate';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Florentin Garnier - Digital404';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.5',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('FG Order State Switcher Command');
        $this->description = $this->l('switch order state by command');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('FG_OS_SWITCHER')) {
            $this->warning = $this->l('Module not installed');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install() ||
            !Configuration::updateValue('FG_OS_SWITCHER', true)
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('FG_OS_SWITCHER')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        $link = Context::getContext()->link->getModuleLink('fgorderstate', 'webhook',['order_id' => 5, 'token' => 'abracadabra', 'method' => 'task_status_change']);
        return '<a href="' . $link . '"> ' . $link . '</a>';
    }
}
