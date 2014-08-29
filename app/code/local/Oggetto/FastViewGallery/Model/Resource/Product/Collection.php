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
 * Product resource collection model rewrite
 *
 * @category   Oggetto
 * @package    Oggetto_FastViewGallery
 * @subpackage Model
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_FastViewGallery_Model_Resource_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{
    /**
     * After load
     *
     * @return Oggetto_FastViewGallery_Model_Resource_Product_Collection
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        foreach ($this as $product) {
            $gallery = $product->getMediaGallery();
            if (isset($gallery)) {
                $rawData = Mage::helper('core')->jsonDecode('[' . $gallery . ']');
                $images = array();
                for ($i = 0; $i < count($rawData); $i += 4) {
                    $image = array(
                        'file' => $rawData[$i],
                        'label' => $rawData[$i + 1],
                        'position' => $rawData[$i + 2],
                        'disabled' => $rawData[$i + 3]
                    );
                    $images[] = $image;
                }
                $product->setMediaGallery(array('images' => $images));
            }
        }

        return $this;
    }
}