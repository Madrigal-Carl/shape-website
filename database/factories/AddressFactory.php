<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Address::class;
    public function definition(): array
    {
        $barangayData = [
            "boac" => [
                "agot","agumaymayan","apitong","balagasan","balaring","balimbing","bangbang","bantad","bayanan",
                "binunga","boi","boton","caganhao","canat","catubugan","cawit","daig","duyay","hinapulan","ibaba",
                "isok i","isok ii","laylay","libtangin","lupac","mahinhin","malbog","malindig","maligaya","mansiwat",
                "mercado","murallon","pawa","poras","pulang lupa","puting buhangin","san miguel","tabi","tabigue",
                "tampus","tambunan","tugos","tumalum",
            ],
            "mogpog" => [
                "bintakay","bocboc","butansapa","candahon","capayang","danao","dulong bayan","gitnang bayan",
                "hinadharan","hinanggayon","ino","janagdong","malayak","mampaitan","market site","nangka i","nangka ii",
                "silangan","sumangga","tabi","tarug","villa mendez",
            ],
            "gasan" => [
                "antipolo","bachao ibaba","bachao ilaya","bacong-bacong","bahi","banot","banuyo","cabugao","dawis","ipil",
                "mangili","masiga","mataas na bayan","pangi","pinggan","tabionan","tiguion",
            ],
            "buenavista" => [
                "bagacay","bagtingon","bicas-bicas","caigangan","daykitin","libas","malbog","sihi","timbo","tungib-lipata","yook",
            ],
            "torrijos" => [
                "bangwayin","bayakbakin","bolo","buangan","cagpo","dampulan","kay duke","macawayan","malibago","malinao",
                "marlangga","matuyatuya","poblacion","poctoy","sibuyao","suha","talawan","tigwi",
            ],
            "santa cruz" => [
                "alobo","angas","aturan","baguidbirin","banahaw","bangcuangan","biga","bolo","bonliw","botilao","buyabod",
                "dating bayan","devilla","dolores","haguimit","ipil","jolo","kaganhao","kalangkang","kasily","kilo-kilo",
                "kinyaman","lamesa","lapu-lapu","lipata","lusok","maharlika","maniwaya","masaguisi","matalaba","mongpong",
                "pantayin","pili","poblacion","punong","san antonio","tagum","tamayo","tawiran","taytay",
            ],
        ];

        $municipality = $this->faker->randomElement(array_keys($barangayData));
        $barangay = $this->faker->randomElement($barangayData[$municipality]);
        return [
            'province' => 'marinduque',
            'municipality' => $municipality,
            'barangay' => $barangay,
            'type' => null,
            'owner_id' => Student::factory(),
            'owner_type' => Student::class,
        ];
    }
    public function instructor()
    {
        return $this->state(function (array $attributes) {
            return [
                'owner_id' => Instructor::factory(),
                'owner_type' => Instructor::class,
            ];
        });
    }
    public function student()
    {
        return $this->state(function (array $attributes) {
            return [
                'owner_id' => Student::factory(),
                'owner_type' => Student::class,
            ];
        });
    }
}
