<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('tasks');
            $table->string('reward');
            $table->timestamps();
            $table->softDeletes();
        });

        $roles = [
            [
                'name'=>'Vanguard',
                'description' => 'The Vanguard is the public leader of the team. When it comes to keeping morale up and team spirit high, this is your person.',
                'tasks' => "[1] Organize and complete all team devotions. |[2] Promote team spirit and maintain peace among recruits.",
                'reward' => "One hot pizza"
             ],

            [
                'name'=>'Gamemaster',
                'description' => 'The Gamemaster will lead the recruits into battle. This position requires one who can be decisive and commit to those decisions made.',
                'tasks' => "[1] Lead the team during the challenges. |[2] Coordinate free time challenge participation.",
                'reward' => 'Thirty minute gaming session'
            ],

            [
                'name'=>'Culinarian',
                'description' => 'Training the body and the mind requires fuel. The Culinarian will make sure that all recruits are well fed and ready to give their best.',
                'tasks' => "[1] Coordinate food rations for team recruits. |[2] Acquire food from other teams by trading or purchase.",
                'reward' => "Two major snacks"
            ],

            [
                'name'=>'Technologist',
                'description' => "During the course of the training, the Technologist will become well acquainted with the team's terminal, and will handle communication and puzzle-solving.",
                'tasks' => "[1] Complete the Digital Quest. |[2] Coordinate the communication between teams and players.",
                'reward' => 'One major snack'
            ],

            [
                'name'=>'Engineer',
                'description' => "The Engineer's skillset is the optimal blend of creativity and problem-solving. This recruit will be instrumental in gaining crucial points for their team.",
                'tasks' => "[1] Using supplied materials, construct team's Space Car. |[2] Acquire supplies from another team by trading or purchase.",
                'reward' => 'Additional tools/materials'
            ]
        ];

        foreach ($roles as $role):
            $newRole = new \App\Role;
            $newRole->name = $role['name'];
            $newRole->description = $role['description'];
            $newRole->tasks = $role['tasks'];
            $newRole->reward = $role['reward'];
            $newRole->save();
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
