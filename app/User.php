<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Seguridad;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','hash_root_dir'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relaciones
     */

     public function ficheros()
     {
        return $this->hasMany(Fichero::class);
     }

     /**
      * Funciones
      */

      public static function crear($name,$email,$password)
      {
          //este sera el directorio raiz de ese usuario (donde se almacenara todos sus ficheros)
          $hashedRootDir = Seguridad::uniqueId();
          $resultado = User::create([
              'name'=>$name,
              'email'=>$email,
              'password'=>bcrypt($password),
              'hash_root_dir'=>Seguridad::uniqueId(20)
          ]);

          return $resultado;
      }


      /**
       * Getter de root dir
       */

      public function getRootDir()
      {
        return $this->hash_root_dir;
      }


      /**
       * Retorna el espacio total usado de este usuario del disco por defecto
       */

       public function getEspacioTotalUsado()
       {
        $espacioTotalUsado = Fichero::getEspacioUsado($this->getRootDir());
        return $espacioTotalUsado;
       }


      /**
       * Returns total used disk space from a directory (MB).
       * DB searching level !! (reworked function)
       */
      public  function getUsedSpaceDisk()
      {
          $files = $this->ficheros()->where('active',1)->get();

          $data = array();


          foreach ($files as $file) {

            $sizeMb = Fichero::parseToMB($file->size);
            $sizeMb = number_format($sizeMb,2);

            //extension
            if (!isset($data['ext'][$file->extension])) {
                $data['ext'][$file->extension] = $sizeMb;
            }
            else{
                $data['ext'][$file->extension] += $sizeMb;
            }


            //total
            if (!isset($data['total'])) {
                $data['total'] = $sizeMb;
            } else {
                $data['total'] += $sizeMb;
            }

          }


          return $data;
      }

}
