<?php

declare(strict_types=1);

namespace Bjyyb\Core\Util;

/**
 * Note: 客户端交互工具
 * Author: nf
 * Time: 2020/11/18 16:32
 */
class ClientUtil
{
    /**
     * http请求
     * @param string $url
     * @param string $method
     * @param array $params
     * @param array $headers
     * @param int $timeout
     * @return array
     * @throws \Exception
     * Author: nf
     * Time: 2020/11/18 16:32
     */
    public function http(string $url, string $method = 'GET', $params = [], array $headers = [], int $timeout = 60): array
    {
        $parse = parse_url($url);
        if (false === $parse) throw new \Exception('无效的请求地址');
        $port = $this->getHostPort($parse);
        $ssl = $this->isSSL($parse);
        $options = [];
        $client = new \Swoole\Coroutine\Http\Client($parse['host'], $port, $ssl);
        $options['timeout'] = $timeout;
        if ($ssl) {
            $options['ssl_verify_peer'] = false;
        }
        $client->set($options);
        if (isset($parse['query'])) {
            $parse['path'] .= '?' . $parse['query'];
        }
        $client->setMethod($method);
        $client->setData($params);
        $client->setHeaders($headers);
        $client->execute($parse['path']);
        [$code, $msg, $body, $status] = [$client->errCode, $client->errMsg, $client->body, $client->statusCode];
        $client->close();
        return ['code' => $code, 'msg' => $msg, 'status' => $status, 'body' => $body];
    }

    /**
     * 获取端口
     * @param $parse
     * @return int
     * Author: nf
     * Time: 2020/11/18 16:32
     */
    public function getHostPort($parse): int
    {
        return isset($parse['port']) ? $parse['port'] : (isset($parse['scheme']) && $parse['scheme'] === 'https' ? 443 : 80);
    }

    /**
     * 是否为https请求
     * @param $parse
     * @return bool
     * Author: nf
     * Time: 2020/11/18 16:31
     */
    public function isSSL($parse)
    {
        return isset($parse['scheme']) && $parse['scheme'] === 'https';
    }
}
