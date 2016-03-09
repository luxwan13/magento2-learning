<?php
/**
 * Copyright © 2016 Lero9. All rights reserved.
 */
namespace Lero9\WordpressPostTabs\Api\Data;

/**
 * Wordpress post tab interface.
 * @api
 */
interface TabInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const Tab_ID        = 'tab_id';
    const WP_URL        = 'wp_url';
    const LABEL         = 'label';
    const WP_CAT_ID     = 'wp_cat_id';
    const NUM_POSTS     = 'num_posts';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Wordpress site url
     *
     * @return string
     */
    public function getWPUrl();

    /**
     * Get tab label
     *
     * @return string|null
     */
    public function getLabel();

    /**
     * Get Wordpress category ID
     *
     * @return string|null
     */
    public function getWPCatID();

    /**
     * Get number of posts to display
     *
     * @return string|null
     */
    public function getNumPosts();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setId($id);

    /**
     * Set Wordpress site url
     *
     * @param string $wp_url
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setWPUrl($wp_url);

    /**
     * Set tab label
     *
     * @param string $label
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setLabel($label);

    /**
     * Set Wordpress category ID
     *
     * @param string $wp_cat_id
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setWPCatID($wp_cat_id);

    /**
     * Set number of posts to display
     *
     * @param string $num_posts
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setNumPosts($num_posts);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Lero9\WordpressPostTabs\Api\Data\TabInterface
     */
    public function setIsActive($isActive);
}