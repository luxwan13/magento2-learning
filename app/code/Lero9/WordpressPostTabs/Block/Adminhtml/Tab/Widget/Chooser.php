<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lero9\WordpressPostTabs\Block\Adminhtml\Tab\Widget;


class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Lero9\WordpressPostTabs\Model\Tab
     */
    protected $_wordpressPostTab;

    /**
     * @var \Lero9\WordpressPostTabs\Model\TabFactory
     */
    protected $_tabFactory;

    /**
     * @var \Lero9\WordpressPostTabs\Model\ResourceModel\Tab\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;

    /**
     * @var string
     */
    protected $_template = 'Lero9_WordpressPostTabs::widget/grid/extended.phtml';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Lero9\WordpressPostTabs\Model\Tab $wordpressPostTab
     * @param \Lero9\WordpressPostTabs\Model\TabFactory $tabFactory
     * @param \Lero9\WordpressPostTabs\Model\ResourceModel\Tab\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Lero9\WordpressPostTabs\Model\Tab $wordpressPostTab,
        \Lero9\WordpressPostTabs\Model\TabFactory $tabFactory,
        \Lero9\WordpressPostTabs\Model\ResourceModel\Tab\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        array $data = []
    ) {
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_wordpressPostTab = $wordpressPostTab;
        $this->_tabFactory = $tabFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Block construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        //$this->setDefaultSort('name');
        $this->setUseAjax(true);
        $this->setDefaultFilter(['chooser_is_active' => '1']);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('wordpress/tab_widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            'Magento\Widget\Block\Adminhtml\Widget\Chooser'
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($values = $element->getValue()) {
            $values = explode( ',', $values );
            $labels = array();
            foreach ( $values as $v ) {
                $tab = $this->_tabFactory->create()->load((int)$v);
                if ($tab->getId()) {
                    $labels[] = $this->escapeHtml($tab->getLabel());
                }
            }
            $labels = implode( '<br/>', $labels );
            $chooser->setLabel( $labels );
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $js = '
            function (grid, event) {
                var clickedElement = event.target;
                var trElement = jQuery(clickedElement).parent("tr");
                var checkbox = jQuery(trElement).find("input.admin__control-checkbox");
                checkbox.prop( "checked", function( i, val ){
                    return !val;
                });
            }
        ';
        return $js;
    }

    /**
     * Prepare wordpress post tabs collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        /* @var $collection \Lero9\WordpressPostTabs\Model\ResourceModel\Tab\CollectionFactory */
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for wordpress post tabs grid
     *
     * @return $this
     */
    protected function _prepareColumns()
    {

        $this->_prepareMassactionColumn();

        $this->addColumn(
            'chooser_id',
            [
                'header' => __('ID'),
                'index' => 'tab_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'chooser_label',
            [
                'header' => __('Label'),
                'index' => 'label',
                'header_css_class' => 'col-title',
                'column_css_class' => 'col-title'
            ]
        );

        $this->addColumn(
            'chooser_wp_url',
            [
                'header' => __('Wordpress Site Url'),
                'index' => 'wp_url',
                'header_css_class' => 'col-url',
                'column_css_class' => 'col-url'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('wordpress/tab_widget/chooser', ['_current' => true]);
    }

    /**
     * Prepare grid massaction column
     *
     * @return $this
     */
    protected function _prepareMassactionColumn()
    {
        $columnId = 'massaction';
        $massactionColumn = $this->getLayout()
            ->createBlock('Magento\Backend\Block\Widget\Grid\Column')
            ->setData(
                [
                    'index' => $this->getMassactionIdField(),
                    'filter_index' => $this->getMassactionIdFilter(),
                    'type' => 'massaction',
                    'name' => 'tab_selection',
                    'is_system' => true,
                    'header_css_class' => 'col-select',
                    'column_css_class' => 'col-select',
                ]
            );

        if ($this->getNoFilterMassactionColumn()) {
            $massactionColumn->setData('filter', false);
        }

        $massactionColumn->setSelected(true)->setGrid($this)->setId($columnId);

        $this->getColumnSet()->insert(
            $massactionColumn,
            count($this->getColumnSet()->getColumns()) + 1,
            false,
            $columnId
        );
        return $this;
    }
}
