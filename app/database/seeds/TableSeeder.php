<?php

use Mlm\Eloquents\User;
use Mlm\Eloquents\Profile;
use Mlm\Eloquents\Admin;
use Mlm\Eloquents\Customer;
use Mlm\Eloquents\Downline;

class TableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = null;
        $users = array(
            array( 'username' => 'admin', 'password' => Hash::make( 123456 ),
                'status'=>'active', 'groups'=>'super_admin'
            ),
            array( 'username' => 'admin2', 'password' => Hash::make( 123456 ),
                'status'=>'active', 'groups'=>'super_admin'
            ),
            array( 'username' => 'admin3', 'password' => Hash::make( 123456 ),
                'status'=>'active', 'groups'=>'regular_admin'
            ),
            array( 'username' => 'admin4', 'password' => Hash::make( 123456 ),
                'status'=>'active', 'groups'=>'regular_admin'
            )
        );

        $profiles = array(
            array( 'user_id'=> 1, 'full_name'=>'Administrator',
                'ic_num'=>'880260075621', 'gender'=>'male',
                'contact_num'=>'0174912490','created_date'=> DB::raw( 'NOW()' )
            ),
            array( 'user_id'=> 2, 'full_name'=>'Administrator2',
                'ic_num'=>'990260075640', 'gender'=>'female',
                'contact_num'=>'0164912476','created_date'=> DB::raw( 'NOW()' )
            ),
            array( 'user_id'=> 3, 'full_name'=>'Administrator3',
                'ic_num'=>'780260075640', 'gender'=>'male',
                'contact_num'=>'0134912488','created_date'=> DB::raw( 'NOW()' )
            ),
            array( 'user_id'=> 4, 'full_name'=>'Administrator4',
                'ic_num'=>'840260075640', 'gender'=>'female',
                'contact_num'=>'0124912499','created_date'=> DB::raw( 'NOW()' )
            )
        );

        $admins = array(
            array( 'user_id' => 1, 'admin_id'=>1 ),
            array( 'user_id' => 2, 'admin_id'=>2 ),
            array( 'user_id' => 3, 'admin_id'=>3 ),
            array( 'user_id' => 4, 'admin_id'=>4 )
        );


        for( $x = 0; $x < 4; $x++ ) {
            User::create( $users[$x] );
            Profile::create( $profiles[$x] );
            Admin::create($admins[$x]);
        }


        #######################################################################
        ##############################Random Data##############################
        #######################################################################

        $status = array( 'active', 'inactive' );
        $groups = array( 'super_admin', 'regular_admin' );
        $genders = array('male', 'female');
        $adminss = array( 1, 2 );
        $banks = array( 'afb','alb','rhb','amb','hlb','pbb','cim','myb' );
        $ultimate_uplines = array( 3,4 );
        $regular_uplines = range( 301, 330 );

        $faker = Faker\Factory::create();


        #table users
        foreach ( range( 1, 296 ) as $v ) {
            User::create(
                array( 'username' => $faker->unique()->userName,
                    'password' => Hash::make( 123456 ),
                    'status' => $status[array_rand( $status, 1 )],
                    'groups' => $groups[array_rand( $groups, 1 )]
                )
            );
        }


        #table profiles
        foreach ( range( 5, 300 ) as $w ) {
            Profile::create(

                array( 'user_id'=> $w, 'full_name' => $faker->name,
                    'ic_num'=>$faker->ean13,
                    'gender'=> $genders[ array_rand( $genders, 1 ) ],
                    'contact_num'=>$faker->phoneNumber,
                    'created_date'=> $faker->dateTimeBetween(
                        $startDate = '-3 years', $endDate = 'now'
                    )
                )

            );
        }


        #table admins
        foreach ( range( 5, 300 ) as $x ) {
            Admin::create(
                array( 'user_id'=> $x,
                    'admin_id' => $adminss[array_rand( $adminss, 1)]
                )
            );
        }




        #######################################################################
        ###################Data to test ultimate user##########################
        #######################################################################

        #table users
        foreach ( range( 1, 30 ) as $a ) {
            User::create(
                array( 'username' => $faker->unique()->userName,
                    'password' => Hash::make( 123456 ),
                    'status' => $status[array_rand( $status, 1 )],
                    'groups' => 'ultimate_user'
                )
            );
        }


        #table profiles
        foreach ( range( 301, 330 ) as $b ) {
            Profile::create(

                array( 'user_id'=> $b, 'full_name' => $faker->name,
                    'ic_num'=>$faker->ean13,
                    'gender'=> $genders[ array_rand( $genders, 1 ) ],
                    'contact_num'=>$faker->phoneNumber,
                    'created_date'=> $faker->dateTimeBetween(
                        $startDate = '-3 years', $endDate = 'now'
                    )
                )
            );
        }


        #table customer
        foreach ( range( 301, 330 ) as $c ) {
            Customer::create(
                array( 'user_id'=> $c, 'heir_name' => $faker->name,
                    'heir_contact_num'=>$faker->phoneNumber,
                    'bank_account'=> $banks[ array_rand( $banks, 1 ) ],
                    'account_num'=>$faker->ean13
                )
            );
        }


        #table downline
        foreach ( range( 301, 330 ) as $d ) {
            Downline::create(
                array( 'upline_user_id'=> $ultimate_uplines[array_rand( $ultimate_uplines, 1 ) ],
                    'downline_user_id' => $d
                )
            );
        }


        #######################################################################
        ####################Data to test regular user##########################
        #######################################################################

        #table users
        foreach ( range( 1, 300 ) as $e ) {
            User::create(
                array( 'username' => $faker->unique()->userName,
                    'password' => Hash::make( 123456 ),
                    'status' => $status[array_rand( $status, 1 )],
                    'groups' => 'regular_user'
                )
            );
        }


        #table profiles
        foreach ( range( 331, 630 ) as $f ) {
            Profile::create(

                array( 'user_id'=> $f, 'full_name' => $faker->name,
                    'ic_num'=>$faker->ean13,
                    'gender'=> $genders[ array_rand( $genders, 1 ) ],
                    'contact_num'=>$faker->phoneNumber,
                    'created_date'=> $faker->dateTimeBetween(
                        $startDate = '-3 years', $endDate = 'now'
                    )
                )
            );
        }


        #table customer
        foreach ( range( 331, 630 ) as $g ) {
            Customer::create(
                array( 'user_id'=> $g, 'heir_name' => $faker->name,
                    'heir_contact_num'=>$faker->phoneNumber,
                    'bank_account'=> $banks[ array_rand( $banks, 1 ) ],
                    'account_num'=>$faker->ean13
                )
            );
        }


        #table downline
        foreach ( range( 331, 630 ) as $d ) {
            Downline::create(
                array( 'upline_user_id'=> $regular_uplines[array_rand( $regular_uplines, 1 ) ],
                    'downline_user_id' => $d
                )
            );
        }

    }

}
