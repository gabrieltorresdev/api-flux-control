<?php

namespace Database\Seeders;

use App\Persistence\Eloquent\Models\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserModel::factory(5)->create();
    }

    private function seedRelationExample()
    {
        /*DB::table('status_demandas')->insert([
            ['id' => 1, 'titulo' => 'A Fazer'],
            ['id' => 2, 'titulo' => 'Em Andamento'],
            ['id' => 3, 'titulo' => 'Concluída'],
        ]);

        $users = UserModel::factory(5)->create();

        $projetos = ProjetoModel::factory(5)->create();

        $sprints = SprintModel::factory(50)->create();

        foreach ($projetos as $projeto) {
            $projeto->sprints()->attach($sprints->random(random_int(1, 3)));
        }

        $demandas = DemandaModel::factory(50)
            ->state(function () use ($projetos, $sprints, $users) {
                $userResponsavel = [$users->random()->id, null];
                return [
                    'projeto_id' => $projetos->random()->id,
                    'sprint_id' => $sprints->random()->id,
                    'user_relator_id' => $users->random()->id,
                    'user_responsavel_id' => $userResponsavel[array_rand($userResponsavel)],
                ];
            })
            ->create();

        ComentarioDemandaModel::factory(500)
            ->state(function () use ($demandas) {
                return [
                    'demanda_id' => $demandas->random()->id,
                ];
            })
            ->create();*/
    }
}
