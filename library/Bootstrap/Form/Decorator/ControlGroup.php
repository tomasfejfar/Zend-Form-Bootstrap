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
    	//reset error state
    	$class = ' ' . $this->_options['class'] . ' ';
    	$class = trim(str_replace(' error ', '', $class));
    	$this->_options['class'] = $class;
    	
    	$errors = $this->getElement()->getMessages();
    	if (count($errors)) {
    		$this->_options['class'] .= ' error'; 
    	}
    	return parent::render($content);
    } 
}