<?php

namespace App\Controllers;

use App\Models\DesaModel;
use App\Models\ConfigModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * @var \App\Models\DesaModel
     */
    protected $desaModel;
    protected $configModel;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        parent::initController($request, $response, $logger);

        $this->desaModel = new DesaModel();
        $this->configModel = new ConfigModel();

        $uriSegment = $request->getUri()->getSegment(1);
        $village    = $this->desaModel->where('permalink', $uriSegment)->get_desa_with_config()->first();
        if ($village) {
            $config = $this->configModel->where('desa_id', $village['id'])->first();


            return view('layout/public', [
                'uriSegment' => $uriSegment,
                'village' => $village,
                'config' =>  $config,
            ]);
        }
    }

    /**
     * Render a view with the common data.
     *
     * @param string $view
     * @param array $data
     * @return \CodeIgniter\HTTP\Response
     */
    protected function view(string $view, array $data = [])
    {
        return view($view, array_merge($this->data, $data));
    }
}
