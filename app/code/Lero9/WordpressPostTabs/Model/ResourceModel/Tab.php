<?php

namespace Lero9\WordpressPostTabs\Model\ResourceModel;

/**
 * Wordpress post tabs mysql resource
 */
class Tab extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Url\Validator $urlValidator,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
        $this->_urlValidator = $urlValidator;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lero9_wordpress_post_tab', 'tab_id');
    }

    /**
     * Process tab data before saving
     * Do server side validation for form input data
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param \Magento\Framework\Url\Validator $validator
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ( ! $this->_isValidUrl( $object, $this->_urlValidator ) ) { // check if the submitted Wordpress website url is valid
            throw new \Magento\Framework\Exception\LocalizedException(
                __('This is not a valid website url.')
            );
        }

        if ($object->isObjectNew() && !$object->hasCreationTime()) { // to do: use CURRENT_TIMESTAMP as default value in database for creation_time and update_time columns instead of manually setting values here
            $object->setCreationTime($this->_date->gmtDate());
        }

        $object->setUpdateTime($this->_date->gmtDate());

        return parent::_beforeSave($object);
    }

    /**
     * Check if the submitted Wordpress website url is valid
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param \Magento\Framework\Url\Validator $validator
     * @return bool
     */
    protected function _isValidUrl(\Magento\Framework\Model\AbstractModel $object, \Magento\Framework\Url\Validator $validator)
    {
        return $validator->isValid( $object->getData('wp_url') ); // Instead of writing custom Regular Expression rules, we make use of the url validator method that comes with Magento framework.
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Ashsmith\Blog\Model\Post $object
     * @return \Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {

            $select->where( // only load active tabs
                'is_active = ?',
                1
            )->limit(
                    1
                );
        }

        return $select;
    }

    /**
     * Check if tab label exists
     * return tab id if label exists
     *
     * @param string $label
     * @return int
     */
    public function checkLabel($label)
    {
        $select = $this->_getLoadByLabelSelect($label);
        $select->reset(\Zend_Db_Select::COLUMNS)->columns('pt.tab_id')->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieve load select with filter by label and activity
     *
     * @param string $url_key
     * @param int $isActive
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadByLabelSelect($label, $isActive = null)
    {
        $select = $this->getConnection()->select()->from(
            ['pt' => $this->getMainTable()]
        )->where(
                'pt.label = ?',
                $label
            );

        if (!is_null($isActive)) {
            $select->where('pt.is_active = ?', $isActive);
        }

        return $select;
    }
}