<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Connector\V2;

use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Connector\BaseConnector;
use SnelstartPHP\Exception\SnelstartResourceNotFoundException;
use SnelstartPHP\Mapper\V2\ArtikelOmzetgroepMapper;
use SnelstartPHP\Model\V2\ArtikelOmzetgroep;
use SnelstartPHP\Request\V2\ArtikelOmzetgroepRequest;

final class ArtikelOmzetgroepConnector extends BaseConnector
{
    public function find(UuidInterface $id): ?ArtikelOmzetgroep
    {
        try {
            $mapper = new ArtikelOmzetgroepMapper();
            $request = new ArtikelOmzetgroepRequest();

            return $mapper->find($this->connection->doRequest($request->find($id)));
        } catch (SnelstartResourceNotFoundException $e) {
            return null;
        }
    }

    /**
     * @template T as ArtikelOmzetgroep
     * @psalm-return \Generator<T>
     * @return iterable
     */
    public function findAll(): iterable
    {
        $mapper = new ArtikelOmzetgroepMapper();
        $request = new ArtikelOmzetgroepRequest();

        return $mapper->findAll($this->connection->doRequest($request->findAll()));
    }
}
