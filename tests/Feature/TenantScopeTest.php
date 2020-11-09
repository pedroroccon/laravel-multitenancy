<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TenantScopeTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_model_has_a_tenant_id_on_the_migration()
    {
        $now = now();
        $this->artisan('make:model Test -m');

        // Procura o arquivo da migração e verificar se ele possui o campo tenant_id.
        $filename = Str::finish(now()->format('Y_m_d_His'), '_create_tests_table.php');
        $this->assertTrue(File::exists(database_path('migrations/' . $filename)));
        $this->assertStringContainsString('$table->unsignedBigInteger(\'tenant_id\')->index();', File::get(database_path('migrations/' . $filename)));

        // Limpando os arquivos.
        File::delete(database_path('migrations/' . $filename));
        File::delete(app_path('Models/Test.php'));
    }

    /** @test */
    public function a_user_only_can_see_users_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create(['tenant_id' => $tenant1]);

        // Adicionando usuários no tenant 1
        User::factory()->count(9)->create(['tenant_id' => $tenant1]);

        // Adicionando usuários no tenant 2
        User::factory()->count(10)->create(['tenant_id' => $tenant2]);

        // Nesse ponto, devemos ter 20 usuários na base de dados.
        $this->assertEquals(20, User::count());

        // Se estivermos logado com o primeiro usuário, então devemos
        // ver apenas 10 usuários cadastrados.
        auth()->login($user1);
        $this->assertEquals(10, User::count());
    }

    /** @test */
    public function a_user_can_only_create_a_user_in_his_tenant()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant]);

        // Logando com o usuário do tenant 1
        auth()->login($user);

        $newUser = User::factory()->create();
        $this->assertTrue($newUser->tenant_id == $user->tenant_id);
    }

    /** @test */
    public function a_user_can_only_create_a_user_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user = User::factory()->create(['tenant_id' => $tenant1]);

        // Logando com o usuário do tenant 1
        auth()->login($user);

        $newUser = User::factory()->make();

        // Aqui forçamos a mudança do tenant_id para validar 
        // se mesmo alterando, ele ainda irá respeitar o tenant_id
        // do usuário logado
        $newUser->tenant_id = $tenant2->id;
        $newUser->save();

        $this->assertTrue($newUser->tenant_id == $user->tenant_id);
    }
}
