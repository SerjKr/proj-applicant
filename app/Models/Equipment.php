<?php

namespace App\Models;

use App\Http\Resources\Equipment\EquipmentResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'equipments';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function typeEquipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function scopeFilter($query, $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ($request->has('query')) {
            $data = self::find($request->filters);
        } elseif ($request->has('q')) {
            $data = self::where('serial_number', 'like', '%' . $request->q . '%')->get();
        } else {
            $data = self::paginate(10);
        }

        return EquipmentResource::collection($data);
    }
}
