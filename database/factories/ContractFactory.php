<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'start_time' =>$this->faker->dateTimeInInterval('+1 days', '+15 days', 'PRC'),
            'stop_time' =>$this->faker->dateTimeInInterval('+15 days', '+30 days', 'PRC'),
            'cover' => $this->faker->imageUrl(320, 320, 'cats'),        
        ];
    }
}
