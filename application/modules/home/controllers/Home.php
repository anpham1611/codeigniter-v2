<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller
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
        $this->load->model('mhome');
    }

    public function index()
    {
        $data['title'] = 'Vui Xem Ảnh * Đua Dịch Bài * Luyện Anh Văn';
        $data['active'] = 'home';
        $data['content'] = 'home';
        $data['articles'] = $this->mhome->getLstArticles();
        $this->load->view('layout', $data);

        // Save full current URL
        $this->mcommon->setCookieData(COOKIE_FULL_CURRENT_URL, $this->mcommon->getCurrentFullURL());
    }

    public function ajax_get_more_articles()
    {
        $arr_ids = $this->input->post('arr_ids');
        $key_search = $this->input->post('key_search');
        $is_hot = $this->input->post('is_hot');
        $data['articles'] = $this->mhome->getLstLoadMoreArticles($arr_ids, $key_search, $is_hot);
        $this->load->view('home/articles-content', $data);
    }

    public function fb_login()
    {
        $user = $this->lfb->finish_login();

        if ($user != null) {
            $id = isset($user['id']) ? $user['id'] : null;
            $name = isset($user['name']) ? $user['name'] : null;
            $email = isset($user['email']) ? $user['email'] : null;
            $first_name = isset($user['first_name']) ? $user['first_name'] : null;
            $middle_name = isset($user['middle_name']) ? $user['middle_name'] : null;
            $last_name = isset($user['last_name']) ? $user['last_name'] : null;
            $link = isset($user['link']) ? $user['link'] : null;
            $birthday = isset($user['birthday']) ? $user['birthday'] : null;
            $location = isset($user['location']) ? $user['location'] : null;
            $hometown = isset($user['hometown']) ? $user['hometown'] : null;

            $avatar = '//graph.facebook.com/' . $id . '/picture';

            // Save DB
            $this->mhome->insert_or_update_user($id, $avatar, $name, $email, $first_name, $middle_name, $last_name, $link, $birthday, $location, $hometown);

            // Session
            $this->session->set_userdata(SESSION_USER_ID, $id);
            $this->session->set_userdata(SESSION_USER_NAME, $name);
            $this->session->set_userdata(SESSION_USER_EMAIL, $email);
            $this->session->set_userdata(SESSION_USER_AVATAR, $avatar);
        }

        $current_url = $this->mcommon->getCookieData(COOKIE_FULL_CURRENT_URL);
        if (isset($current_url)) {
            redirect($current_url);
        } else {
            redirect("/");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();

        $current_url = $this->mcommon->getCookieData(COOKIE_FULL_CURRENT_URL);
        if (isset($current_url)) {
            redirect($current_url);
        } else {
            redirect("/");
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */