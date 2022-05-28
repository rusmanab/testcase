<?php
class Theme_admin {
	protected $_ci;
	protected $_regCssHead;
    protected $_regCssHead2;
    
    protected $_regjsClosing;
    protected $_regjsClosing2;
    protected $_regAddJs;
    
    
	function __construct(){
		$this->_ci = & get_instance();
		$this->_ci->load->library('session');
        
	}	
	
	function display($template='',$data='',$dir=''){
	    
        $templateDir = "admindefault";
        
		if (empty($dir)){
		      $dir					= $this->_ci->uri->segment(1);  
		}
        $data['urlBase']	 =$this->_ci->uri->segment(1);
		$data['url']		 =$this->_ci->uri->segment(2);
        $data['jsclosing']  = "";
        $data['jsclosing2'] = "";
        $data['csshead']    = "";
        $data['csshead2']   = "";
        $data['addjs']      = "";
        
        //$dir = $data['dir'];
        $this->_ci->db->where(array('isRead'=>'0'));
        $message = '';//$this->_ci->db->get('tbl_messages')->result();
        $this->_ci->db->where(array('isread'=>'0'));
        //$service = $this->_ci->db->get('tbl_services_training')->result();
        
        $data['messagesNoRead'] = $message;
        //$data['services'] = $service;
        
        if (!empty($this->_regjsClosing))
        {
            $data['jsclosing'] = $this->_regjsClosing;
        }
        if (!empty($this->_regjsClosing2))
        {
            $data['jsclosing2'] = $this->_regjsClosing2;
        }
        if (!empty($this->_regCssHead))
        {
            $data['csshead'] = $this->_regCssHead;
        }
        if (!empty($this->_regCssHead2))
        {
            $data['csshead2'] = $this->_regCssHead2;
        }
        
        
        if (!empty($this->_regAddJs))
        {
            $data['addjs'] = $this->_ci->load->view($this->_regAddJs,$data,TRUE);
        }
        
	    
		$data['header']			= $this->_ci->load->view('template/'.$templateDir.'/header',$data,TRUE);
		$data['sidebar']	 	= $this->_ci->load->view('template/'.$templateDir.'/sidebar',$data,TRUE);
        $data['maincontent']	= $this->_ci->load->view('pages/'.$template,$data,TRUE);
        // $data['footer']			= $this->_ci->load->view('theme/'.$templateDir.'/footer',$data,TRUE);
		
		//$data['addjs']           = $this->_ci->load->view('pages/'.$dir.'/addjs',$data,TRUE);		
        
        
		
		$this->_ci->load->view('template/'.$templateDir.'/main',$data);
	}	
	
    function registerCsshead($CSS,$p=1)
    {
        $css = "";
        if (is_array($CSS))
        {
            
            foreach($CSS as $csscript =>$key)
            {
               
                $styleLink = '<link href="'.$key.'" rel="stylesheet" type="text/css"/>';
                
                $css.= "\n".$styleLink;
            }
        }
        //var_dump($css);
        if ($p==1){
            $this->_regCssHead = $css;
        }else{
            $this->_regCssHead2 = $css;
        }
        
    }
    
    function regsiterJsClosing($jScript,$t=1)
    {
        $js = "";
        if (is_array($jScript))
        {
            
            foreach($jScript as $jscript =>$key)
            {
               
                $j = '<script src="'.$key.'"></script>';
                
                $js.= "\n".$j;
            }
        }
        $js.= "\n";
        
        if ($t==1){
            $this->_regjsClosing = $js;
        }elseif ($t==2){
            $this->_regjsClosing2 = $js;
        }
        
    }
    
    function registerScript($view)
    {
        $this->_regAddJs = $view;
    }
}
