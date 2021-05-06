<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Mapper\V2;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnelstartPHP\Mapper\AbstractMapper;
use SnelstartPHP\Model\SnelstartObject;
use SnelstartPHP\Model\Type\PrijsBepalingSoort;
use SnelstartPHP\Model\V2\Artikel;
use SnelstartPHP\Model\V2\ArtikelOmzetgroep;
use SnelstartPHP\Model\V2\Prijsafspraak;
use SnelstartPHP\Model\V2\Relatie;
use SnelstartPHP\Model\V2\SubArtikel;

final class ArtikelOmzetgroepMapper extends AbstractMapper
{
    public function find(ResponseInterface $response): ?ArtikelOmzetgroep
    {
        $this->setResponseData($response);
        return $this->mapResponseToArtikelOmzetgroepModel(new ArtikelOmzetgroep());
    }

    public function findAll(ResponseInterface $response): \Generator
    {
        $this->setResponseData($response);

        foreach ($this->responseData as $data) {
            yield $this->mapResponseToArtikelOmzetgroepModel(new ArtikelOmzetgroep(), $data);
        }
    }

    protected function mapResponseToArtikelOmzetgroepModel(ArtikelOmzetgroep $artikelOmzetgroep, array $data = []): ArtikelOmzetgroep
    {
        $data = empty($data) ? $this->responseData : $data;

        /**
         * @var ArtikelOmzetgroep $artikelOmzetgroep
         */
        $artikelOmzetgroep = $this->mapArrayDataToModel($artikelOmzetgroep, $data);

        return $artikelOmzetgroep;
    }

    /**
     * Map many results to the mapper.
     *
     * @return \Generator
     */
    protected function mapManyResultsToSubMappers(): \Generator
    {
        foreach ($this->responseData as $artikelOmzetgroepData) {
            yield $this->mapResponseToArtikelOmzetgroepModel(new ArtikelOmzetgroep(), $artikelOmzetgroepData);
        }
    }
}
