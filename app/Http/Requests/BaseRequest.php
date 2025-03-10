<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected array $swappableKey = [];

    protected bool $convertCamelToSnake = true;

    public function validated($key = null, $default = null)
    {
        // Preserve original
        $original = parent::validated();

        // Mutated data
        $mutated = [];

        // Convert all key to snake if converter setted to true
        if ($this->convertCamelToSnake) {
            collect($original)->each(function ($item, $key) use (&$mutated) {
                // Convert to snake
                $key = Str::snake($key);

                $mutated[$key] = $item;
            });
        }

        // Mutate data based on swappableKey
        $mutated = collect($mutated)->mapWithKeys(function ($item, $key) {
            // CHeck on the swappableKey
            // Return original key if not exists on swappableKey
            $newKey = $this->swappableKey[$key] ?? $key;

            return [$newKey => $item];
        });

        return $mutated->toArray();
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) :
            $errors = (new ValidationException($validator))->getMessage();

            throw new HttpResponseException(
                response()->json([
                    'message' => $errors,
                    'data' => $validator->errors()->getMessageBag(),
                ], 422)
            );
        endif;

        parent::failedValidation($validator);
    }
}
