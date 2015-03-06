<?php
namespace Imap\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Event\EventManagerTrait;
use Ddeboer\Imap\Server;

/**
 * Imap component
 */
class ImapComponent extends Component
{
    use EventManagerTrait;

    public $components = ['RequestHandler'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'configFile' => 'config'
    ];

    protected $server;
    protected $connection;

    /**
     * Request object
     *
     * @var \Cake\Network\Request
     */
    public $request;

    /**
     * Response object
     *
     * @var \Cake\Network\Response
     */
    public $response;

    /**
     * Instance of the Session object
     *
     * @return void
     */
    public $session;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->eventManager($controller->eventManager());
        $this->request = $controller->request;
        $this->response = $controller->response;
        $this->session = $controller->request->session();
    }

    public function connect()
    {
        $configFile = $configFile . '.php';
        $configFilePath = ROOT . DS . 'config' . DS . 'permissions' . DS . $configFile;
        $config = require $configFilePath;

        $this->server = new Server($config['server']);

        // $connection is instance of \Ddeboer\Imap\Connection
        $this->connection = $this->server->authenticate($config['email'], $config['password']);
    }

}
