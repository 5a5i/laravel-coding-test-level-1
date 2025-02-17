<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**

     * The name of the factory's corresponding model.

     *

     * @var string

     */

    protected $model = Event::class;



    /**

     * Define the model's default state.

     *

     * @return array

     */

    public function definition()

    {

        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'startAt' => date('Y-m-d H:i:s', strtotime('-1 week', strtotime(date("Y-m-d H:i:s")))),
            'endAt' => date('Y-m-d H:i:s', strtotime('+1 week', strtotime(date("Y-m-d H:i:s")))),
            'deletedAt' => null,
        ];
    }

}
