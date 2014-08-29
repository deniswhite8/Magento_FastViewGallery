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
class Oggetto_FastViewGallery_Model_Resource_Product_Flat_Indexer extends Mage_Catalog_Model_Resource_Product_Flat_Indexer
{
    /**
     * Update attribute flat data
     *
     * @param Mage_Eav_Model_Entity_Attribute $attribute
     * @param int $storeId
     * @param int|array $productIds update only product(s)
     *
     * @return Mage_Catalog_Model_Resource_Product_Flat_Indexer
     */
    public function updateAttribute($attribute, $storeId, $productIds = null)
    {
        if ($attribute->getAttributeCode() != 'media_gallery') {
            return parent::updateAttribute($attribute, $storeId, $productIds);
        }

        $adapter       = $this->_getWriteAdapter();
        $flatTableName = $this->getFlatTableName($storeId);
        $defaultStoreId = Mage_Core_Model_App::ADMIN_STORE_ID;
        $mediaGalleryTable = Mage::getSingleton('core/resource')->
            getTableName('catalog/product_attribute_media_gallery');
        $mediaGalleryValueTable = Mage::getSingleton('core/resource')->
            getTableName('catalog/product_attribute_media_gallery_value');

        $subSelect = $adapter->select()->from(array('mediaGallery' => $mediaGalleryTable),
            new Zend_Db_Expr("GROUP_CONCAT(CONCAT('\"', mediaGallery.value, '\",', " .
                "IFNULL(mediaGalleryValue.label, 'null'), ',', IFNULL(mediaGalleryValue.position, 'null'), ',', " .
                "IFNULL(mediaGalleryValue.disabled, 'null')))"))
            ->join(array('mediaGalleryValue' => $mediaGalleryValueTable),
                'mediaGalleryValue.value_id = mediaGallery.value_id', null)
            ->where("mediaGallery.entity_id = e.entity_id AND mediaGallery.attribute_id = {$attribute->getId()} AND " .
                "(mediaGalleryValue.store_id = {$storeId} OR mediaGalleryValue.store_id = {$defaultStoreId})");

        $sql = new Zend_Db_Expr("UPDATE `{$flatTableName}` AS `e` SET `e`.`{$attribute->getAttributeCode()}` = " .
            "({$subSelect})");
        $adapter->query($sql);

        return $this;
    }
}