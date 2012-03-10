<?php 
class Bootstrap_Form_Decorator_CheckboxLabel extends Zend_Form_Decorator_Label
{
	public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $label     = $this->getLabel();
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag       = $this->getTag();
        $tagClass  = $this->getTagClass();
        $id        = $this->getId();
        $class     = $this->getClass();
        $options   = $this->getOptions();


        if (empty($label) && empty($tag)) {
            return $content;
        }

        if (!empty($label)) {
            $options['class'] = $class;
            $options['escape'] = false;
            $label = $view->formLabel($element->getFullyQualifiedName(), trim($content . $label), $options);
        } else {
            $label = '&#160;';
        }

        if (null !== $tag) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            if (null !== $this->_tagClass) {
                $decorator->setOptions(array('tag'   => $tag,
                                             'id'    => $id . '-label',
                                             'class' => $tagClass));
            } else {
                $decorator->setOptions(array('tag'   => $tag,
                                             'id'    => $id . '-label'));
            }

            $label = $decorator->render($label);
        }

        return $label;
    }
}