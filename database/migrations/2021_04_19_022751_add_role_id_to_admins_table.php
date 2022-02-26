<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            // $table->string('role_id')->after('password');
            $table->foreignId('role_id')->references('id')->on('roles')->onDelete('cascade')->after('password');


        });

        Admin::create([
            'name' => 'mohamed walid' ,
            'email' => 'm@gmail.com' ,
            'password' => Hash::make(111111)
        ]) ;

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
}
