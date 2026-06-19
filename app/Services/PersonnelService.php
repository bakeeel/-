<?php

namespace App\Services;

use App\Repositories\Contracts\PersonnelRepositoryInterface;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PersonnelService
{
    protected $personnelRepo;

    public function __construct(PersonnelRepositoryInterface $personnelRepo)
    {
        $this->personnelRepo = $personnelRepo;
    }

    public function createPersonnel(array $data)
    {
        $person = $this->personnelRepo->create($data);
        
        $this->logActivity('إضافة فرد عسكري جديد', 'Personnel', $person->id, $data);
        
        return $person;
    }

    public function updatePersonnel(int $id, array $data)
    {
        $person = $this->personnelRepo->update($id, $data);
        
        $this->logActivity('تحديث بيانات فرد عسكري', 'Personnel', $id, $data);
        
        return $person;
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