<?php
namespace Application\Controllers;

use Application\Core\BaseController;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends BaseController
{
    /**
     * Responsible for default index page.
     *
     * @param $params
     * @return Response
     */
    public function index($params) : Response
    {
        $this->view->template = 'coupon.php';
        $this->view->generate([]);
        $this->services->get('dataFetcher');

        return (new Response())->setContent($this->view);
    }
}
