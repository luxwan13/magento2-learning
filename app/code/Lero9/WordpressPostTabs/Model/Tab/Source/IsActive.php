<?php
namespace Lero9\WordpressPostTabs\Model\Tab\Source;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Lero9\WordpressPostTabs\Model\Tab
     */
    protected $tab;

    /**
     * Constructor
     *
     * @param \Lero9\WordpressPostTabs\Model\Tab $tab
     */
    public function __construct(\Lero9\WordpressPostTabs\Model\Tab $tab)
    {
        $this->tab = $tab;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->tab->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}