<?php

namespace Yogesh\FreeShipping\Setup;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;


/**
 * Upgrade Data script
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();


        if($context->getVersion()
            && version_compare($context->getVersion(), '1.0.1') < 0
        )
        {
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $this->_upgradeVersion101($eavSetup);
        }

        $setup->endSetup();
    }

    private function _upgradeVersion101(EavSetup $eavSetup)
    {
        $eavSetup->addAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            'min_quantity_for_free_shipping',
            [
                'type'                    => 'text',
                'backend'                 => '',
                'frontend'                => '',
                'label'                   => 'Minimum Quantity for Free Shipping',
                'input'                   => 'text',
                'class'                   => '',
                'source'                  => '',
                'global'                  => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible'                 => TRUE,
                'required'                => FALSE,
                'user_defined'            => TRUE,
                'default'                 => '',
                'searchable'              => TRUE,
                'filterable'              => TRUE,
                'comparable'              => TRUE,
                'visible_on_front'        => TRUE,
                'used_in_product_listing' => TRUE,
                'unique'                  => FALSE,
                'apply_to'                => '',
                'group'                   => 'General',
                'is_used_for_promo_rules' => FALSE,
            ]
        );
    }
}