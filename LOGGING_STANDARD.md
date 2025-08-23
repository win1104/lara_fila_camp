# Model 日誌記錄標準

## 使用方式

### 1. 基本使用
在任何需要記錄變更日誌的 Model 中加入 `LoggableTrait`：

```php
<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use LoggableTrait;
    
    protected $fillable = ['name', 'email', 'status'];
}
```

### 2. 自訂記錄欄位
覆寫 `getLoggableAttributes()` 方法來指定要記錄的欄位：

```php
public function getLoggableAttributes(): array
{
    return [
        'id',
        'name',
        'email',
        'status'
    ];
}
```

### 3. 不需要記錄任何 model_data
如果只想記錄操作者和變更內容，不覆寫 `getLoggableAttributes()` 方法，或回傳空陣列：

```php
public function getLoggableAttributes(): array
{
    return []; // 不記錄任何 model 欄位數據
}
```

## 日誌格式

標準日誌會包含以下資訊：
- `action`: 操作類型 (created/updated/deleted)
- `timestamp`: 操作時間
- `model`: Model 類別名稱
- `model_id`: Model ID
- `admin`: 操作者資訊 (id, name)
- `changes`: 變更的欄位 (僅 updated 操作)
- `model_data`: 指定的 model 欄位數據 (可選)

## 建議的實作方式

### 對於不同類型的 Model：

1. **用戶相關 Model** (User, Admin)
   ```php
   public function getLoggableAttributes(): array
   {
       return ['id', 'name', 'email'];
   }
   ```

2. **內容相關 Model** (Post, Article, Product)
   ```php
   public function getLoggableAttributes(): array
   {
       return ['id', 'title', 'slug', 'status'];
   }
   ```

3. **分類相關 Model** (Category, Tag)
   ```php
   public function getLoggableAttributes(): array
   {
       return ['id', 'name', 'slug'];
   }
   ```

4. **系統設定 Model**
   ```php
   public function getLoggableAttributes(): array
   {
       return ['id', 'key', 'value'];
   }
   ```

5. **不需要記錄詳細數據的 Model**
   ```php
   public function getLoggableAttributes(): array
   {
       return []; // 只記錄操作者和變更，不記錄 model 數據
   }
   ```

## 優點

1. **標準化**: 所有 Model 使用相同的日誌格式
2. **彈性**: 每個 Model 可自訂要記錄的欄位
3. **輕量**: 避免記錄不必要的數據
4. **審計**: 完整記錄操作者和變更內容
5. **維護性**: 統一管理，易於修改和擴展