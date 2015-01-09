<?php

use Illuminate\Database\Migrations\Migration;

class ChangeBankAccountEnumTblCustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = "USE `mlm`;
		    ALTER TABLE `customers`
            MODIFY COLUMN `bank_account`  enum('afb','alb','rhb','amb','hlb','pbb','cim','myb') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `heir_contact_num`;";
        DB::unprepared( $sql );
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$sql = "USE `mlm`;
		        ALTER TABLE `customers`
                MODIFY COLUMN `bank_account`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `heir_contact_num`;";
        DB::unprepared( $sql );
	}

}
