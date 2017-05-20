<?php

namespace Tests\Feature;

use App\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MissingMemberControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddEmptyName()
    {
        $data = [
            'name' => '',
            'age' => '23',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAdd101CharacterName()
    {
        $data = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'age' => '23',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddAlphabeticName()
    {
        $data = [
            'name' => '123',
            'age' => '23',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddEmptyAge()
    {
        $data = [
            'name' => 'asdasd',
            'age' => '',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAdd3DigitsAge()
    {
        $data = [
            'name' => 'asdasd',
            'age' => '123',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddNumbericAge()
    {
        $data = [
            'name' => 'asdasd',
            'age' => 'asdad',
            'address' => 'Ha Noi'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddEmptyAddress()
    {
        $data = [
            'name' => 'asdasd',
            'age' => '21',
            'address' => ''
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAdd301CharacterAddress()
    {
        $data = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'age' => '23',
            'address' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];

        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditEmptyName()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => '',
            'age' => '22',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEdit101CharacterName()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'age' => '22',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditAlphabeticName()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => '123',
            'age' => '22',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditEmptyAge()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'assafa',
            'age' => '',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEdit3DigitsAge()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'assafa',
            'age' => '123',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditNumbericAge()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'assafa',
            'age' => 'asdsad',
            'address' => 'asdfaffa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditEmptyAddress()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'asdfasdf',
            'age' => '22',
            'address' => ''
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEdit301CharacterAddress()
    {
        $member = factory(Member::class)->create([
            'name' => 'Ha HTu',
            'age' => '12',
            'address' => 'Ha Tay'
        ]);
        $memberId = $member->id;
        $data = [
            'name' => 'ajskldfjak',
            'age' => '22',
            'address' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId,$data);
        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }



}
