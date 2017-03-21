<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const DEL_ON = 1;
    const DEL_OFF = 0;
    const PARENT_ID_DEFAULT = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'del_flg', 'parent_id'
    ];

    /**
     * get list Category
     * @param $id
     * @return mixed
     */
    public static function getListCategory($id = null)
    {
        if ($id) {
            $listCategory = self::where('id', '<>', $id)->where('del_flg', self::DEL_OFF)->select(['id', 'name','parent_id'])->get();
            $find = true;
            $listParent = array($id);
            while ($find) {
                $find = false;
                foreach ($listCategory as $index => $category) {
                    if (in_array($category->parent_id, $listParent)) {
                        array_push($listParent, $category->id);
                        unset($listCategory[$index]);
                        $find = true;
                    }
                }
            }
            return $listCategory->toArray();
        }
        return self::where('del_flg', self::DEL_OFF)->select(['id', 'name','parent_id'])->get()->toArray();
    }

    /**
     * get all data
     *
     * @return mixed
     */
    public static function getAllData()
    {
        return self::where('del_flg', self::DEL_OFF)
            ->select(['id', 'name', 'updated_at', 'parent_id'])
            ->get()
            ->toJson();
    }

    /**
     * delete  by list category id
     *
     * @param $listId
     */
    public static function deleteCategory($listId)
    {
        self::whereIn('id', $listId)->update(['del_flg' => Category::DEL_ON]);
    }
}
