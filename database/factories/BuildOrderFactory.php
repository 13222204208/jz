<?php

namespace Database\Factories;

use App\Models\BuildOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuildOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_name' => $this->faker->name,
            'owner_phone' => $this->faker->phoneNumber,
            'owner_address' => $this->faker->streetAddress,
            'agreement_id' =>1,
            'functionary' => $this->faker->name,
            'functionary_phone' => $this->faker->phoneNumber,
            'time' =>$this->faker->dateTimeInInterval('+5 days', '+15 days', 'PRC'),
        ];
    }
}
