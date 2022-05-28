<?php
class MY_Controller extends CI_Controller{
    private $_userId;
    private $_level;
    private $_area;
    private $_userInfo;
    private $_parameterArea;
    
    public function __construct(){
        parent::__construct();
        
         $url = uri_string();
              
        $requesToken = true;
        
        if (empty($url)){
            $url = "main";
        }
        
        if ( $url == "login"){
            $requesToken = false;
        }elseif ($url == "resetPass"){
            $requesToken = false;
        }
        
        if ( $requesToken ){
            
            $isLogin = $this->session->userdata('a_userid'); //$this->cekOauth();  
           
            if ($isLogin){
                $f_level =  $this->session->userdata('a_user_level_id');
            
                $this->setUserLevel($f_level);
                $this->load->model('musermenu');
                $res = $this->useraccess->cekOtoritas($url,$f_level);
              
                if ( $this->input->is_ajax_request()){
                    if ( $res ){
                        $alert = 'flash';
                        $value = 'error';
                        $errno = 502;

                        $output = array(
                            'flash'=> $alert,
                            'value'=> $value,
                            'error_no' => $errno
                        );
                        echo json_encode($output);     
                        exit;
                    }
                    
                }
                if($res){
                    $id = $this->input->post('id', true);
                    if ($id){
                        $prevLink = $this->session->flashdata('prevUrl');
                        $this->session->set_flashdata('error', 'Access Denied.');

                        if ($prevLink){
                            redirect($prevLink);
                        }else{
                            redirect('home');
                        }
                    }                                      
                }
              
                $this->setUserid($isLogin);
            }else{
                redirect('/login');
            }
        }
        
    }
    
    public function setUserid($userid){
        $this->_userId = $userid;
    }
        
    public function getUserid(){
        return $this->_userId;
    }
    
    public function setUserLevel($level){
        $this->_level = $level;
    }

    public function getUserLevel(){
        return $this->_level ;
    }
    
}
