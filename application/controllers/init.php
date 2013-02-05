<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Default Controller
 * 
 * @author Aaron 2013/02/04
 */
class Init extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        header('P3P:CP="CAO PSA OUR"');
        $this->load->library('session');
    }

    public function index ()
    {
        $xn_sig_added = $this->input->get('xn_sig_added', TRUE);
        if ($xn_sig_added == 0) {
            redirect('/auth', 'refresh'); // Authorize page
        } else {
            $session_key = $this->input->get('xn_sig_session_key', TRUE);
            $this->session->set_userdata('session_key', $session_key);
            redirect('/main', 'refresh'); // APP page
        }
    }

    public function test ()
    {
        $this->load->view('welcome_message');
    }
}
