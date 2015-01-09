<?php

use Mlm\Interfaces\AdminReportInterface;

class SuperAdminReportController extends BaseController
{
    protected $repository = null;

    public function __construct(  AdminReportInterface $repository )
    {
        $this->repository = $repository;
    }


    public function userExcel()
    {
        return $this->repository->userExcel();
    }


    public function userPdf()
    {
        return $this->repository->userPdf();
    }


    public function transactionExcel()
    {
        return $this->repository->transactionExcel();
    }


    public function transactionPdf()
    {
        return $this->repository->transactionPdf();
    }

}
