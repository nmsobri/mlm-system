<?php

namespace Mlm\Repositories;

use DB;
use Hash;
use Auth;
use Paginator;
use Mlm\Eloquents\User;
use Mlm\Eloquents\Profile;
use Mlm\Eloquents\Customer;
use Mlm\Eloquents\Downline;

class RegularAdminRepository extends SuperAdminRepository
{
    protected $user     = null;
    protected $profile  = null;
    protected $customer = null;
    protected $downline = null;

    protected $rules = array(
        'username' => 'required|min:4|alpha_dash|unique:users,username',
        'password' => 'sometimes|required|min:6',
        'password_confirm' => 'sometimes|required|same:password',
        'status'=>'sometimes|required', 'groups'=>'sometimes|required',
        'full_name'=>'required|alpha_spaces',
        'email' => 'sometimes|required|email',
        'ic_num'=>'required|unique:profiles,ic_num|digits:12',
        'gender'=>'required', 'contact_num'=>'sometimes|required|digits_between:8,14',
        'picture'=> 'sometimes|mimes:png,jpg,jpeg',
        'heir_name'=> 'sometimes|required|alpha_spaces',
        'heir_contact_num' => 'sometimes|required|digits_between:8,14',
        'bank_account' => 'sometimes|required',
        'account_num' => 'sometimes|required|digits_between:8,18'
    );

    public function __construct( User $user, Profile $profile,
                                 Customer $customer, Downline $downline )
    {
        $this->user     = $user;
        $this->profile  = $profile;
        $this->customer = $customer;
        $this->downline = $downline;
    }


    public function createUser( $input )
    {
        #user
        $user = array( 'username' => $input['username'],
            'password' => Hash::make( $input['password'] ),
            'status' => $input['status'], 'groups' => 'ultimate_user'
        );
        $user = $this->user->create( $user );

        #profile
        $profile = array( 'user_id' => $user->id,
            'full_name' => $input['full_name'], 'email' => $input['email'],
            'ic_num' => $input['ic_num'], 'gender' => $input['gender'],
            'contact_num'=> $input['contact_num'],
            'created_date' => DB::raw( 'NOW()' )
        );
        $this->profile->create( $profile );

        #customer
        $customer = array(
            'user_id' => $user->id, 'heir_name'=>$input['heir_name'],
            'heir_contact_num' => $input['heir_contact_num'],
            'bank_account' => $input['bank_account'],
            'account_num' => $input['account_num']
        );
        $this->customer->create($customer);

        #downline
        $downline = array( 'upline_user_id' => Auth::user()->id,
            'downline_user_id' =>  $user->id
        );
        return $this->downline->create( $downline );
    }


    public function paginateUsers( $page, $per_page, $user_id ) #DONE
    {
        $page = ( $page - 1 ) * $per_page;
        $users = DB::select("
                SELECT
                    u.id, u.username, u.`status`, u.groups, u.last_login,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, p.created_date as appointed_date, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num, d.*,
                    upline.username upline_username,
                    upline_profiles.full_name upline_fullname
                FROM users u
                INNER JOIN profiles p
                        On u.id = p.user_id
                INNER JOIN customers c
                        ON u.id = c.user_id
                INNER JOIN downlines d
                        ON u.id = d.downline_user_id
                INNER JOIN users upline
                        ON d.upline_user_id = upline.id
                INNER JOIN `profiles` upline_profiles
                        ON d.upline_user_id = upline_profiles.user_id
                WHERE d.upline_user_id = ? AND u.deleted IS NULL
                ORDER BY u.id
                LIMIT ?,?", [ $user_id, $page, $per_page ]
        );

        return Paginator::make( $users, $this->getUserCount( $user_id ),
            $per_page
        );
    }


    public function findCustomer( $id ) #DONE
    {

        return DB::select('
                SELECT
                    u.id, u.username, u.`status`,u.deleted,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, p.created_date as appointed_date, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num
                FROM users u
                INNER JOIN profiles p
                    On u.id = p.user_id
                INNER JOIN customers c
                    ON u.id = c.user_id
                WHERE u.id = ? and u.deleted is  null', [ $id ]
        );
    }


    public function updateUser( $input )
    {
        $this->updateProfile( $input );

        $this->customer->where( 'user_id', '=', $input['id'] )->update( array(
                'heir_name' => $input['heir_name'],
                'heir_contact_num' => $input['heir_contact_num'],
                'bank_account' => $input['bank_account'],
                'account_num' => $input['account_num']
            )
        );

        $user = $this->user->find( $input['id'] );
        $user->status = $input['status'];
        return $user->save();
    }

    public function mandatoryPicture()
    {
        $this->rules['picture'] = 'sometimes|required|mimes:png,jpg,jpeg';
    }


    protected  function getUserCount( $user_id = null ) #DONE
    {
        $result = DB::select('
                    SELECT count(*) as total
                    FROM users u
                    INNER JOIN downlines d
                      ON u.id = d.downline_user_id
                    WHERE d.upline_user_id = ? and u.deleted is null',
            [ $user_id ]
        );

        return $result[0]->total;
    }


}