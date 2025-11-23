<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'day' => 'sometimes|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'is_closed' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'day.in' => 'El día debe ser válido',
            'open_time.required' => 'La hora de apertura es obligatoria',
            'open_time.date_format' => 'El formato de hora debe ser HH:MM',
            'close_time.required' => 'La hora de cierre es obligatoria',
            'close_time.date_format' => 'El formato de hora debe ser HH:MM'
        ];
    }
}
