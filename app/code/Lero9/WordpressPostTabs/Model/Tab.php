<?php
/**
 * Copyright © 2016 Lero9. All rights reserved.
 */
namespace Lero9\WordpressPostTabs\Model;

use Lero9\WordpressPostTabs\Api\Data\TabInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Wordpress Post Tabs Tab Model
 */
class Tab extends \Magento\Framework\Model\AbstractModel implements TabInterface, IdentityInterface
{
    /**
     * Tab's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'wordpress_post_tab';

    /**
     * @var string
     */
    protected $_cacheTag = 'wordpress_post_tab';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'wordpress_post_tab';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lero9\WordpressPostTabs\Model\ResourceModel\Tab');
    }

    /**
     * Prepare tab's statuses.
     * Available event wordpress_post_tab_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::Tab_ID);
    }

    /**
     * Get Wordpress site url
     *
     * @return string
     */
    public function getWPUrl()
    {
        return $this->getData(self::WP_URL);
    }

    /**
     * Get tab label
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->getData(self::LABEL);
    }

    /**
     * Get Wordpress category ID
     *
     * @return string|null
     */
    public function getWPCatID()
    {
        return $this->getData(self::WP_CAT_ID);
    }

    /**
     * Get number of posts to display
     *
     * @return string|null
     */
    public function getNumPosts()
    {
        return $this->getData(self::NUM_POSTS);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setId($id)
    {
        return $this->setData(self::Tab_ID, $id);
    }

    /**
     * Set Wordpress site url
     *
     * @param string $wp_url
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setWPUrl($wp_url)
    {
        return $this->setData(self::WP_URL, $wp_url);
    }

    /**
     * Set tab label
     *
     * @param string $label
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }

    /**
     * Set Wordpress category ID
     *
     * @param string $wp_cat_id
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setWPCatID($wp_cat_id)
    {
        return $this->setData(self::WP_CAT_ID, $wp_cat_id);
    }

    /**
     * Set number of posts to display
     *
     * @param string $num_posts
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setNumPosts($num_posts)
    {
        return $this->setData(self::NUM_POSTS, $num_posts);
    }

    /**
     * Set creation time
     *
     * @param string $creation_time
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    /**
     * Set update time
     *
     * @param string $update_time
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setUpdateTime($update_time)
    {
        return $this->setData(self::UPDATE_TIME, $update_time);
    }

    /**
     * Set is active
     *
     * @param int|bool $is_active
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
}