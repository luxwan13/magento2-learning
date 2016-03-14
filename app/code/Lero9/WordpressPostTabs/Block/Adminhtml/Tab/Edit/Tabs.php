<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lero9\WordpressPostTabs\Block\Adminhtml\Tab\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('tab_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Tab Information'));
    }
}
