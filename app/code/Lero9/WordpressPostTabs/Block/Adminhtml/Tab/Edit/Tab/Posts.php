<?php
/**
 * Copyright © 2016 Lero9. All rights reserved.
 */
namespace Lero9\WordpressPostTabs\Block\Adminhtml\Tab\Edit\Tab;

/**
 * Adminhtml wordpress post tab edit form posts tab
 */
class Posts extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Lero9_WordpressPostTabs::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('tab_');

        $model = $this->_coreRegistry->registry('wordpress_post_tab');

        $fieldset = $form->addFieldset(
            'posts_fieldset',
            ['legend' => __('Wordpress Posts'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'wp_url',
            'text',
            [
                'name' => 'wp_url',
                'label' => __('Wordpress site url'),
                'title' => __('Wordpress site url'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'num_posts',
            'text',
            [
                'name' => 'num_posts',
                'label' => __('Number of posts to display'),
                'title' => __('Number of posts to display'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'wp_cat_id',
            'text',
            [
                'name' => 'wp_cat_id',
                'label' => __('Post category ID'),
                'title' => __('Post category ID'),
                'disabled' => $isElementDisabled
            ]
        );

        $this->_eventManager->dispatch('adminhtml_wordpress_post_tab_edit_tab_posts_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Wordpress Posts');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Wordpress Posts');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
