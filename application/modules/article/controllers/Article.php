<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MX_Controller
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
        $this->load->model('marticle');
        $this->load->model('home/mhome');
    }

    public function index()
    {
        $id = $this->mcommon->base64DecodeStr($this->uri->segment(2));
        $article = $this->marticle->getArticleDetail($id);

        $data['title'] = $article->title;
        $data['active'] = 'detail';
        $data['content'] = 'article-content-detail';
        $data['article'] = $article;
        $translate = null;
        if ($this->session->userdata(SESSION_USER_ID)) {
            $translate = $this->marticle->get_translate($id);
        }
        $data['translate'] = $translate;
        $this->load->view('layout', $data);

        // Save full current URL
        $this->mcommon->setCookieData(COOKIE_FULL_CURRENT_URL, $this->mcommon->getCurrentFullURL());
    }

    public function search()
    {
        $key_search = $this->mcommon->base64DecodeStr($this->uri->segment(2));
        $data['title'] = 'Tìm kiếm: ' . $key_search;
        $data['key_search'] = $key_search;
        $data['active'] = 'home';
        $data['content'] = 'home/home';
        $data['articles'] = $this->mhome->getLstArticles($key_search);
        $this->load->view('layout', $data);
    }

    public function hot_articles()
    {
        $data['title'] = 'Bài được quan tâm';
        $data['active'] = 'home';
        $data['content'] = 'home/home';
        $data['is_hot'] = true;
        $data['articles'] = $this->mhome->getLstArticles(null, true);
        $this->load->view('layout', $data);
    }

    public function ajax_submit_translation()
    {
        if ($this->session->userdata(SESSION_USER_ID)) {
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $description = $this->input->post('description');

            $this->marticle->insertOrUpdateTranslate($id, $title, $description);

            $msg = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert"></button>
                    <span class="glyphicon glyphicon-ok"></span> Dịch thành công!
                </div>';
        } else {
            $msg = '<div class="alert alert-danger">
                    <button class="close" data-dismiss="alert"></button>
                    <span class="glyphicon glyphicon-remove"></span> Dịch thành thất bại!
                </div>';
        }

        echo $msg;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */