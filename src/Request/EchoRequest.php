<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 * @deprecated
 */

namespace SnelstartPHP\Request;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class EchoRequest extends BaseRequest
{
    public function echo(string $input): RequestInterface
    {
        return new Request("GET", "echo/" . $input);
    }
}