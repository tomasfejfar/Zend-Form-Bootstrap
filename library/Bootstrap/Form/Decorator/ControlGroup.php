<?php 
class Bootstrap_Form_Decorator_ControlGroup extends Zend_Form_Decorator_HtmlTag
{
	/**
     * HTML tag to use
     * @var string
     */
    protected $_tag = 'div';
    
    protected $_options = array('class' => 'control-group');
    
	public function render($content)
    {
    	$errors = $this->getElement()->getMessages();
    	if (count($errors)) {
    		$this->_options['class'] .= ' error'; 
    	}
    	return parent::render($content);
    } 
}