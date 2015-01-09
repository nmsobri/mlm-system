<?php

use Mlm\Interfaces\UserReportInterface;

class RegularUserReportController extends BaseController
{
    protected $repository = null;

    public function __construct( UserReportInterface $repository )
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
        return $this->repository->transactionExcel( Auth::user()->id );
    }


    public function transactionPdf()
    {
        return $this->repository->transactionPdf( Auth::user()->id );
    }


}
