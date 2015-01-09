<?php

namespace Mlm\Repositories;

use DB;
use Hash;
use Auth;
use File;
use Config;
use Session;
use Paginator;
use Mlm\Eloquents\User;
use Mlm\Eloquents\Admin;
use Mlm\Eloquents\Profile;
use Mlm\Eloquents\Customer;
use Mlm\Libs\File\MlmConfig;
use Illuminate\Filesystem\Filesystem;
use Mlm\Interfaces\AdminInterface;

class SuperAdminRepository implements AdminInterface
{
    protected $user     = null;
    protected $profile  = null;
    protected $admin    = null;
    protected $customer = null;

    protected $rules = array(
        'username' => 'sometimes|required|min:4|alpha_dash|unique:users,username',
        'password' => 'sometimes|required|min:6',
        'password_confirm' => 'sometimes|required|same:password',
        'status' => 'sometimes|required', 'groups'=>'sometimes|required',
        'full_name' => 'sometimes|required|alpha_spaces',
        'email' => 'sometimes|required|email', 'gender'=>'sometimes|required',
        'ic_num'=> 'sometimes|required|unique:profiles,ic_num|digits:12',
        'contact_num' => 'sometimes|required|digits_between:8,14',
        'picture'=> 'sometimes|mimes:png,jpg,jpeg',
        'system_name' => 'sometimes|required|alpha_spaces',
        'system_contact_num' => 'sometimes|required|digits_between:8,14',
        'system_bank_account' => 'sometimes|required',
        'system_account_num' => 'sometimes|required|digits_between:8,18'
    );

    public function __construct( User $user, Profile $profile, Admin $admin,
                                 Customer $customer )
    {
        $this->user     = $user;
        $this->profile  = $profile;
        $this->admin    = $admin;
        $this->customer = $customer;
    }


    public function validate( $input )
    {
        $this->setupValidationRules( $input );
        return $this->user->validate( $input, $this->rules );
    }


    public function getValidator()
    {
        return $this->user->getValidator();
    }


    public function createUser( $input )
    {
        $user = array( 'username' => $input['username'],
            'password' => Hash::make( $input['password'] ),
            'status' => $input['status'], 'groups' => $input['groups']
        );

        $user = $this->user->create( $user );

        $profile = array( 'user_id' => $user->id,
            'full_name' => $input['full_name'], 'email' => $input['email'],
            'ic_num' => $input['ic_num'],'gender' => $input['gender'],
            'contact_num'=> $input['contact_num'],
            'created_date' => DB::raw( 'NOW()' )
        );

        $this->profile->create( $profile );

        $admin = array( 'user_id' => $user->id, 'admin_id' => Auth::user()->id );
        return $this->admin->create( $admin );
    }


    public function generateUsername()
    {
        $prefix = 'user_';
        $uuid = DB::select('select substring( uuid(), 1, 6 ) as uuid');
        return $prefix . $uuid[0]->uuid;

    }


    public function paginateUsers( $page, $per_page, $user_id ) #DONE
    {

        $page = ( $page - 1 ) * $per_page;
        $users = DB::select('
                    SELECT d.*, au.username as super_admin_username,
                    ap.full_name as super_admin_fullname
                    FROM
                    (
                        SELECT
                                u.id, u.username, u.`status`, u.groups, u.last_login,
                                p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                                p.picture, p.created_date AS appointed_date, a.admin_id
                        FROM users u
                        INNER JOIN `profiles` p ON u.id = p.user_id
                        LEFT JOIN admins a ON u.id = a.user_id
                        WHERE u.deleted IS NULL
                    ) d

                    LEFT JOIN users au ON au.id = d.admin_id
                    LEFT JOIN `profiles` ap ON ap.user_id = au.id
                    WHERE d.id <> ?
                    ORDER BY d.id
                    LIMIT ?,?', [ $user_id, $page, $per_page ]
        );

        return Paginator::make( $users, $this->getUserCount( $user_id ), $per_page );
    }


    public function find( $id ) #DONE
    {
        return DB::select('
            SELECT u.id, u.username, u.`status`, u.groups, p.user_id,
                    p.full_name, p.ic_num, p.gender, p.contact_num, p.picture
            FROM users u
            INNER JOIN `profiles` p ON u.id = p.user_id
            WHERE u.id = ? AND u.deleted IS NULL', [$id] );
    }


    public function updateUser( $input )
    {
        $this->updateProfile( $input );
        $user = $this->user->find( $input['id'] );
        $user->status = $input['status'];
        $user->groups = $input['groups'];
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


    public function updateUserProfile( $input )
    {
        $this->updateProfile( $input );

        $user = $this->user->find( $input['id'] );
        $user->username = $input['username'];

        if( !empty( $input['password'] ) ) {
            $user->password = Hash::make( $input['password'] );
        }

        return $user->save();
    }


    public function updateLastLogin()
    {
        $user = $this->user->find(Auth::user()->id);
        $user->last_login = DB::raw('NOW()');
        $user->save();
    }


    public function createSystemAccount( $input )
    {
        $conf = array( 'system_id' => Auth::user()->id,
            'system_user' => Auth::user()->username
        );

        $mlm_config = new MlmConfig( new Filesystem(), app_path(). '/config' );
        $mlm_config->save( $conf, 'mlm' );
        Session::flash( 'system_id', Auth::user()->id );

        return $this->customer->create( array( 'user_id' => Auth::user()->id,
                'heir_name' => $input['system_name'],
                'heir_contact_num' => $input['system_contact_num'],
                'bank_account' => $input['system_bank_account'],
                'account_num' => $input['system_account_num']
            )
        );
    }


    #to satisfy interface
    public function findCustomer( $id ){}


    public function mandatoryPicture()
    {
        $this->rules['picture'] = 'sometimes|required|mimes:png,jpg,jpeg';
    }


    protected function getUserCount( $user_id ) #DONE
    {
        return DB::select('
                    SELECT count(*) as count FROM users u WHERE u.id <> ?
                    AND u.deleted is null', [ $user_id ]
        )[0]->count;
    }


    protected function setupValidationRules( $input )
    {
        #ignore uniqueness for row when its value come from itself
        if ( isset( $input['id'] ) ) {
            $this->rules['username'] = 'required|min:4|alpha_dash|
                                        unique:users,username,' . $input['id'];

            $this->rules['ic_num'] = 'required|digits:12|unique:profiles,ic_num,'
                . $input['id'] . ',user_id';

            #make password rules optional when  updating profile
            if ( empty( $input['password'] ) ) {
                $this->rules['password'] = '';
                $this->rules['password_confirm'] = '';
            }
        }
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


}