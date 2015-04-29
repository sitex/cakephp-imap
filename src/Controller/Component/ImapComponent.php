<?php
namespace Imap\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Ddeboer\Imap\Server;

/**
 * Imap component
 */
class ImapComponent extends Component
{

    public $components = ['RequestHandler'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'configFile' => 'config'
    ];

    protected $config;

    protected $server;
    protected $connection;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $configFile = $this->config['configFile'];

        $credentialsFile = $configFile . '.php';
        $credentialsFilePath = ROOT . DS . 'config' . DS . 'imap' . DS . $credentialsFile;
        $credentials = require $credentialsFilePath;

        // $connection is instance of \Ddeboer\Imap\Connection
        $this->server = new Server($credentials['server'], 993, '/imap/no-validate-cert');
        $this->connection = $this->server->authenticate($credentials['email'], $credentials['password']);
    }

}
