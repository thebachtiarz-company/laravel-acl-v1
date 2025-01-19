<?php

namespace TheBachtiarz\ACL\Models\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\Models\AccessSystem;

/**
 * @extends Factory<AccessSystem>
 */
class AccessSystemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = AccessSystem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
