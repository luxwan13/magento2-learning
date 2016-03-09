<?php
namespace Lero9\WordpressPostTabs\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'catalog_product_entity'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('lero9_wordpress_post_tab'))
            ->addColumn(
                'tab_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Tab ID'
            )
            ->addColumn('wp_url', Table::TYPE_TEXT, 255, ['nullable' => false], 'Wordpress site url')
            ->addColumn('label', Table::TYPE_TEXT, 255, ['nullable' => false], 'Tab label')
            ->addColumn('wp_cat_id', Table::TYPE_SMALLINT, null, [], 'Wordpress post category ID')
            ->addColumn('num_posts', Table::TYPE_SMALLINT, null, [], 'Number of posts to show on the tab')
            ->addColumn('is_active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Is tab active?')
            ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation time')
            ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update time')
            ->addIndex($installer->getIdxName('lero9_wordpress_post_tab', ['label']), ['label'])
            ->setComment('Lero9 Wordpress post tabs');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}