<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trigger extends MX_Controller
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
        $this->load->model('mtrigger');
    }

    public function index()
    {

    }

    public function trigger_get_articles_9gap_com_e9a5561e42c5ab47c6c81c14f06c0b8281cfc3ce()
    {
        $html = file_get_contents('http://9gag.com/fresh');
        $dom = new DOMDocument;
        $dom->loadHTML($html);

        $can_access = false;
        foreach($dom->getElementsByTagName('article') as $item) {
            if ($item->hasAttribute('data-entry-id')) {

                $id = trim($item->getAttribute('data-entry-id'));
                $title = null;
                $data_image = null;
                $data_webm = null;
                $data_mp4 = null;
                $type = 1;

                // Header
                $title = trim($item->getElementsByTagName('header')->item(0)->getElementsByTagName('a')->item(0)->textContent);

                // Content
                foreach($item->getElementsByTagName('div') as $itemContent) {

                    if (trim($itemContent->getAttribute('class')) == 'badge-post-container post-container') {
                        $itemVideo = $itemContent->getElementsByTagName('video')->item(0);
                        if (isset($itemVideo)) {
                            foreach ($itemContent->getElementsByTagName('div') as $itemDivVideo) {
                                if ($itemDivVideo->hasAttribute('data-webm')) {
                                    $data_webm = trim($itemDivVideo->getAttribute('data-webm'));
                                    $data_mp4 = trim($itemDivVideo->getAttribute('data-mp4'));
                                    $data_image = trim($itemDivVideo->getAttribute('data-image'));
                                    $type = 2;
                                }
                            }
                        } else {
                            $data_image = trim($itemContent->getElementsByTagName('img')->item(0)->getAttribute('src'));
                            $type = 1;
                        }
                    }
                }

                // Save DB
                if ($id != null && $title != null && $data_image != null
                    && $id != '' && $title != '' && $data_image != '') {
                    $this->mtrigger->insert_into_articles($id, $title, $data_image, $data_webm, $data_mp4, $type);
                    $can_access = true;
                }
            }
        }

        if (!$can_access) {
            // Log cannot access
            $log = ''
                . '[' . date("Y-m-d H:i:s") . '] - Cannot get articles from http://9gag.com/fresh.'
                . PHP_EOL;
            file_put_contents('./assets/logs/error_get_articles.txt', $log, FILE_APPEND);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */