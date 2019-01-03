<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

require_once("curl_mock.php");
require_once("vendor/autoload.php");

class TestCase extends \PHPUnit_Framework_TestCase {
    function setUp() {
        Tinify\CurlMock::reset();
        Tinify\setKey(NULL);
        TInify\setProxy(NULL);
    }

    function tearDown() {
        Tinify\CurlMock::reset();
    }
}
