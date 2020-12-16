<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 * @deprecated
 */

namespace SnelstartPHP\Connector;

use Ramsey\Uuid\UuidInterface;
use SnelstartPHP\Exception\SnelstartResourceNotFoundException;
use SnelstartPHP\Mapper\LandMapper;
use SnelstartPHP\Model\Land;
use SnelstartPHP\Request\LandRequest;

final class LandConnector extends BaseConnector
{
    public function find(UuidInterface $id): ?Land
    {
        try {
            $mapper = new LandMapper();
            $request = new LandRequest();

            return $mapper->find($this->connection->doRequest($request->find($id)));
        } catch (SnelstartResourceNotFoundException $e) {
            return null;
        }
    }

    /**
     * @template T as Land
     * @psalm-return \Generator<T>
     * @return iterable
     */
    public function findAll(): iterable
    {
        $mapper = new LandMapper();
        $request = new LandRequest();

        return $mapper->findAll($this->connection->doRequest($request->findAll()));
    }
}