<?php
// app/Http/Requests/CreateEventRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'start' => 'required|date',
            'end' => 'required|date',
            'title' => 'required',
            'description' => 'required'
        ];
    }
}
