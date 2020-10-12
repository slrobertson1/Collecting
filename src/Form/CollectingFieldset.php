<?php

namespace Collecting\Form;

use Zend\Form\ElementPrepareAwareInterface;
use Zend\Form\Fieldset;
use Zend\Form\FormInterface;

class CollectingFieldset extends Fieldset
{
    /**
     * @param  null|int|string  $name    Optional name for the element
     * @param  array            $options Optional options for the element
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    /**
     * Ensures state is ready for use. In the base class, we append the name of the fieldsets to every elements in order to avoid
     * name clashes if the same fieldset is used multiple times. However, in the Collecting module, this fieldset
     * will not be used multiple times and the Collecting module expects Element names to not be prefixed with the
     * enclosing fieldset name.
     *
     * @param  FormInterface $form
     * @return mixed|void
     */
    public function prepareElement(FormInterface $form)
    {
//        $name = $this->getName();

        foreach ($this->iterator as $elementOrFieldset) {
//            $elementOrFieldset->setName($name . '[' . $elementOrFieldset->getName() . ']');

            // Recursively prepare elements
            if ($elementOrFieldset instanceof ElementPrepareAwareInterface) {
                $elementOrFieldset->prepareElement($form);
            }
        }
    }
}
