<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

//        Improve with Eloquent
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        echo $user->name . '<hr />';

        $user = User::firstOrNew(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        echo $user->name . '<hr />';

        $user = User::updateOrCreate(
            ['email' => 'another@example.com'],
            [
                'name' => 'User was updated',
                'password' => bcrypt('password')
            ]
        );

        echo $user->id. ' '. $user->name . '<hr />';

        User::upsert([
            ['email' => 'test@example.com', 'name' => 'Test User', 'password' => bcrypt('password')],
            ['email' => 'another@example.com', 'name' => 'Another User', 'password' => bcrypt('password')],
        ], ['email'], ['name', 'password']);

    }

    public function changed()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        echo $user->wasRecentlyCreated ? 'Created' : 'Found'; // Created

        //isDirty
        $user->name = 'Changed';
        echo $user->isDirty() ? 'Edited' : 'Not edited'; // Edited
        echo '<hr />';
        echo $user->isDirty('name') ? 'Edited' : 'Not edited'; // Edited
        echo '<hr />';
        echo $user->isDirty('email') ? 'Edited' : 'Not edited'; // Not edited
        echo '<hr />';

        //WasChange
        $user->name = 'Abraham';
        echo $user->wasChanged() ? 'Changed' : 'Not changed'; // Not changed
        $user->save();

        echo $user->wasChanged() ? 'Changed' : 'Not changed'; // Changed
        echo $user->wasChanged('name') ? 'Name Changed' : 'Not changed'; // Name Changed
        echo $user->wasChanged('email') ? 'Email Changed' : 'Not changed'; // Not changed



//        echo $user->getOriginal('name'); // Test User
//        echo '<hr />';
//        echo $user->getOriginal('email'); // test@example.com
//        echo '<hr />';
//        echo $user->getOriginal(); // Array ( [name] => Test User [email] => test@example.com [password] => $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi [remember_token] => [created_at] => 2023-03-13 12:00:00 [updated_at] => 2023-03-13 12:00:00 )
//        echo '<hr />';
//        echo $user->getOriginal('name'); // Test User
//        echo '<hr />';
//        echo $user->getOriginal('email'); // test@example.com
//        echo '<hr />';
//        echo $user->getOriginal(); // Array ( [name] => Test User [email] => test@example.com [password] => $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi [remember_token] => [created_at] => 2023-03-13 12:00:00 [updated_at] => 2023-03-13 12:00:00 )

    }
}
