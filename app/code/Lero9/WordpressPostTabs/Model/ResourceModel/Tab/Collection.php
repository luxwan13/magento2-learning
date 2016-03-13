<?php
namespace Lero9\WordpressPostTabs\Model\ResourceModel\Tab;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'tab_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lero9\WordpressPostTabs\Model\Tab', 'Lero9\WordpressPostTabs\Model\ResourceModel\Tab');
    }

}