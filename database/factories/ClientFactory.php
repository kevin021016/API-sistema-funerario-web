<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'),
            'calle' => $this->faker->streetName() . ' #' . $this->faker->buildingNumber(),
            'entre_calles' => 'Calle ' . $this->faker->word() . ' y Calle ' . $this->faker->word(),
            'colonia' => $this->faker->word(),
            'ciudad' => 'La Paz', // O $this->faker->city()
            'codigo_postal' => $this->faker->postcode(),
            'referencia_domicilio' => 'Casa de color ' . $this->faker->safeColorName(),
            'telefono' => $this->faker->phoneNumber(),
            'celular' => $this->faker->phoneNumber(),
        ];
    }
}
