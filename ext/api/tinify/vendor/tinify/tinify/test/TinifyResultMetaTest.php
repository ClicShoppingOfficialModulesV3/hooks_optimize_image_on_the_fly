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

use Tinify\CurlMock;

class TinifyResultMetaTest extends TestCase {
    public function testWithMetadataWidthShouldReturnImageWidth() {
        $result = new Tinify\ResultMeta(array("image-width" => "100"));
        $this->assertSame(100, $result->width());
    }

    public function testWithMetadataHeightShouldReturnImageHeight() {
        $result = new Tinify\ResultMeta(array("image-height" => "60"));
        $this->assertSame(60, $result->height());
    }

    public function testWithMetadataLocationShouldReturnImageLocation() {
        $result = new Tinify\ResultMeta(array("location" => "https://example.com/image.png"));
        $this->assertSame("https://example.com/image.png", $result->location());
    }
}
