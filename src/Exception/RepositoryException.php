<?php
declare(strict_types=1);


namespace Bjyyb\Core\Exception;

use Bjyyb\Core\Base\BaseException;

/**
 * Note: 数据层异常
 * Author: nf
 * Time: 2020/10/26 15:48
 */
class RepositoryException extends BaseException
{
    protected $title = 'Bjyyb\Core\Exception\RepositoryException';
}