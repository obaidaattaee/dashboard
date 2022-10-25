<?php

use App\Models\InvoiceSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalesStatusColumnToInvoiceSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_subscription', function (Blueprint $table) {
            $table->tinyInteger('sales_status')->after('expiration_date')->default(InvoiceSubscription::STATUSES[0]['id']);
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
            $table->dropColumn(['sales_status']);
        });
    }
}
