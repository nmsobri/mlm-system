<?php

namespace Mlm\Repositories;

use DB;
use Auth;
use Hash;
use File;
use Config;
use Paginator;
use Mlm\Eloquents\User;
use Mlm\Eloquents\Profile;
use Mlm\Eloquents\Customer;
use Mlm\Eloquents\Downline;
use Mlm\Interfaces\UserInterface;

class UltimateUserRepository implements UserInterface
{
    protected $user     = null;
    protected $profile  = null;
    protected $customer = null;
    protected $downline = null;

    protected $rules = array(
        'username' => 'required|min:4|alpha_dash|unique:users,username',
        'password' => 'sometimes|required|min:6',
        'password_confirm' => 'sometimes|required|same:password',
        'full_name'=>'sometimes|required|alpha_spaces','gender'=>'required',
        'email' => 'sometimes|required|email',
        'ic_num'=>'required|unique:profiles,ic_num|digits:12',
        'contact_num'=>'sometimes|required|digits_between:8,14',
        'heir_name'=> 'sometimes|required|alpha_spaces',
        'heir_contact_num' => 'sometimes|required|digits_between:8,14',
        'bank_account' => 'sometimes|required', 'status' => 'sometimes|required',
        'account_num' => 'sometimes|required|digits_between:8,18',
        'picture' => 'sometimes|mimes:png,jpg,jpeg'
    );

    public function __construct( User $user, Profile $profile,
                                 Customer $customer, Downline $downline )
    {
        $this->user     = $user;
        $this->profile  = $profile;
        $this->customer = $customer;
        $this->downline = $downline;
    }


    public function find( $id ) #DONE
    {
        return DB::select('
                SELECT
                    u.id, u.username,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num
                FROM users u
                INNER JOIN profiles p On u.id = p.user_id
                INNER JOIN customers c ON u.id = c.user_id
                WHERE u.id = ? and u.deleted IS NULL', [$id]
        );
    }


    public function getValidator()
    {
        return $this->user->getValidator();
    }


    public function validate( $input )
    {
        $this->setupValidationRules( $input );
        return $this->user->validate( $input, $this->rules );
    }


    public function updateUserProfile( $input ) #done
    {
        #profiles
        $this->updateProfile( $input );

        #customers
        $this->customer->where( 'user_id', '=', $input['id'] )->update( array(
                'heir_name' => $input['heir_name'],
                'heir_contact_num' => $input['heir_contact_num'],
                'bank_account' => $input['bank_account'],
                'account_num' => $input['account_num']
            )
        );

        #users
        $user = $this->user->find( $input['id'] )->whereNull( 'deleted' )
            ->getModel();

        $user->username = $input['username'];

        if( !empty( $input['password'] ) ) {
            $user->password = Hash::make( $input['password'] );
        }
        return $user->save();
    }


    public function updateLastLogin()
    {
        $user = $this->user->find( Auth::user()->id )->whereNull( 'deleted' )
            ->getModel();

        $user->last_login = DB::raw( 'NOW()' );
        $user->save();
    }


    public function createUser( $input )
    {
        #user
        $user = array( 'username' => $input['username'],
            'password' => Hash::make( $input['password'] ),
            'status' => $input['status'], 'groups' => 'regular_user'
        );
        $user = $this->user->create( $user );

        #profile
        $profile = array( 'user_id' => $user->id,
            'full_name' => $input['full_name'], 'email'=>$input['email'],
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
        $this->customer->create( $customer );

        #downline
        $downline = array( 'upline_user_id' => Auth::user()->id,
            'downline_user_id' =>  $user->id
        );
        $this->downline->create( $downline );

        return $user;
    }


    public function paginateUsers( $page, $per_page, $user_id ) #DONE
    {
        $page = ( $page - 1 ) * $per_page;
        $users = DB::select('
                SELECT
                    u.id, u.username, u.`status`, u.groups, u.last_login,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, p.created_date as appointed_date, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num, d.*,
                    upline.username upline_username,
                    upline_profiles.full_name upline_fullname
                FROM users u INNER JOIN profiles p On u.id = p.user_id
                INNER JOIN customers c ON u.id = c.user_id
                INNER JOIN downlines d ON u.id = d.downline_user_id
                INNER JOIN users upline ON d.upline_user_id = upline.id
                INNER JOIN `profiles` upline_profiles
                ON d.upline_user_id = upline_profiles.user_id
                WHERE d.upline_user_id = ? and u.deleted IS NULL
                ORDER BY u.id
                LIMIT ?,?', [ $user_id, $page, $per_page ]
        );

        return Paginator::make( $users, $this->getUserCount( $user_id ),
            $per_page
        );
    }


    public function findCustomer( $id ) #DONE
    {
        return DB::select('
                SELECT
                    u.id, u.username, u.`status`,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, p.created_date as appointed_date, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num
                FROM users u
                INNER JOIN profiles p
                    On u.id = p.user_id
                INNER JOIN customers c
                    ON u.id = c.user_id
                WHERE u.id = ? AND u.deleted IS NULL', [ $id ]
        );
    }


    public function updateUser( $input ) #DONE
    {
        $this->updateProfile( $input );

        $this->customer->where( 'user_id', '=', $input['id'] )->update( array(
                'heir_name' => $input['heir_name'],
                'heir_contact_num' => $input['heir_contact_num'],
                'bank_account' => $input['bank_account'],
                'account_num' => $input['account_num']
            )
        );

        $user = $this->user->find( $input['id'] )
            ->whereNull( 'deleted' )->getModel();

        $user->status = $input['status'];
        return $user->save();
    }


    public function deleteUser( $id )
    {
        return DB::transaction( function() use ( $id ) {

            Db::table( 'users' )->where( 'id', $id )
                ->update( ['deleted'=>DB::raw('NOW()')] );

            Db::table( 'admins' )->where( 'user_id', $id )
                ->orWhere('admin_id', $id)
                ->update( ['deleted'=>DB::raw('NOW()')] );

            Db::table( 'customers' )->where( 'user_id', $id )
                ->update( ['deleted'=>DB::raw('NOW()')] );

            Db::table( 'downlines' )->where( 'upline_user_id', $id )
                ->orWhere( 'downline_user_id', $id)
                ->update( ['deleted'=>DB::raw( 'NOW()' )] );

            Db::table( 'profiles' )->where( 'user_id', $id )
                ->update( ['deleted'=>DB::raw( 'NOW()' )] );

            Db::table( 'transactions' )->where( 'requestor_id', $id )
                ->update( ['deleted'=>DB::raw( 'NOW()' )] );

            return true;
        });
    }


    public function isMaxDownline( $id ) #DONE
    {
        return DB::select("
                SELECT ( count(*) >= ? ) status
                FROM downlines d
                WHERE d.upline_user_id = ? AND d.deleted IS NULL",
            [ Config::get( 'mlm.regular_user_max_downline' ), $id ]
        )[0]->status;
    }


    public function addUplinesPoint( $user ) #DONE
    {
        $uplines = '';
        $upline_list = $this->findUplines( $user->id );

        foreach ( $upline_list as $upline ) {
            $uplines .= $upline->upline_user . ',';
        }
        $uplines = rtrim( $uplines, ',' );

        DB::update(
            "UPDATE customers SET point = point + ?
                WHERE user_id IN({$uplines})",
            array( Config::get( 'mlm.point_for_upline' ) )
        );

        if ( count( $upline_list ) <
            Config::get( 'mlm.regular_user_max_downline' ) )
        {
            DB::update(
                "UPDATE customers SET point = point + ?
                WHERE user_id = ?",
                array(
                    Config::get( 'mlm.point_for_company' ),
                    Config::get( 'mlm.system_id' )
                )
            );
        }
    }


    public function findUplines( $id ) #DONE
    {
        return DB::select("
                SELECT * from
                (
                    SELECT
                    @start AS downline_user,
                    ( SELECT @start := upline_user_id FROM
                        (
                            SELECT d.* from downlines d
                            INNER JOIN users u
                            ON d.upline_user_id = u.id AND
                            u.groups IN( 'ultimate_user', 'regular_user' )
                            AND d.deleted IS NULL
                        ) v1
                        WHERE v1.downline_user_id = downline_user
                    ) upline_user,
                    @lvl := @lvl + 1 AS lvl
                    FROM
                        (
                            SELECT v2.*, v3.upline_user_id, v3.downline_user_id
                            FROM ( SELECT @start := ?, @lvl := 0 ) v2,
                            (
                                SELECT d2.* from downlines d2
                                INNER JOIN users u2
                                ON d2.upline_user_id = u2.id AND
                                u2.groups IN( 'ultimate_user', 'regular_user' )
                                WHERE upline_user_id < @start
                            ) v3
                        ) v4
                ) v5
                WHERE v5.upline_user IS NOT NULL", [ $id ]
        );
    }


    public function mandatoryPicture()
    {
        $this->rules['picture'] = 'sometimes|required|mimes:png,jpg,jpeg';
    }


    protected function updateProfile( $input )
    {
        $img = null;
        if ( isset( $input['picture'] ) ) {
            $img = $this->saveUserImage( $input );
        }

        $profile = $this->profile->find($input['id']);
        $profile->full_name = $input['full_name'];
        $profile->ic_num = $input['ic_num'];
        $profile->gender = $input['gender'];
        $profile->contact_num = $input['contact_num'];
        $profile->picture = isset( $input['picture'] ) ? $img : $profile->picture;
        $profile->save();
    }


    protected function saveUserImage( $input )
    {
        File::delete( Config::get( 'mlm.user_directory' )
            . $input['old_picture']
        );

        $file = $input['picture'];
        $filename = $this->generateUniqueFileName( $input[ 'picture'] );
        $file->move( Config::get( 'mlm.user_directory' ), $filename );
        return $filename;
    }


    protected function generateUniqueFileName( $file, $length = 20 )
    {
        $name = '';
        $ext = $file->guessExtension();
        $keys = array_merge( range( 0, 9 ), range( 'a', 'z' ) );
        for ( $i = 0; $i < $length; $i++ ) {
            $name .= $keys[array_rand($keys)];
        }
        return $name . '.' . $ext;
    }


    protected function setupValidationRules( $input )
    {
        if ( isset( $input['id'] ) ) {
            $this->rules['username'] = 'required|min:4|alpha_dash|
                                        unique:users,username,' . $input['id'];

            $this->rules['ic_num'] = 'required|digits:12|unique:profiles,ic_num,'
                . $input['id'] . ',user_id';

            if ( empty( $input['password'] ) ) {
                $this->rules['password'] = '';
                $this->rules['password_confirm'] = '';
            }
        }
    }


    protected function getUserCount( $user_id = null ) #DONE
    {
        return DB::select('
                    SELECT count(*) as total
                    FROM users u
                    INNER JOIN downlines d
                      ON u.id = d.downline_user_id
                    WHERE d.upline_user_id = ? AND u.deleted IS NULL',
                    [ $user_id ]
        )[0]->total;
    }



}