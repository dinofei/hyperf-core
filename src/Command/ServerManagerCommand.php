<?php

declare(strict_types=1);

namespace Bjyyb\Core\Command;

use Hyperf\Command\Command as HyperfCommand;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;


class ServerManagerCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('server');
    }

    public function configure()
    {
        parent::configure();
        $this
            ->setDescription('服务启动管理')
            ->addArgument('name', InputArgument::REQUIRED, '指令');
    }

    public function handle()
    {
        $pidFile = BASE_PATH . '/runtime/hyperf.pid';
        $pid = null;

        if (file_exists($pidFile)) {
            $pid = file_get_contents($pidFile);
        }

        if (!$pid) {
            $this->line('服务未运行!', 'info');
            return SymfonyCommand::FAILURE;
        }

        switch ($this->input->getArgument('name')) {
            case 'reload':
                exec('kill -USR1 ' . $pid);
                $this->line('服务重启成功!', 'info');
                break;
            case 'shutdown':
                exec('kill -15 ' . $pid);
                $this->line('服务关闭成功!', 'info');
                break;
            default:
                $this->line('未找到该指令!', 'info');
        }
        return SymfonyCommand::SUCCESS;
    }
}
