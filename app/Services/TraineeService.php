<?php

namespace App\Services;

use App\Models\Trainee;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TraineeService
{
    /**
     * تسجيل متدرب جديد في المنظومة التدريبية
     */
    public function createTrainee(array $data)
    {
        $trainee = Trainee::create($data);
        
        // تسجيل العملية في السجل الأمني
        $this->logActivity('إضافة متدرب عسكري جديد', 'Trainee', $trainee->id, $data);
        
        return $trainee;
    }

    /**
     * تحديث بيانات متدرب عسكري حالي
     */
   public function updateTrainee(Trainee $trainee, array $data)
    {
        $trainee->update($data);
        return $trainee;
        // تسجيل العملية في السجل الأمني
            $this->logActivity('تحديث بيانات متدرب عسكري', 'Trainee', $id, $data);
    }
        
      
        
    

    /**
     * ربط متدرب بدورة تدريبية (تحديث جدول Pivot)
     */
    public function attachCourse(int $traineeId, int $courseId, array $pivotData)
    {
        $trainee = Trainee::findOrFail($traineeId);
        
        // ربط الدورة مع حقول الشهادة والتقدير والتواريخ المخصصة
        $trainee->courses()->attach($courseId, $pivotData);
        
        $this->logActivity('إلحاق متدرب بدورة تدريبية', 'Trainee', $traineeId, [
            'course_id' => $courseId,
            'pivot_data' => $pivotData
        ]);
        
        return $trainee;
    }

    /**
     * الجدار الأمني لتسجيل تحركات وحركات المستخدمين على بيانات المتدربين
     */
    private function logActivity($action, $model, $id, $payload)
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'model_type' => $model,
            'model_id'   => $id,
            'payload'    => json_encode($payload, JSON_UNESCAPED_UNICODE), // حماية الحروف العربية من التحول لرموز داخل الـ JSON
            'ip_address' => request()->ip()
        ]);
    }
}