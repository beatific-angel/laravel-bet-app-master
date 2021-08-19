<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 1,
            'name' => 'App Client',
            'secret' => 'LB57hPHsByBQMDgZrb9mLyIVunKRbGRPXhn2cJwV',
            'redirect' => config('app.url'),
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('oauth_clients')->insert([
            'id' => 2,
            'name' => 'Laravel Password Grant Client',
            'secret' => 'Wndom6qn1Karx0fNpzqTbWJIrM4da5jaZ3gbzWCk',
            'redirect' => config('app.url'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
