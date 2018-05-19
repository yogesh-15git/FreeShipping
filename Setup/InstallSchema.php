<?php

namespace Yogesh\FreeShipping\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use PHPUnit\Framework\Constraint\IsFalse;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install Schema Script
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /* Free Shipping Calculation Table */

        if($setup->getConnection()->isTableExists($setup->getTable('yogesh_freeshipping')) == TRUE)
        {
            $setup->getConnection()->dropTable($setup->getTable('yogesh_freeshipping'));
        }
        $freeShippingTable = $setup->getConnection()->newTable(
            $setup->getTable('yogesh_freeshipping')
        )->addColumn(
            'city_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['identity' => TRUE, 'unsigned' => TRUE, 'nullable' => FALSE, 'primary' => TRUE],
            'City Id'
        )->addColumn(
            'city_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            55,
            ['nullable' => FALSE],
            'City Name'
        )->addColumn(
            'city_minimum_amount',
            \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => FALSE, 'default' => '0'],
            'City Minimum Amount'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => FALSE, 'default' => 1],
            'Is Active'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            55,
            ['unsigned' => TRUE, 'nullable' => FALSE],
            'Store View ID'
        )->setComment(
            'Free Shipping Calculation Table'
        );

        $setup->getConnection()->createTable($freeShippingTable);

    }
}