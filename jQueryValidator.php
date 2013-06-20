<?php
/**
 * @author Deepak B. <deepakb089@gmail.com>
 */
class jQueryValidator
{
    private $_rules = array();
    private $_messages = array();
    private $_setupOptions = array();
    private $_form = NULL;
    private $_counter = 0;
    private $_validateOnBlur = false;
    
    public function setForm($selector)
    {
        $this->_form = $selector;
    }
    
    public function setOption($key, $value)
    {
        $this->_setupOptions[$key] = $value;
    }
    
    public function setRule($fieldName, $rules=NULL, $messages=NULL)
    {
        $this->_rules[$this->_counter]['field'] = $fieldName;
        $this->_rules[$this->_counter]['rules'] = $rules;
        
        $this->_messages[$this->_counter]['field'] = $fieldName;
        $this->_messages[$this->_counter]['messages'] = $messages;
        
        $this->_counter++;
    }
    
    public function getValidationCode()
    {
        $options = array();
        $options = $this->_setupOptions;
        
        
        foreach($this->_rules as $rule) {
            $options['rules'][$rule['field']] = $rule['rules'];
        } 
        
        foreach($this->_messages as $field => $messages) {
            $options['messages'][$messages['field']] = $messages['messages'];
        } 
        
        $optionsObject = json_encode($options);
        
        $validationCode = " <script type='text/javascript'>\n
        $(document).ready(function() { 
        var form_setup = {$optionsObject}; "; 
        if($this->_validateOnBlur) {
            $validationCode .= "
                form_setup['onfocusout'] = function(element) { $(element).valid() }; ";
        }
        $optionsObject = json_encode($options);
        $validationCode .= "jQuery('{$this->_form}').validate( form_setup ); \n }); </script>";
        return $validationCode;
    }
    
    public function validateOnBlur()
    {
        $this->_validateOnBlur = TRUE;
    }
    
}