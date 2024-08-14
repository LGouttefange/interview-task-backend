<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('shipping_address_name')->default('');
            $table->string('shipping_address_street')->default('');
            $table->string('shipping_address_city')->default('');
            $table->string('shipping_address_zip')->default('');
            $table->string('billing_address_name')->default('');
            $table->string('billing_address_street')->default('');
            $table->string('billing_address_city')->default('');
            $table->string('billing_address_zip')->default('');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table
                ->dropColumn([
                    'shipping_address_name',
                    'shipping_address_street',
                    'shipping_address_city',
                    'shipping_address_zip',

                    'billing_address_name',
                    'billing_address_street',
                    'billing_address_city',
                    'billing_address_zip',
                ]);
        });
    }
};
