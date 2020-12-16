<?php
/**
 * @author  IntoWebDevelopment <info@intowebdevelopment.nl>
 * @project SnelstartApiPHP
 */

namespace SnelstartPHP\Mapper;

use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnelstartPHP\Model\Artikel;
use SnelstartPHP\Model\IncassoMachtiging;
use SnelstartPHP\Model\Kostenplaats;
use SnelstartPHP\Model\Relatie;
use SnelstartPHP\Model\Type\ProcesStatus;
use SnelstartPHP\Model\Verkoopfactuur;
use SnelstartPHP\Model\Verkooporder;
use SnelstartPHP\Model\VerkooporderRegel;
use SnelstartPHP\Model\Verkoopordersjabloon;

final class VerkooporderMapper extends AbstractMapper
{
    public function add(ResponseInterface $response): Verkooporder
    {
        $this->setResponseData($response);
        return $this->map(new Verkooporder());
    }

    public function delete(ResponseInterface $response): void
    {

    }

    public function map(Verkooporder $verkooporder, array $data = []): Verkooporder
    {
        $data = empty($data) ? $this->responseData : $data;
        $adresMapper = new AdresMapper();

        /**
         * @var Verkooporder $verkooporder
         */
        $verkooporder = $this->mapArrayDataToModel($verkooporder, $data);
        $verkooporder->setRelatie(Relatie::createFromUUID(Uuid::fromString($data["relatie"]["id"])))
                     ->setProcesStatus(new ProcesStatus($data["procesStatus"]));

        if ($data["incassomachtiging"] !== null) {
            $verkooporder->setIncassomachtiging(IncassoMachtiging::createFromUUID(Uuid::fromString($data["incassomachtiging"]["id"])));
        }

        if ($data["afleveradres"] !== null) {
            $verkooporder->setAfleveradres($adresMapper->mapAdresToSnelstartObject($data["afleveradres"]));
        }

        if ($data["factuuradres"] !== null) {
            $verkooporder->setFactuuradres($adresMapper->mapAdresToSnelstartObject($data["factuuradres"]));
        }

        if ($data["kostenplaats"] !== null) {
            $verkooporder->setKostenplaats(Kostenplaats::createFromUUID(Uuid::fromString($data["kostenplaats"]["id"])));
        }

        $regels = array_map(function(array $data) {
            return (new VerkooporderRegel())
                ->setArtikel(Artikel::createFromUUID(Uuid::fromString($data["artikel"]["id"])))
                ->setOmschrijving($data["omschrijving"])
                ->setStuksprijs($this->getMoney($data["stuksprijs"]))
                ->setAantal($data["aantal"])
                ->setKortingsPercentage($data["kortingsPercentage"])
                ->setTotaal($this->getMoney($data["totaal"]))
            ;
        }, $data["regels"]);

        $verkooporder->setRegels(...$regels);

        if ($data["factuurkorting"] !== null) {
            $verkooporder->setFactuurkorting($this->getMoney($data["factuurkorting"]));
        }

        if ($data["totaalExclusiefBtw"] !== null) {
            $verkooporder->setTotaalExclusiefBtw($this->getMoney($data["totaalExclusiefBtw"]));
        }

        if ($data["totaalInclusiefBtw"] !== null) {
            $verkooporder->setTotaalInclusiefBtw($this->getMoney($data["totaalInclusiefBtw"]));
        }

        if ($data["verkoopfactuur"] !== null) {
            $verkooporder->setVerkoopfactuur(Verkoopfactuur::createFromUUID(Uuid::fromString($data["verkoopfactuur"])));
        }

        if ($data["verkoopordersjabloon"] !== null) {
            $verkooporder->setVerkoopordersjabloon(Verkoopordersjabloon::createFromUUID(Uuid::fromString($data["verkoopordersjabloon"]["id"])));
        }

        return $verkooporder;
    }
}