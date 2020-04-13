<?php
namespace Learning\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema.
 */
class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'learning_blog_blog';

    /**
     * Create learning_blog_blog table.
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        if($setup->tableExists(self::TABLE_NAME)) {
            $setup->endSetup();

            return;
        }

        $this->createTable($setup);
        $this->addIndices($setup);
        $setup->endSetup();
    }

    /**
     * Create table in DB.
     *
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function createTable(SchemaSetupInterface $setup): void
    {
        $connection = $setup->getConnection();
        $table = $connection->newTable($setup->getTable(self::TABLE_NAME))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Index ID'
            )
            ->addColumn(
                'subject',
                Table::TYPE_TEXT,
                255,
                [ 'nullable' => false ],
                'Subject name'
            )
            ->addColumn(
                'content',
                Table::TYPE_TEXT,
                '2M',
                [ 'nullable' => false ],
                'Index\'s content'
            )
            ->addColumn(
                'image_url',
                Table::TYPE_TEXT,
                255,
                [],
                'Url of the blog\'s image'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT ],
                'Created at'
            )->setComment('Index table');
        $connection->createTable($table);
    }

    /**
     * Add indices.
     * @param SchemaSetupInterface $setup
     */
    private function addIndices(SchemaSetupInterface $setup): void
    {
        $setup->getConnection()->addIndex(
            $setup->getTable(self::TABLE_NAME),
            $setup->getIdxName(
                $setup->getTable(self::TABLE_NAME),
                [ 'subject', 'content' ],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            [ 'subject', 'content' ],
            AdapterInterface::INDEX_TYPE_FULLTEXT
        );
    }
}
