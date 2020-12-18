<?php

namespace Database\Factories;

use App\Models\Userinfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserinfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Userinfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'username' => $this->faker->phoneNumber,
                'password' => bcrypt('123456'),
                'nickname' =>$this->faker->word,
                'wx_id' =>$this->faker->unique()->safeEmail,
                'truename' => $this->faker->name,
                'id_number' => $this->faker->creditCardNumber,
                'role_id' => $this->faker->numberBetween(1, 3),
                'phone' => $this->faker->phoneNumber,
                'id_front' => $this->faker->imageUrl(320, 320, 'cats'),
                'id_the_back' => $this->faker->imageUrl(320, 320, 'cats'),
                'id_in_hand' => $this->faker->imageUrl(320, 320, 'cats'),
        ];
    }
}
