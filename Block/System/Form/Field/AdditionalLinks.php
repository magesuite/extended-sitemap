<?php

namespace MageSuite\ExtendedSitemap\Block\System\Form\Field;

class AdditionalLinks extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected function _construct()
    {
        $this->addColumn('path', ['label' => __('Path'), 'class' => 'required-entry']);
        $this->addColumn('priority', ['label' => __('Priority'), 'class' => 'required-entry']);
        $this->addColumn('changeFrequency', ['label' => __('Change Frequency'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');

        parent::_construct();
    }
}
