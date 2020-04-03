<?php
namespace Learning\Blog\Setup\Patch\Data;

use Learning\Blog\Model\ResourceModel\Blog as BlogResourceModel;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class PopulateBlogRecords implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * PopulateBlogRecords constructor.
     *
     * @param ModuleDataSetupInterface $setup
     */
    public function __construct(ModuleDataSetupInterface $setup)
    {
        $this->moduleDataSetup = $setup;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Insert data.
     */
    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();

        $table = $setup->getTable(BlogResourceModel::MAIN_TABLE);
        $setup->getConnection()->insert($table, [
           'id' => 1,
           'subject' => 'Lorem',
           'content' => 'Lorem ipsum',
        ]);

        $setup->endSetup();
    }
}
