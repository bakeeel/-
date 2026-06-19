<?php

namespace App\Services;

use App\Repositories\Contracts\OfficerRepositoryInterface; // تأكد من تحديث اسم الواجهة
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class OfficerService
{
    protected $officerRepo;

    public function __construct(OfficerRepositoryInterface $officerRepo)
    {
        $this->officerRepo = $officerRepo;
    }

    public function createOfficer(array $data)
    {
        $officer = $this->officerRepo->create($data);
        
        $this->logActivity('إضافة ضابط جديد', 'Officer', $officer->id, $data);
        
        return $officer;
    }

    public function updateOfficer(int $id, array $data)
    {
        $officer = $this->officerRepo->update($id, $data);
        
        $this->logActivity('تحديث بيانات ضابط', 'Officer', $id, $data);
        
        return $officer;
    }

    private function logActivity($action, $model, $id, $payload)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model,
            'model_id' => $id,
            'payload' => json_encode($payload),
            'ip_address' => request()->ip()
        ]);
    }
}