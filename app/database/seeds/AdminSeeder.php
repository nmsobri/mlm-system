<?php

use Mlm\Eloquents\User;
use Mlm\Eloquents\Profile;
use Mlm\Eloquents\Admin;

class AdminSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array( 'username' => 'admin', 'password' => Hash::make( 123456 ),
                'status'=>'active', 'groups'=>'super_admin'
            )
        );

        $profiles = array(
            array( 'user_id'=> 1, 'full_name'=>'Administrator',
                'email' => 'admin@mlm.dev',
                'ic_num'=>'880260075621', 'gender'=>'male',
                'contact_num'=>'0174912490','created_date'=> DB::raw( 'NOW()' )
            )
        );

        $admins = array(
            array( 'user_id' => 1, 'admin_id'=>1 )
        );


        for( $x = 0; $x < 1; $x++ ) {
            User::create( $users[$x] );
            Profile::create( $profiles[$x] );
            Admin::create($admins[$x]);
        }


    }

}
