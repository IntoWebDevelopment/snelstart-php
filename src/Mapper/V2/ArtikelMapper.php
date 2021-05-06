<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Mapper\V2;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnelstartPHP\Mapper\AbstractMapper;
use SnelstartPHP\Model\Type\PrijsBepalingSoort;
use SnelstartPHP\Model\V2\Artikel;
use SnelstartPHP\Model\V2\ArtikelOmzetgroep;
use SnelstartPHP\Model\V2\Prijsafspraak;
use SnelstartPHP\Model\V2\Relatie;
use SnelstartPHP\Model\V2\SubArtikel;

final class ArtikelMapper extends AbstractMapper
{
    public function find(ResponseInterface $response): ?Artikel
    {
        $this->setResponseData($response);
        return $this->mapResponseToArtikelModel(new Artikel());
    }

    public function findAll(ResponseInterface $response): \Generator
    {
        $this->setResponseData($response);
        return $this->mapManyResultsToSubMappers();
    }

    public function add(ResponseInterface $response): Artikel
    {
        $this->setResponseData($response);
        return $this->mapResponseToArtikelModel(new Artikel());
    }

    public function update(ResponseInterface $response): Artikel
    {
        $this->setResponseData($response);
        return $this->mapResponseToArtikelModel(new Artikel());
    }

    protected function mapResponseToArtikelModel(Artikel $artikel, array $data = []): Artikel
    {
        $data = empty($data) ? $this->responseData : $data;

        /**
         * @var Artikel $artikel
         */
        $artikel = $this->mapArrayDataToModel($artikel, $data);

        if (isset($data["prijsafspraak"])) {
            $artikel->setPrijsAfspraak($this->mapPrijsAfspraakToArtikelInstance($data["prijsafspraak"]));
        }

        if (isset($data["verkoopprijs"])) {
            $artikel->setVerkoopprijs($this->getMoney($data["verkoopprijs"]));
        }

        if (isset($data["inkoopprijs"])) {
            $artikel->setInkoopprijs($this->getMoney($data["inkoopprijs"]));
        }

        if (isset($data["artikelOmzetgroep"])) {
            $artikel->setArtikelOmzetgroep(ArtikelOmzetgroep::createFromUUID(Uuid::fromString($data["artikelOmzetgroep"]["id"])));
        }

        foreach ($data["subartikelen"] ?? [] as $subArtikel) {
            $artikel->addSubArtikel(SubArtikel::createFromUUID($subArtikel["id"])
                ->setAantal($subArtikel["aantal"])
                ->setArtikelcode($subArtikel["artikelcode"])
            );
        }

        return $artikel;
    }

    protected function mapPrijsAfspraakToArtikelInstance(array $data): Prijsafspraak
    {
        $prijsafspraak = new Prijsafspraak();

        if (isset($data["relatie"]) && $data["relatie"] !== null) {
            $prijsafspraak->setRelatie(Relatie::createFromUUID(Uuid::fromString($data["relatie"]["id"])));
        }

        if (isset($data["artikel"]) && $data["artikel"] !== null) {
            $prijsafspraak->setArtikel(Artikel::createFromUUID(Uuid::fromString($data["artikel"]["id"])));
        }

        return $prijsafspraak->setDatum(new \DateTimeImmutable($data["datum"]))
            ->setAantal($data["aantal"])
            ->setKorting($data["korting"])
            ->setVerkoopprijs($this->getMoney($data["verkoopprijs"]))
            ->setBasisprijs($this->getMoney($data["basisprijs"]))
            ->setDatumVanaf($data["datumVanaf"] !== null ? new \DateTimeImmutable($data["datumVanaf"]) : null)
            ->setDatumTotEnMet($data["datumTotEnMet"] !== null ? new \DateTimeImmutable($data["datumTotEnMet"]) : null)
            ->setPrijsBepalingSoort(new PrijsBepalingSoort($data["prijsBepalingSoort"]))
        ;
    }

    /**
     * Map many results to the mapper.
     *
     * @return \Generator
     */
    protected function mapManyResultsToSubMappers(): \Generator
    {
        foreach ($this->responseData as $artikelData) {
            yield $this->mapResponseToArtikelModel(new Artikel(), $artikelData);
        }
    }
}
