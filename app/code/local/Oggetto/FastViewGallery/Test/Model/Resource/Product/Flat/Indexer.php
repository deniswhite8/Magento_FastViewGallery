<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto FastViewGallery module to newer versions in the future.
 * If you wish to customize the Oggetto FastViewGallery module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_FastViewGallery
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Product EAV indexer rewrite
 *
 * @category   Oggetto
 * @package    Oggetto_FastViewGallery
 * @subpackage Model
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_FastViewGallery_Test_Model_Resource_Product_Flat_Indexer extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Get raw media gallery value from flat product table
     *
     * @param int $product_id Product Id
     * @param int $storeId    Store Id
     *
     * @return string
     */
    protected function _getRawMediaGallery($product_id, $storeId)
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()->reset()->from("catalog_product_flat_{$storeId}",
            array('entity_id', 'media_gallery'))->where('entity_id = ?', $product_id);
        $results = $readConnection->fetchAll((string)$select);

        return $results[0]['media_gallery'];
    }

    /**
     * Test media_gallery indexer
     *
     * @loadFixture
     *
     * @return void
     */
    public function testMediaGalleryIndexer()
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'media_gallery');
        Mage::getResourceSingleton('catalog/product_flat_indexer')->updateAttribute($attribute, 1);

        $this->assertEquals('"q.jpg",1,2,3,"w.jpg",4,5,6', $this->_getRawMediaGallery(1, 1));
        $this->assertEquals('"e.jpg",null,null,0', $this->_getRawMediaGallery(2, 1));
    }
}