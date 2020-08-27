<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $table = "logs";
    protected $fillable = ['log_type_id','file_id','old_name','new_name'];

    private const logsPerPage = 25;

    /**
     * Relations
     */

    public function type()
    {
        return $this->belongsTo(LogType::class,'log_type_id');
    }
    public function file()
    {
        return $this->belongsTo(Fichero::class);
    }

    /**
     * Functions
     */

    public static function getDeletingTypeId()
    {
       return LogType::where('name','deleted')->first()->id;
    }

    public static function getRenamingTypeId()
    {
       return LogType::where('name','renamed')->first()->id;
    }

    public static function getUploadingTypeId()
    {
       return LogType::where('name','uploaded')->first()->id;
    }


    /**
     * General function for adding logs
     */

    public static function add($logType,$fileId,$oldName = null, $newName = null)
    {
        $result = false;

        switch ($logType) {
            case 'store':
                $selectedTypeId = self::getUploadingTypeId();
                break;
            case 'update':
                $selectedTypeId = self::getRenamingTypeId();
                break;
            case 'destroy':
                $selectedTypeId = self::getDeletingTypeId();
                break;
            default:
                $selectedTypeId = null;
                break;
        }

        if ($logType != null) {
           $newLog =  self::create(
                [
                    'log_type_id' => $selectedTypeId,
                    'file_id' => $fileId,
                    'old_name' => $oldName,
                    'new_name' => $newName
                ]
            );
            if ($newLog != null) {
                $result = true;
            }
        }

        return $result;
    }


     /**
      * Return all existing logs about an user. In adition, return related file and log type.
      * (using eager loading)
      */

     public static function getAllLogsByUserWithFileUser($userId,$dateFrom=null,$dateTo=null)
     {
        $logs = Log::with(['type','file'])
        ->whereHas('file', function($q) use($userId){
            $q->where('user_id', $userId);
        });

        $logs->orderBy('created_at','desc');

        return $logs->get();
     }

     /**
      * This function filter logs data by differents choises which does user.
      */

      public static function filterDataByUserChoise($userId,$searchValue,$length,$orderBy = 'created_at',$orderByDir = 'asc',$logType = null)
      {
        //main searching
        $logs = Log::with(['type','file']);

        // //search  -  file name (working !)
        $logs->whereHas('file',function ($q) use($userId,$searchValue,$orderBy,$orderByDir)
        {
            $q->where('nombre_real','like','%'.$searchValue.'%')
            ->where('user_id',$userId);
        });

        // //log type searching (work !)
        if ($logType != null) {
            $logs->whereHas('type',function ($q) use($logType)
            {
                $q->select('id')->where('name','like','%'.$logType.'%');
            });
        }

        //doing ...
        //sorting on this way when user doesnt wants order by related tables
        if ($orderBy === 'file.nombre_real' and $orderByDir === 'asc') {
            $data =  $logs->paginate($length)->sortBy('file.nombre_real');
        }
        else if ($orderBy === 'file.nombre_real' and $orderByDir === 'desc') {
            $data =  $logs->paginate($length)->sortByDesc('file.nombre_real');
        }
        else{
            $logs->orderBy($orderBy,$orderByDir);
            $data =  $logs->paginate($length);
        }

        return $data;
      }
}

