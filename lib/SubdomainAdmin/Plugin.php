<?php
namespace SubdomainAdmin;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Config;
use Pimcore\Model\WebsiteSetting;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface {

    public function init() {

        // Don't use plugin if there is no domain set
        $settingDomain = WebsiteSetting::getByName("subdomainAdmin");
        if (!is_object($settingDomain) || $settingDomain == "") {
            return;
        }


        // Disable main domain for to allow admin access on another domain
        $conf = Config::getSystemConfig();
        $mainDomain = $conf->general->domain;

        $currentUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $request = new \Zend_Controller_Request_Http($currentUrl);

        if (Tool::isRequestToAdminBackend($request)
            && Tool::isDomainAllowedToAdminBackend($request)
        ) {
            $confArr = $conf->toArray();
            $mainDomain = $confArr['general']['domain'];
            $confArr['general']['domain'] = "";
            Config::setSystemConfig(new \Zend_Config($confArr));
        }


        // Register plugin
        \Pimcore::getEventManager()->attach("system.startup", function ($event) use (&$mainDomain) {
            $front = \Zend_Controller_Front::getInstance();
            $frontControllerPlugin = new FrontControllerPlugin();
            $front->registerPlugin($frontControllerPlugin);

            // Restore main domain
            $conf = Config::getSystemConfig();
            $confArr = $conf->toArray();
            $confArr['general']['domain'] = $mainDomain;
            Config::setSystemConfig(new \Zend_Config($confArr));
        });
    }

    public static function install (){
        // TODO create website setting here
        return true;
	}
	
	public static function uninstall (){
        // TODO remove website setting here
        return true;
	}

	public static function isInstalled () {
        // TODO check here if website setting exists
        return true;
	}

    public static function needsReloadAfterInstall()
    {
        return false; // backend only functionality!
    }
}
