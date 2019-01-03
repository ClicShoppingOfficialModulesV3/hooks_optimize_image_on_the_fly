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

namespace Tinify;

class Result extends ResultMeta {
    protected $data;

    public function __construct($meta, $data) {
        $this->meta = $meta;
        $this->data = $data;
    }

    public function data() {
        return $this->data;
    }

    public function toBuffer() {
        return $this->data;
    }

    public function toFile($path) {
        return file_put_contents($path, $this->toBuffer());
    }

    public function size() {
        return intval($this->meta["content-length"]);
    }

    public function mediaType() {
        return $this->meta["content-type"];
    }

    public function contentType() {
        return $this->mediaType();
    }
}
