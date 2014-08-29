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
 * @subpackage Test
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_FastViewGallery_Test_Model_Resource_Product_Collection extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * After load
     *
     * @return Oggetto_FastViewGallery_Model_Resource_Product_Collection
     */
    public function testAfterLoad()
    {
        $productCollection = Mage::getResourceModel('catalog/product_collection');
        $productCollection
            ->addItem(Mage::getModel('catalog/product')->setMediaGallery('"q.jpg",0,1,2,"w.jpg",4,5,6'))
            ->addItem(Mage::getModel('catalog/product')->setMediaGallery('"e.jpg",null,null,null'));

        $this->assertEquals(array('images' => array(
            array(
                'file' => "q.jpg",
                'label' => 0,
                'position' => 1,
                'disabled' => 2
            ),
            array(
                'file' => "w.jpg",
                'label' => 4,
                'position' => 5,
                'disabled' => 6
            )
        )), $productCollection->getFirstItem()->getMediaGallery());

        $this->assertEquals(array('images' => array(
            array(
                'file' => "e.jpg",
                'label' => null,
                'position' => null,
                'disabled' => null
            )
        )), $productCollection->getItems()[1]->getMediaGallery());
    }
}