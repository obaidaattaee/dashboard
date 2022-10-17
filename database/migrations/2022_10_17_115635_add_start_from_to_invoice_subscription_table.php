<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartFromToInvoiceSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_subscription', function (Blueprint $table) {
            $table->date('start_from')->after('duration')->nullable();
            $table->double('cost')->after('start_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_subscription', function (Blueprint $table) {
            $table->dropColumn(['start_from', 'cost']);
        });
    }
}
