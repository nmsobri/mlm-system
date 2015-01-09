<?php

use Mlm\Interfaces\AdminReportInterface;

class RegularAdminReportController extends BaseController
{
    protected $repository = null;

    public function __construct(  AdminReportInterface $repository )
    {
        $this->repository = $repository;
    }


    public function userExcel()
    {
        return $this->repository->userExcel( Auth::user()->id );
    }


    public function userPdf()
    {
        return $this->repository->userPdf( Auth::user()->id );
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
