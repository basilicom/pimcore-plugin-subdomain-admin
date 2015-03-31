<?php
class SubdomainAdmin_AdminTest extends PHPUnit_Framework_TestCase {


    protected function setUp()
    {
        parent::setUp();
    }

    public function testIsAdminRequest()
    {
        $request = new Zend_Controller_Request_Http("http://www.domain.com/admin");
        $this->assertTrue(SubdomainAdmin\Tool::isRequestToAdminBackend($request));

        $request = new Zend_Controller_Request_Http("http://www.domain.com/admin/");
        $this->assertTrue(SubdomainAdmin\Tool::isRequestToAdminBackend($request));

        $request = new Zend_Controller_Request_Http("http://www.domain.com/admin/test");
        $this->assertTrue(SubdomainAdmin\Tool::isRequestToAdminBackend($request));

        $request = new Zend_Controller_Request_Http("http://www.domain.com/");
        $this->assertFalse(SubdomainAdmin\Tool::isRequestToAdminBackend($request));

        $request = new Zend_Controller_Request_Http("http://www.domain.com/test/admin/");
        $this->assertFalse(SubdomainAdmin\Tool::isRequestToAdminBackend($request));

        $request = new Zend_Controller_Request_Http("http://www.domain.com/test/admin/test");
        $this->assertFalse(SubdomainAdmin\Tool::isRequestToAdminBackend($request));
    }

    public function testGetAllowedDomain()
    {
        $this->assertNotEmpty(SubdomainAdmin\Tool::getAllowedDomain());
    }

    public function testIsDomainAllowedToAdminBackend()
    {
        $_SERVER['HTTP_HOST'] = "www.domain.com";
        $request = new Zend_Controller_Request_Http("http://www.domain.com/test/admin/test");
        $this->assertFalse(SubdomainAdmin\Tool::isDomainAllowedToAdminBackend($request));

        $_SERVER['HTTP_HOST'] = \SubdomainAdmin\Tool::getAllowedDomain();
        $request = new Zend_Controller_Request_Http(
            "http://". \SubdomainAdmin\Tool::getAllowedDomain() . "/test/admin/test"
        );
        $this->assertTrue(\SubdomainAdmin\Tool::isDomainAllowedToAdminBackend($request));
    }
}