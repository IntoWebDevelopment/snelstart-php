<?php
/**
 * @author  OptiWise Technologies B.V. <info@optiwise.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Request\V2;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Request\BaseRequest;

final class ArtikelOmzetgroepRequest extends BaseRequest
{
    public function findAll(): RequestInterface
    {
        return new Request("GET", "artikelomzetgroepen");
    }

    public function find(UuidInterface $id): RequestInterface
    {
        return new Request("GET", "artikelomzetgroepen/" . $id->toString());
    }
}
