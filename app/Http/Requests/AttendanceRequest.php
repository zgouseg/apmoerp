<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasMultilingualValidation;
use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    use HasMultilingualValidation;

    public function authorize(): bool
    {
        return $this->user()->can('hrm.attendance.create') || $this->user()->can('hrm.attendance.view');
    }

    public function rules(): array
    {
        return [
            // V57-CRITICAL-03 FIX: Use BranchScopedExists to prevent cross-branch employee references
            'employee_id' => ['required', new BranchScopedExists('hr_employees')],
            'date' => ['required', 'date'],
            'check_in' => ['required', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i', 'after:check_in'],
            'status' => ['required', 'in:present,absent,late,half_day,on_leave'],
            'notes' => $this->unicodeText(required: false),
            'overtime_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
        ];
    }
}
