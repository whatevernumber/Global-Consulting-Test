<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    public function up(): void
    {
        //
        DB::table('users')->insert([
            [
                'email' => 'admin@test.ru',
                'name' => 'Администратор',
                'password' => Hash::make('test'),
                'admin' => true,
            ],
            [
                'email' => 'client@test.ru',
                'name' => 'Клиент',
                'password' => Hash::make('test'),
                'admin' => false,
            ]
        ]);


        DB::table('products')->insert(
            [
                 [
                    'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                    'article' => 'bot11',
                    'name' => '360 Vacuum Cleaner',
                    'status_id' => '1',
                    'data' => json_encode([
                        '0' => [
                            'type' => 'Цвет',
                            'value' => 'Красивый'
                        ],
                        '1' => [
                            'type' => 'Состояние',
                            'value' => 'Новый'
                        ],
                    ])
                 ],
                [
                    'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                    'article' => '2mdot',
                    'name' => 'MTOK-22-5',
                    'status_id' => '2',
                    'data' => json_encode([
                        '0' => [
                            'type' => 'Размер',
                            'value' => 'XS'
                        ],
                    ])
                ]
            ],
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::table('users')->truncate();
        DB::table('products')->truncate();
    }
};
