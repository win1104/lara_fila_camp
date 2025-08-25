<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait LoggableTrait
{
    protected static function bootLoggableTrait()
    {
        static::created(function ($model) {
            self::logModelChange('created', $model);
        });

        static::updated(function ($model) {
            self::logModelChange('updated', $model);
        });

        static::deleted(function ($model) {
            self::logModelChange('deleted', $model);
        });
    }

    /**
     * 記錄 Model 變更日誌
     */
    protected static function logModelChange($action, $model)
    {
        // 獲取當前登入的管理員信息
        $user = Auth::user();
        $adminInfo = $user ? [
            'admin_id' => $user->id,
            'admin_name' => $user->name ?? 'Unknown'
        ] : [
            'admin_id' => null,
            'admin_name' => 'System'
        ];

        // 基礎日誌數據
        $logData = [
            'action' => $action,
            'timestamp' => now()->toISOString(),
            'model' => get_class($model),
            'model_id' => $model->getKey(),
            'admin' => $adminInfo
        ];

        // 如果是更新操作，記錄變更的欄位
        if ($action === 'updated' && $model->wasChanged()) {
            $changes = $model->getChanges();
            // 移除不重要的欄位
            unset($changes['updated_at']);
            $logData['changes'] = $changes;
        }

        // 如果 Model 有定義 getLoggableAttributes() 方法，則記錄指定欄位
        if (method_exists($model, 'getLoggableAttributes')) {
            $loggableData = [];
            foreach ($model->getLoggableAttributes() as $field) {
                if (isset($model->$field)) {
                    $loggableData[$field] = $model->$field;
                }
            }
            $logData['model_data'] = $loggableData;
        }

        // 寫入日誌
        Log::info(class_basename($model) . " Record {$action}", $logData);
    }

    /**
     * 定義要記錄的欄位（子類可覆寫此方法）
     * 預設記錄 id 和 title/name 相關欄位
     */
    public function getLoggableAttributes(): array
    {
        $attributes = ['id'];
        
        // 自動偵測常見的識別欄位
        $commonFields = ['title', 'name', 'slug', 'email', 'locale'];
        foreach ($commonFields as $field) {
            if (in_array($field, $this->fillable)) {
                $attributes[] = $field;
            }
        }
        
        return $attributes;
    }
}