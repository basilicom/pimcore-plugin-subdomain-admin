<?php
namespace SubdomainAdmin;

use Pimcore\Model\WebsiteSetting;

class Tool
{

    /**
     * @param \Zend_Controller_Request_Http $request
     * @return bool
     */
    public static function isRequestToAdminBackend($request)
    {
        $requestUri = $request->getRequestUri();

        return preg_match("/^\\/admin/", $request->getRequestUri()) === 1;
    }

    /**
     * @param \Zend_Controller_Request_Http $request
     * @return bool
     */
    public static function isDomainAllowedToAdminBackend($request) {
        $host = $request->getHttpHost();

        return $host === self::getAllowedDomain();
    }

    public static function getAllowedDomain()
    {
        $allowedDomain = WebsiteSetting::getByName("subdomainAdmin")->getData();
        return $allowedDomain;
    }
}