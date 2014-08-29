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
 * Product list block rewrite
 *
 * @category   Oggetto
 * @package    Oggetto_FastViewGallery
 * @subpackage Test
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_FastViewGallery_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    /**
     * Get all product views
     *
     * @param Mage_Catalog_Model_Product $product      Product
     * @param int                        $resizedWidth Resized width
     * @param int                        $originWidth  Origin width
     *
     * @return array
     */
    public function getProductViews($product, $resizedWidth, $originWidth)
    {
        $urlArray = array();

        foreach ($product->getMediaGalleryImages() as $image) {
            $resizedImage = (string)Mage::helper('catalog/image')
                ->init($product, 'gallery_thumbnail', $image->getFile())->setQuality(100)->resize($resizedWidth);
            $originImage = (string)Mage::helper('catalog/image')
                ->init($product, 'small_image', $image->getFile())->setQuality(100)->resize($originWidth);

            $urlArray[] = array(
                'resize' => $resizedImage,
                'origin' => $originImage
            );
        }

        return $urlArray;
    }
}