<?php 
class Bootstrap_Form_Decorator_Radio extends Zend_Form_Decorator_ViewHelper
{
	public function render($content)
    {
        $element = $this->getElement();

        $view = $element->getView();
        if (null === $view) {
            require_once 'Zend/Form/Decorator/Exception.php';
            throw new Zend_Form_Decorator_Exception('ViewHelper decorator cannot render without a registered view object');
        }

        if (method_exists($element, 'getMultiOptions')) {
            $element->getMultiOptions();
        }

        $helper        = $this->getHelper();
        $separator     = $this->getSeparator();
        $value         = $this->getValue($element);
        $attribs       = $this->getElementAttribs();
        $name          = $element->getFullyQualifiedName();
        $id            = $element->getId();
        $attribs['id'] = $id;
        $helperObject  = $view->getHelper($helper);
        if (method_exists($helperObject, 'setTranslator')) {
            $helperObject->setTranslator($element->getTranslator());
        }
        $attribs['label_class'] = 'radio'; 
        $elementContent = $view->$helper($name, $value, $attribs, $element->options);
        switch ($this->getPlacement()) {
            case self::APPEND:
                return $content . $separator . $elementContent;
            case self::PREPEND:
                return $elementContent . $separator . $content;
            default:
                return $elementContent;
        }
    } 
}