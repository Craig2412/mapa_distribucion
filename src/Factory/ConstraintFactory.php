<?php

namespace App\Factory;

use Symfony\Component\Validator\Constraints as Assert;

final class ConstraintFactory
{
    public function collection(array $fields = null): Assert\Collection
    {
        //$fields['extraFieldsMessage'] = 'no';
        return new Assert\Collection($fields, null, null, null, null,'Este campo no se esperaba.');
    }

    public function required(array $options): Assert\Required
    {
        return new Assert\Required($options);
    }

    public function optional(array $options): Assert\Optional
    {
        return new Assert\Optional($options);
    }

    public function notBlank(): Assert\NotBlank
    {
        return new Assert\NotBlank(['message' => 'El campo "{{ field }}" no puede estar vacío']);
    }

    public function length(int $min = null, int $max = null): Assert\Length
    {
        $options = ['min' => $min, 'max' => $max];
        if ($min !== null) {
            $options['minMessage'] = 'El campo "{{ field }}" debe tener al menos {{ min }} caracteres';
        } elseif ($max !== null) {
            $options['maxMessage'] = 'El campo "{{ field }}" no puede tener más de {{ max }} caracteres';
        }
        return new Assert\Length($options);
    }

    public function positive(): Assert\Positive
    {
        return new Assert\Positive(['message' => 'El campo "{{ field }}" debe ser positivo']);
    }

    public function email(): Assert\Email
    {
        return new Assert\Email(['message' => 'El campo "{{ field }}" no es una dirección de correo electrónico válida']);
    }
}
