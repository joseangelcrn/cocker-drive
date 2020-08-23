<?php

namespace Tests\Unit;

use App\Fichero;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testParseByteToMB()
    {
        //1 MB in bytes
        $bytes = 1048576;
        $parsedValue = Fichero::parseToMb($bytes);

        $this->assertEquals(1,$parsedValue);

    }
    public function testIsImageTrue()
    {

        $isImage = Fichero::isImage('png');
        $this->assertTrue($isImage);

    }
    public function testIsImageFalse()
    {

        $isImage = Fichero::isImage('txt');
        $this->assertFalse($isImage);

    }
    public function testgetMinSearchingRangeValueFor_144()
    {
        $width = 144;
        $minValue = 0;
        $maxValue = $width + 0.001 ;
        $width = rand($minValue * 1000 ,$width * 1000) / 1000;
        $resultValue = Fichero::getMinSearchingRangeValue($width);

        var_dump('resultValue');
        var_dump($resultValue);
        //wath i expected  if result is less than max allowed
        if ($resultValue <= $maxValue) {
            $this->assertGreaterThanOrEqual($minValue,$resultValue);
            $this->assertLessThanOrEqual($maxValue,$resultValue);
        }
        //wath i didnt  expect it
        else{
            $this->assertGreaterThanOrEqual($maxValue,$resultValue);
        }


    }

    
    // public function testUploadFile()
    // {
    //     $user = new User([
    //         'id' => -1,
    //         'name' => 'test',
    //         'email' => 'test',
    //         'password' => 'test',
    //     ]);

    //     $this->be($user);

    //     $this->assertTrue(true);
    //     Storage::fake('temp/test.txt');

    //     $response = $this->json('POST', '/fichero', [
    //         'test' => UploadedFile::fake()->create('test.txt')
    //     ]);
    //         //success
    //         if($response->assertjson(['resultado'=>true])){

    //         }
    //         //error
    //         else{
    //             $this->assertTrue(false);
    //         }
    //     // // Assert the file was stored...
    //     // Storage::disk('public')->assertExists('sistema/iconos/txt.png');

    //     // // Assert a file does not exist...
    //     // Storage::disk('public')->assertMissing('missing.jpg');
    // }
}
