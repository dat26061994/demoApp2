<?php

namespace Tests\Feature;

use App\Admin;
use App\Member;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testLoginAdmin()
    {
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin)->get('/admin')->assertStatus(200);
    }


    public function testGetListMember()
    {
        $member = factory(User::class)->create();
        $response = $this->actingAs($member)->get('admin/list');
        $response->assertStatus(200);
    }

    public function testAddNewMember()
    {
        $user = factory(User::class)->create();
        $data = [
            'name' => 'Trinh Xuan Dat',
            'age' => '23',
            'address' => 'Bac Giang',
        ];
        $response = $this->actingAs($user)->call('POST', 'admin/add', $data);
        $this->assertDatabaseHas('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address'],
        ]);
    }
    

    public function testExample()
    {
        $this->assertTrue(true);
    }
}
