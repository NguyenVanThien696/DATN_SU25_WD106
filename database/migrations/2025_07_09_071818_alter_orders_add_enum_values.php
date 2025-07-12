<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdersAddEnumValues extends Migration
{
public function up()
{
// Thay thế ENUM hiện tại bằng ENUM mới có thêm giá trị
DB::statement("ALTER TABLE orders MODIFY status ENUM(
'pending',
'confirmed',
'processing',
'completed',
'cancelled',
'cancelled_paid',
'refunded',
'delivery_failed'
) NOT NULL DEFAULT 'pending'");
}

public function down()
{
// Rollback lại ENUM cũ nếu cần
DB::statement("ALTER TABLE orders MODIFY status ENUM(
'pending',
'processing',
'completed',
'cancelled',
'cancelled_paid',
'refunded'
) NOT NULL DEFAULT 'pending'");
}
}