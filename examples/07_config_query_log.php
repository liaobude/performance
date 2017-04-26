<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
require_once('helper/UseEloquent.php');
require_once('helper/user.php');

use Illuminate\Database\Capsule\Manager as DB;

use Performance\Performance;
use Performance\Config;

// Bootstrap class
$foo = new Foo();

class Foo
{
    public function __construct()
    {
        // Enable query log
        Config::setQueryLog(true);
        // OR
//        Config::setQueryLog(true, 'full');

        $this->runQuerys();

        // Finish all tasks and show test results
        Performance::results();
    }

    public function runQuerys()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        // Create user
        $user = new User();
        $user->name = 'User';
        $user->save();

        // Get users
        $users = User::all();

        // Update user
        $user = User::where('name', 'User')->first();
        $user->email = 'user@user.user';
        $user->save();

        // Delete all
        $users = DB::table('user')->select('*')
            ->where('name', 'User')
            ->delete();

        // Finish point Task A
        Performance::finish();
    }
}