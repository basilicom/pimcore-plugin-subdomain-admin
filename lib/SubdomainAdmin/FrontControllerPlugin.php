<?php
namespace SubdomainAdmin;

use Pimcore\Config;
use Pimcore\Model\Document;
use Pimcore\Model\Document\Page;
use Pimcore\Model\Site;
use Pimcore\Model\User;
use Pimcore\Tool\Authentication;
use Zend_Controller_Request_Abstract;

class FrontControllerPlugin extends \Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Http $request)
    {
        parent::preDispatch($request);

        $isRequestToAdminBackend = Tool::isRequestToAdminBackend($request);
        if ($isRequestToAdminBackend) {

            if (Tool::isDomainAllowedToAdminBackend($request)) {
                //$config = Config::getSystemConfig();
                //xdebug_break();
                //exit;
            } else {
                $this->handleErrorPage();
            }
        }
    }

    private function handleErrorPage() {
        $config = Config::getSystemConfig();

        /** @var $response \Zend_Controller_Response_Http */
        $response = $this->getResponse();
        $response->setHttpResponseCode(404);
        header("HTTP/1.0 404 Not Found");


        $errorDoc = $this->getErrorDocument();

        $request = $this->getRequest();
        $request->setParam("document", $errorDoc);

        $request->setModuleName("website");
        $request->setActionName($errorDoc->action ?: $config->documents->default_action);
        $request->setControllerName($errorDoc->controller ?: $config->documents->default_controller);


        // Setup Pimcore params to fake router exception
        $routerException =  new \Zend_Controller_Router_Exception("No route, document, custom route or redirect is matching the request: " . $_SERVER["REQUEST_URI"] . " | \n", 404);
        $errorHandlerMock = new \ArrayObject(array(), \ArrayObject::ARRAY_AS_PROPS);
        $errorHandlerMock->exception = $routerException;

        \Zend_Registry::set("pimcore_error_document", $errorDoc);
        $request->setParam("error_handler", $errorHandlerMock);
    }

    private function getErrorDocument() {
        $config = Config::getSystemConfig();
        $errorDocPath = $config->documents->error_pages->default;
        if(Site::isSiteRequest()) {
            $site = Site::getCurrentSite();
            $errorDocPath = $site->getErrorDocument();
        }

        return Document::getByPath($errorDocPath);
    }

}
