<?php
namespace SubdomainAdmin;

use Pimcore\API\Plugin as PluginLib;
use Pimcore\Config;
use Pimcore\Model\WebsiteSetting;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface {

    const WEBSITE_SETTING_NAME = "subdomainAdmin";

    public function init() {

        // Disable plugin if the allowed domain is not yet set
        $settingDomain = WebsiteSetting::getByName("subdomainAdmin");
        if (!is_object($settingDomain) || $settingDomain->getData() == "") {
            return;
        }



        // Create temporary request object - not available yet in front controller
        $currentUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $request = new \Zend_Controller_Request_Http($currentUrl);


        // Disable main domain setting to allow admin access on another domain
        $conf = Config::getSystemConfig();
        $mainDomain = $conf->general->domain;

        if (Tool::isRequestToAdminBackend($request) && Tool::isDomainAllowedToAdminBackend($request)) {
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
        $dataWebsiteSetting = [
            "name" => self::WEBSITE_SETTING_NAME,
            "type" => "text",
            "data" => ""
        ];
        $websiteSetting = new WebsiteSetting();
        $websiteSetting->setValues($dataWebsiteSetting);
        $websiteSetting->save();

        if (self::isInstalled()) {
            return "Plugin successfully installed.";
        } else {
            return "Plugin was not successfully installed.";
        }
	}
	
	public static function uninstall (){
        return "To uninstall just manually remove related website settings.";
	}

	public static function isInstalled () {
        return WebsiteSetting::getByName(self::WEBSITE_SETTING_NAME) !== null;
	}

    public static function needsReloadAfterInstall()
    {
        return true;
    }
}
