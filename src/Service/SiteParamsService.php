<?php


namespace App\Service;


use App\Entity\SiteParams;
use App\Repository\SiteParamsRepository;

class SiteParamsService
{
    /**
     * @var SiteParamsRepository
     */
    private SiteParamsRepository $repository;

    public function __construct(SiteParamsRepository $site_params_repository)
    {
        $this->repository = $site_params_repository;
    }

    public function getSiteParams(): ?SiteParams
    {
        return $this->repository->findBy([],[],[1])[0] ?? null;
    }

}