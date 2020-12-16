<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Request;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Exception\PreValidationException;
use SnelstartPHP\Model\Kostenplaats;
use function json_encode;

final class KostenplaatsRequest extends BaseRequest
{
    public function findAll(): RequestInterface
    {
        return new Request("GET", "kostenplaatsen");
    }

    public function find(UuidInterface $id): RequestInterface
    {
        return new Request("GET", "kostenplaatsen/" . $id->toString());
    }

    public function add(Kostenplaats $kostenplaats): RequestInterface
    {
        return new Request("POST", "kostenplaatsen", [
            "Content-Type"  =>  "application/json"
        ], json_encode($this->prepareAddOrEditRequestForSerialization($kostenplaats)));
    }

    public function update(Kostenplaats $kostenplaats): RequestInterface
    {
        if ($kostenplaats->getId() === null) {
            throw PreValidationException::shouldHaveAnIdException();
        }

        return new Request("PUT", "kostenplaatsen/" . $kostenplaats->getId()->toString(), [
            "Content-Type"  =>  "application/json"
        ], json_encode($this->prepareAddOrEditRequestForSerialization($kostenplaats)));
    }

    public function delete(Kostenplaats $kostenplaats): RequestInterface
    {
        if ($kostenplaats->getId() === null) {
            throw PreValidationException::shouldHaveAnIdException();
        }

        return new Request("PUT", "kostenplaatsen/" . $kostenplaats->getId()->toString(), [
            "Content-Type"  =>  "application/json"
        ]);
    }
}