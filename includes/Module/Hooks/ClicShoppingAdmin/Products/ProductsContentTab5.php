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

  namespace ClicShopping\OM\Module\Hooks\ClicShoppingAdmin\Products;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class ProductsContentTab5 {
    protected $app;

    public function __construct()   {

      if (CLICSHOPPING::getSite() != 'ClicShoppingAdmin') {
        CLICSHOPPING::redirect();
      }

      if (!defined('CONFIGURATION_TINY_API_KEY')){
        $this->InstallAPIKey();
      }
    }

    /**
     * Install Apy Key
     */
    private function InstallAPIKey() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'API Key from tinypng.com. Works only with jg and png files',
          'configuration_key' => 'CONFIGURATION_TINY_API_KEY',
          'configuration_value' => '',
          'configuration_description' => 'The website https://tinypng.com can propose you a key Allow you to optimize your image',
          'configuration_group_id' => '4',
          'sort_order' => '40',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function display() {

      if (!defined('CLICSHOPPING_APP_CATALOG_PRODUCTS_PD_STATUS') || CLICSHOPPING_APP_CATALOG_PRODUCTS_PD_STATUS == 'False') {
        return false;
      }
      if(!empty(CONFIGURATION_TINY_API_KEY)) {
        $output = '';

        $content = '<!-- Image TiniFy Hook start -->';
        $content .= '<div class="separator"></div>';
        $content .= '<div class="col-md-12">';
        $content .= 'Tynify Products ';
        $content .= HTML::checkboxField('tinyfy_products_image', null);
        $content .= '</div>';
        $content .= '<div class="col-md-12">';
        $content .= 'Tynify Products Gallery ';
        $content .= HTML::checkboxField('tinyfy_gallery_image', null);
        $content .= '</div>';
        $content .= '<!-- Image TiniFy Hook  end -->';

        $output = <<<EOD
<!-- ######################## -->
<!--  Start  TiniFy Hook     -->
<!-- ######################## -->
<script>
$('#tab5ContentRow1').append(
    '{$content}'
);
</script>
<!-- ######################## -->
<!--  End  TiniFy Hook      -->
<!-- ######################## -->

EOD;
          return $output;
      }
    }
  }
