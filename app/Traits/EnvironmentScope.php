<?php
namespace App\Traits;

trait EnvironmentScope{
    private function setEnv($key, $value)
    {
        $path = base_path('.env');
        $keyExist = env($key);
        $valueExist = getenv($key);

        if (file_exists($path)) {
            if(isset($keyExist) && $valueExist == ''){
                file_put_contents(app()->environmentFilePath(), str_replace(
                    $key . '=',
                    $key . '=' . $value,
                    file_get_contents(app()->environmentFilePath())
                ));
            }elseif($keyExist == '' && $valueExist == ''){
                file_put_contents($path, $key . '=' . $value.PHP_EOL , FILE_APPEND | LOCK_EX);
            }else{
                if($valueExist){
                    file_put_contents(app()->environmentFilePath(), str_replace(
                        $key . '='.env($key),
                        $key . '=' . $value,
                        file_get_contents(app()->environmentFilePath())
                    ));
                }else{

                }
            }

        }
    }
}
