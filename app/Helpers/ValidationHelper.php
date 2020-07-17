<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ValidationHelper {
  public static function validate ($params, $rules) {
    $validator = Validator::make($params, $rules);
    if ($validator->fails()) {
        throw new ValidationException($validator,
            new JsonResponse($validator->messages(), 422));
    }
  }
}