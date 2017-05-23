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
            'age' => 'asdasd',
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
            'name' => 'asdfsadf',
            'age' => '23',
            'address' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
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
        $response = $this->call('POST', 'admin/edit/' . $memberId, $data);
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

    public function testAddImageMoreThan10MB()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            'abc.png', 'image/png', 12345678998745631, $error = null,
            $test = true);

        $data = [
            'avatar' => $avatar,
            'name' => 'Dat',
            'age' => '23',
            'address' => 'Bac Giang'
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'avatar' => $data['avatar'],
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);

    }

    public function testEditImageMoreThan10MB()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            'abc.png', 'image/png', 12345678998745631, $error = null,
            $test = true);
        $member = factory(Member::class)->create([
            'name' => 'adsfasdf',
            'age' => '11',
            'address' => 'Ha Noi'
        ]);
        $memberId = $member->id;
        $data = [
            'avatar' => $avatar,
            'name' => 'Dat',
            'age' => '23',
            'address' => 'Bac Giang'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId, $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'avatar' => $data['avatar'],
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddImageInvalid()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            'abc.txt', 'text/txt', 1234, $error = null,
            $test = true);

        $data = [
            'avatar' => $avatar,
            'name' => 'Dat',
            'age' => '23',
            'address' => 'Bac Giang'
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'avatar' => $data['avatar'],
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testEditImageInvalid()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            'abc.txt', 'text/txt', 1234, $error = null,
            $test = true);
        $member = factory(Member::class)->create([
            'name' => 'adsfasdf',
            'age' => '11',
            'address' => 'Ha Noi'
        ]);
        $memberId = $member->id;
        $data = [
            'avatar' => $avatar,
            'name' => 'Dat',
            'age' => '23',
            'address' => 'Bac Giang'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId, $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'avatar' => $data['avatar'],
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }
}
