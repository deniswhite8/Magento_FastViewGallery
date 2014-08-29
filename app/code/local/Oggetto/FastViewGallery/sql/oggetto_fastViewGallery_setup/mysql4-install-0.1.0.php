<?php
/** @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$entityTypeId = $installer->getEntityTypeId('catalog_product');

$attributeId = $installer->getAttribute($entityTypeId, 'media_gallery', 'attribute_id');
$installer->updateAttribute($entityTypeId, $attributeId, array(
    'backend_type' => 'text',
    'used_in_product_listing' => 1
));