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
                "agot",
                "agumaymayan",
                "amoingon",
                "apitong",
                "balagasan",
                "balaring",
                "balimbing",
                "balogo",
                "bamban",
                "bangbangalon",
                "bantad",
                "bayuti",
                "binunga",
                "boi",
                "boton",
                "buliasnin",
                "bunganay",
                "caganhao",
                "canat",
                "catubugan",
                "cawit",
                "daig",
                "daypay",
                "duyay",
                "hinapulan",
                "ihatub",
                "isok i",
                "isok ii poblacion",
                "laylay",
                "lupac",
                "mahinhin",
                "mainit",
                "malbog",
                "maligaya",
                "malusak",
                "mamsiwat",
                "mataas na bayan",
                "maybo",
                "mercado",
                "murallon",
                "pawa",
                "pili",
                "poctoy",
                "poras",
                "puting buhangin",
                "puyog",
                "sabong",
                "san miguel",
                "santol",
                "sawi",
                "tabi",
                "tabigue",
                "tagwak",
                "tambunan",
                "tampus",
                "tanza",
                "tugos",
                "tumagabok",
                "tumapon",
            ],

            "buenavista" => [
                "bagacay",
                "bagtingon",
                "barangay i (poblacion)",
                "barangay ii (poblacion)",
                "barangay iii (poblacion)",
                "barangay iv (poblacion)",
                "bicas-bicas",
                "caigangan",
                "daykitin",
                "libas",
                "malbog",
                "sihi",
                "timbo (sanggulong)",
                "tungib-lipata",
                "yook",
            ],

            "gasan" => [
                "antipolo",
                "bachao ibaba",
                "bachao ilaya",
                "bacong-bacong",
                "bahi",
                "bangbang",
                "banot",
                "banuyo",
                "bognuyan",
                "cabugao",
                "dawis",
                "dili",
                "libtangin",
                "mahunig",
                "mangiliol",
                "masiga",
                "matandang gasan",
                "pangi",
                "pinggan",
                "tabionan",
                "tapuyan",
                "tiguion",
                "barangay i (poblacion)",
                "barangay ii (poblacion)",
                "barangay iii (poblacion)",
            ],

            "mogpog" => [
                "anapog-sibucao",
                "arago",
                "balanacan",
                "banto",
                "bintakay",
                "bocboc",
                "butansapa",
                "candahon",
                "capayang",
                "danao",
                "dulong bayan (poblacion)",
                "gitnang bayan (poblacion)",
                "guisian",
                "hinadharan",
                "hinanggayon",
                "ino",
                "janagdong",
                "lamesa",
                "malusak",
                "malayak",
                "mampaitan",
                "market site",
                "nangka i",
                "nangka ii",
                "pili",
                "puting buhangin",
                "sayao",
                "silangan",
                "sumangga",
                "tarug",
                "villa mendez",
            ],

            "santa cruz" => [
                "alobo",
                "angas",
                "aturan",
                "bagong silang poblacion (2nd zone)",
                "baguidbirin",
                "baliis",
                "balogo",
                "banahaw poblacion (3rd zone)",
                "bangcuangan",
                "banogbog",
                "biga",
                "botilao",
                "buyabod",
                "dating bayan",
                "devilla",
                "dolores",
                "haguimit",
                "hupi",
                "ipil",
                "jolo",
                "kaganhao",
                "kalangkang",
                "kamandugan",
                "kasily",
                "kilo-kilo",
                "kinyaman",
                "labor / labo",
                "lamesa",
                "landy (perez)",
                "lapu-lapu poblacion (5th zone)",
                "libjo",
                "lipa",
                "lusok",
                "maharlika poblacion (1st zone)",
                "makulapnit",
                "maniwaya",
                "manlibunan",
                "masaguisi",
                "masalukot",
                "matalaba",
                "mongpong",
                "morales",
                "napo (malabon)",
                "pag-asa poblacion (4th zone)",
                "pantayin",
                "polo",
                "pulong-parang",
                "punong",
                "san antonio",
                "san isidro",
                "tagum",
                "tamayo",
                "tambangan",
                "tawiran",
                "taytay",
            ],

            "torrijos" => [
                "bangwayin",
                "bayakbakin",
                "bolo",
                "bonliw",
                "buangan",
                "cabuyo",
                "cagpo",
                "dampulan",
                "kay duke",
                "makawayan",
                "malibago",
                "malinao",
                "maranlig",
                "marlangga",
                "matuyatuya",
                "nangka",
                "pakaskasan",
                "payanas",
                "poblacion",
                "poctoy",
                "sibuyao",
                "suha",
                "talawan",
                "tigwi",
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
