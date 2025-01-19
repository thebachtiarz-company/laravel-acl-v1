<?php

namespace TheBachtiarz\ACL\Models\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\ACL\Models\SourceAccess;

/**
 * @extends Factory<SourceAccess>
 */
class SourceAccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = SourceAccess::class;

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
