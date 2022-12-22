<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT

   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Products;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Apps\Catalog\Products\Products as ProductsApp;

  class Save implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected mixed $app;
    protected $id;
    protected mixed $db;
    protected $composer;

    public function __construct()
    {
      if (!Registry::exists('Products')) {
        Registry::set('Products', new ProductsApp());
      }

      $this->template = Registry::get('TemplateAdmin');
      $this->app = Registry::get('Products');
      $this->db = Registry::get('Db');
      $this->composer = Registry::get('Composer');
      $this->apiKey = CONFIGURATION_TINY_API_KEY;
    }

    private function getImageExtansion($filePath)
    {
      $fileParts = pathinfo($filePath);

      if (!isset($fileParts['filename'])) {
        $fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));
        $extension = $fileParts['extension'];
      } else {
        $extension = $fileParts['extension'];
      }

      return $extension;
    }

    private function getProductsId()
    {
      if (isset($this->id)) {
        $products_id = $this->id;
      } else {
//insert last id of product table
        $Qproducts = $this->app->db->prepare('select products_id
                                              from :table_products
                                              order by products_id desc
                                              limit 1
                                            ');
        $Qproducts->execute();

        $products_id = $Qproducts->valueInt('products_id');
      }

      return $products_id;
    }

    /**
     * @throws \Tinify\AccountException
     */
    private function ProductsImage()
    {
      $Qproducts = $this->db->prepare('select products_image,
                                              products_image_zoom,
                                              products_image_medium
                                      from :table_products
                                      where products_id = :products_id
                                     ');

      $Qproducts->bindInt(':products_id', $this->getProductsId());
      $Qproducts->execute();

      if (!empty($Qproducts->value('products_image')) ||!\is_null($Qproducts->value('products_image'))) {
          \Tinify\setKey($this->apiKey);
          \Tinify\validate();

          // big image
        $original_big_image = $this->template->getDirectoryPathTemplateShopImages() . $Qproducts->value('products_image_zoom');
        if (file_exists($original_big_image)) {
          if ($this->getImageExtansion($original_big_image) == 'jpg' || $this->getImageExtansion($original_big_image) == 'png' || $this->getImageExtansion($original_big_image) == 'jpeg') {
            $sourceData = file_get_contents($original_big_image);
            $resultData = \Tinify\fromBuffer($sourceData)->toBuffer();
            file_put_contents($original_big_image, $resultData);
          }
        }
        // medium image
        $original_medium_image = $this->template->getDirectoryPathTemplateShopImages() . $Qproducts->value('products_image_medium');
        if (file_exists($original_medium_image)) {
          if ($this->getImageExtansion($original_medium_image) == 'jpg' || $this->getImageExtansion($original_medium_image) == 'png' || $this->getImageExtansion($original_medium_image) == 'jpeg') {
            $sourceData = file_get_contents($original_medium_image);
            $resultData = \Tinify\fromBuffer($sourceData)->toBuffer();
            file_put_contents($original_medium_image, $resultData);
          }
        }

        // small image
        $original_small_image = $this->template->getDirectoryPathTemplateShopImages() . $Qproducts->value('products_image');

        if (file_exists($original_small_image)) {
          if ($this->getImageExtansion($original_small_image) == 'jpg' || $this->getImageExtansion($original_small_image) == 'png' || $this->getImageExtansion($original_small_image) == 'jpeg') {
            $sourceData = file_get_contents($original_small_image);
            $resultData = \Tinify\fromBuffer($sourceData)->toBuffer();

            file_put_contents($original_small_image, $resultData);
          }
        }
      }
    }

    /**
     * @throws \Tinify\AccountException
     */
    private function galleryProductsImage()
    {
      if (isset($_POST['tinyfy_gallery_image'])) {
        \Tinify\setKey($this->apiKey);
        \Tinify\validate();

        $QproductImage = $this->db->prepare('select image
                                              from :table_products_images
                                              where products_id = :products_id
                                             ');

        $QproductImage->bindInt(':products_id', $this->getProductsId());
        $QproductImage->execute();

        while ($QproductImage->fetch()) {
          $original_gallery_image = $this->template->getDirectoryPathTemplateShopImages() . $QproductImage->value('products_image');
          if (file_exists($original_gallery_image)) {
            if ($this->getImageExtansion($original_gallery_image) == 'jpg' || $this->getImageExtansion($original_gallery_image) == 'png' || $this->getImageExtansion($original_gallery_image) == 'jpeg') {
              $sourceData = file_get_contents($original_gallery_image);
              $resultData = \Tinify\fromBuffer($sourceData)->toBuffer();
              file_put_contents($original_gallery_image, $resultData);
            }
          }
        }
      }
    }

    public function execute()
    {
      if (!\defined('CLICSHOPPING_APP_CATALOG_PRODUCTS_PD_STATUS') || CLICSHOPPING_APP_CATALOG_PRODUCTS_PD_STATUS == 'False') {
        return false;
      }

      if (!empty(CONFIGURATION_TINY_API_KEY)) {
        if (isset($_GET['pID'])) {
          $this->id = HTML::sanitize($_GET['pID']);
        }

        if ($this->composer->checkLibrayInstalled() === false) {
          $this->composer->install('tinify/tinify');
        }

        $this->ProductsImage();

        $this->galleryProductsImage();
      }
    }
  }