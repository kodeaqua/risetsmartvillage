<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleAdditiveWeighting extends Model
{
    use HasFactory;

    public static function showResult()
    {
        $spatials = Spatial::where('is_deleted', false)->get();
        $categories = Category::where('is_deleted', false)->where('severity', 'very_high')->get();
        $areas = Area::where('is_deleted', false)->get();

        $arraydata = [];


        foreach ($areas as $key => $value) {
            $areaitem = [];
            array_push($areaitem, $value->name);
            array_push($areaitem, $value->description);

            $total = 0;
            foreach ($categories as $key => $subvalue) {
                $usedvalue = 0;
                $curr = 0;
                foreach ($areas as $key => $subsubvalue) {
                    $i = $spatials->where('category_id', $subvalue->id)->where('area_id', $subsubvalue->id)->count();
                    ($subvalue->severity == 'very_high' || $subvalue->severity == 'high' || $subvalue->severity == 'normal' ? ($i > $usedvalue ? ($usedvalue = $i) : false) : $i < $usedvalue) ? ($usedvalue = $i) : false;
                    $curr++;
                }
                $result = 0.0;
                if ($subvalue->severity == 'very_high' || $subvalue->severity == 'high' || $subvalue->severity == 'normal') {
                    $result = $spatials->where('area_id', $value->id)->where('category_id', $subvalue->id)->count() / $usedvalue;
                } else if ($subvalue->severity == 'low' || $subvalue->severity == 'no_effect') {
                    if ($usedvalue > 0) {
                        $result = $usedvalue / $spatials->where('area_id', $value->id)->where('category_id', $subvalue->id)->count();
                    }
                }
                if ($result) {
                    $total = $total + $result;
                }
                array_push($areaitem, $result);
            }

            array_push($areaitem, $total);

            if ($total == 4) {
                $description = 'Very potential';
            } else if ($total >= 3) {
                $description = 'Potentially';
            } else if ($total >= 2) {
                $description = 'Little bit potential';
            } else if ($total >= 1) {
                $description = 'Not yet potential';
            }
            array_push($areaitem, $description);

            array_push($arraydata, $areaitem);
        }

        usort($arraydata, function ($a, $b) {
            return $b[count($b) - 2] <=> $a[count($a) - 2];
        });

        $saw = collect($arraydata);

        return $saw;
    }
}
