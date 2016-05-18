<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MX_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('mapi');
    }

    public function index()
    {
    }

    public function test_api()
    {
        /*Get data*/
        $data = array();

        $username = trim($this->input->post("username"));
        $password = trim($this->input->post("password"));

        /*Do action*/
        if ($username != null && $password != null) {
            $data['code'] = '1';
            $data['message'] = 'Hello world! $username: ' . $username . ' - $password: ' . $password;
        } else {
            $data['code'] = '0';
            $data['message'] = 'Failed';
        }

        /*Return*/
        $this->output->set_header(OUTPUT_CONTENT_TYPE);
        echo json_encode($data, true);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */