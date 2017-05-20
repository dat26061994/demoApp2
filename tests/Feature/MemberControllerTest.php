<?php

namespace Tests\Feature;

use App\Admin;
use App\Member;
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
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin)->get('admin/list');
        $response->assertStatus(200);
    }

    public function testAddNewMember()
    {
        $data = [
            'name' => 'Trinh Xuan Dat',
            'age' => '23',
            'address' => 'Bac Giang',
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertDatabaseHas('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address'],
        ]);
        $response->assertStatus(200);
    }

    public function testAddWithName99Character()
    {
        $dataAdd = [
            'name' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl',
            'age' => '23',
            'address' => 'Ha Noi'
        ];
        $response = $this->call('POST', 'admin/add', $dataAdd);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataAdd['name'],
            'age' => $dataAdd['age'],
            'address' => $dataAdd['address']
        ]);
    }

    public function testAddWithName100Character()
    {
        $dataAdd = [
            'name' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkla',
            'age' => '23',
            'address' => 'Ha Noi'
        ];
        $response = $this->call('POST', 'admin/add', $dataAdd);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataAdd['name'],
            'age' => $dataAdd['age'],
            'address' => $dataAdd['address']
        ]);
    }

    public function testAddWithAddress299Character()
    {
        $dataAdd = [
            'name' => 'test',
            'age' => '23',
            'address' => 'asdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjkl'
        ];
        $response = $this->call('POST', 'admin/add', $dataAdd);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataAdd['name'],
            'age' => $dataAdd['age'],
            'address' => $dataAdd['address']
        ]);
    }

    public function testAddWithAddress300Character()
    {
        $dataAdd = [
            'name' => 'test',
            'age' => '23',
            'address' => 'asdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjklaasdfghjkla'
        ];
        $response = $this->call('POST', 'admin/add', $dataAdd);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataAdd['name'],
            'age' => $dataAdd['age'],
            'address' => $dataAdd['address']
        ]);
    }

    public function testGetEditMember()
    {
        $admin = factory(Admin::class)->create();
        $member = factory(Member::class)->create();
        $response = $this->call('GET', 'admin/edit/' . $member->id);
        $response->assertStatus(200);
    }

    public function testPostEditMember()
    {
        $member = factory(Member::class)->create([
            'name' => 'Xuan Dat',
            'age' => '23',
            'address' => 'BG'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'name' => 'Xuan Tien',
            'age' => '12',
            'address' => 'Tho Ha Bac Giang'
        ];

        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testPostEdit99CharacterName()
    {
        $member = factory(Member::class)->create([
            'name' => 'Xuan Dat',
            'age' => '23',
            'address' => 'BG'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'name' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl',
            'age' => '12',
            'address' => 'Tho Ha Bac Giang'
        ];

        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testPostEdit100CharacterName()
    {
        $member = factory(Member::class)->create([
            'name' => 'Xuan Dat',
            'age' => '23',
            'address' => 'BG'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'name' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkla',
            'age' => '12',
            'address' => 'Tho Ha Bac Giang'
        ];

        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testPostEdit299CharacterAddress()
    {
        $member = factory(Member::class)->create([
            'name' => 'Xuan Dat',
            'age' => '23',
            'address' => 'BG'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'name' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl',
            'age' => '12',
            'address' => 'asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklaasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklaasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl'
        ];

        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testPostEdit300CharacterAddress()
    {
        $member = factory(Member::class)->create([
            'name' => 'Xuan Dat',
            'age' => '23',
            'address' => 'BG'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'name' => 'sdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl',
            'age' => '12',
            'address' => 'aasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklaasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklaasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl'
        ];

        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testDeleteMember()
    {
        $member = factory(Member::class)->create([
            'name' => 'Dat',
            'age' => '23',
            'address' => 'aklsdjfas'
        ]);
        $memberID = $member->id;
        $response = $this->call('GET', 'admin/delete/' . $memberID);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => 'Dat',
            'age' => '23',
            'address' => 'aklsdjfas'
        ]);

    }

    public function testDeleteAvatarMember()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.png'),
            '1.png', 'image/png', 111, $error = null, $test = true);
        $member = factory(Member::class)->create([
            'avatar' => $avatar,
            'name' => 'asdfasdf',
            'age' => '23',
            'address' => 'Ha Noi'
        ]);
        $memberId = $member->id;
        $response = $this->call('GET', 'admin/delete/' . $memberId);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => 'afsfsaf',
            'age' => '23',
            'address' => 'Bac Ninh'
        ]);
    }

    public function testAddImageLessThan10MB()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.png'),
            '1.png', 'image/png', 10485760, $error = null, $test = true);
        $dataAdd = [
            'avatar' => $avatar,
            'name' => 'Duy',
            'age' => '12',
            'address' => 'THo Ha'
        ];

        $response = $this->call('POST', 'admin/add', $dataAdd);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataAdd['name'],
            'age' => $dataAdd['age'],
            'address' => $dataAdd['address']
        ]);
    }

    public function testEditImageLessThan10MB()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.png'),
            '1.png', 'image/png', 10485760, $error = null, $test = true);
        $member = factory(Member::class)->create([
            'avatar' => '1.png',
            'name' => 'Loi',
            'age' => '26',
            'address' => 'ksjflkajlkf'
        ]);
        $memberId = $member->id;
        $dataEdit = [
            'avatar' => $avatar,
            'name' => 'Manh',
            'age' => '15',
            'address' => 'Bac Ninh'
        ];
        $response = $this->call('POST', 'admin/edit/' . $memberId, $dataEdit);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $dataEdit['name'],
            'age' => $dataEdit['age'],
            'address' => $dataEdit['address']
        ]);
    }

    public function testAddImageJpg()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            '1.jpg', 'image/jpg', 10485760, $error = null, $test = true);
        $data = [
            'avatar' => $avatar,
            'name' => 'BAo Li',
            'age' => '14',
            'address' => 'asdfkjaskdfjl'
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddImagePng()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.png'),
            '1.png', 'image/png', 10485760, $error = null, $test = true);
        $data = [
            'avatar' => $avatar,
            'name' => 'BAo Li',
            'age' => '14',
            'address' => 'asdfkjaskdfjl'
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }

    public function testAddImageGif()
    {
        $avatar = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('upload\1.jpg'),
            '1.gif', 'image/gif', 10485760, $error = null, $test = true);
        $data = [
            'avatar' => $avatar,
            'name' => 'BAo Li',
            'age' => '14',
            'address' => 'asdfkjaskdfjl'
        ];
        $response = $this->call('POST', 'admin/add', $data);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $data['name'],
            'age' => $data['age'],
            'address' => $data['address']
        ]);
    }


}
