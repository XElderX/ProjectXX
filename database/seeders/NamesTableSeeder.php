<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usNames = [
            "James", "John", "Robert", "Michael", "William", "David", "Joseph", "Richard", "Charles", "Thomas",
            "Daniel", "Matthew", "Anthony", "Mark", "Donald", "Steven", "Paul", "Andrew", "Kenneth", "Joshua",
            "Kevin", "Brian", "George", "Edward", "Ronald", "Jason", "Timothy", "Jeffrey", "Ryan", "Jacob",
            "Gary", "Nicholas", "Eric", "Jonathan", "Stephen", "Larry", "Scott", "Frank", "Justin", "Brandon",
            "Gregory", "Benjamin", "Samuel", "Patrick", "Alexander", "Jack", "Dennis", "Walter", "Terry", "Raymond"
        ];

        $canadaNames =  [
            "Liam", "Noah", "Oliver", "Ethan", "Lucas", "William", "Benjamin", "Jack", "James", "Alexander",
            "Henry", "Jacob", "Owen", "Daniel", "Logan", "Jackson", "Carter", "Mason", "Elijah", "Landon",
            "Sebastian", "Nathan", "Luke", "Isaac", "Dylan", "Gabriel", "Matthew", "Wyatt", "Hudson", "Jaxon",
            "Evan", "David", "Ryan", "Nicholas", "Levi", "John", "Samuel", "Andrew", "Tyler", "Lincoln",
            "Connor", "Grayson", "Michael", "Caleb", "Adam", "Theodore", "Gavin", "Nolan", "Nathaniel"
        ];
        $ukNames = [
            "Oliver", "George", "Harry", "Noah", "Jack", "Leo", "Arthur", "Muhammad", "Oscar", "Charlie",
            "Jacob", "Thomas", "Henry", "William", "Alfie", "Freddie", "Archie", "Joshua", "Theo", "James",
            "Isaac", "Alexander", "Edward", "Lucas", "Ethan", "Joseph", "Samuel", "Max", "Daniel", "Mohammed",
            "Benjamin", "Harrison", "Finley", "Sebastian", "Adam", "Dylan", "Mason", "Teddy", "Matthew",
            "Jayden", "Riley", "Harvey", "David", "Elijah", "Reuben", "Louie", "Tommy", "Jaxon", "Tyler"
        ];
        $australiaNames = [
            "Oliver", "Jack", "William", "Noah", "Thomas", "James", "Lucas", "Henry", "Ethan", "Charlie",
            "Liam", "Alexander", "Mason", "Samuel", "Max", "Benjamin", "Archie", "Daniel", "Jacob", "Isaac",
            "Leo", "Oscar", "Harrison", "Jackson", "Sebastian", "Cooper", "Harry", "Hunter", "Elijah", "Joshua",
            "Logan", "Theodore", "Jayden", "Ryan", "Dylan", "Tyler", "Zachary", "Nathan", "George", "Carter",
            "Patrick", "Luca", "Blake", "Jaxon", "Michael", "David", "Riley", "Mason", "Nicholas"
        ];
        $indiaNames = [
            "Aarav", "Vihaan", "Arjun", "Reyansh", "Mohammed", "Aryan", "Vivaan", "Advik", "Shaurya", "Kabir",
            "Ishaan", "Hrithik", "Atharva", "Rudra", "Ayaan", "Pranav", "Dhruv", "Shivansh", "Vedant", "Sai",
            "Yuvan", "Rohan", "Krishna", "Arnav", "Ritvik", "Aaditya", "Dev", "Ansh", "Advait", "Ranveer",
            "Raghav", "Sarthak", "Rishabh", "Veer", "Parth", "Aaryan", "Yash", "Manav", "Shaurya", "Kian",
            "Darsh", "Ojas", "Rishi", "Pranay", "Anshuman", "Jayden", "Akshay", "Avyukt", "Ishan", "Aadit"
        ];

        $lithuaniaNames = [
            "Lukas", "Jonas", "Matas", "Benas", "Martynas", "Dominykas", "Nojus", "Paulius", "Gabrielius", "Adomas",
            "Tadas", "Mantas", "Dovydas", "Justinas", "Gustas", "Laurynas", "Kajus", "Karolis", "Viktoras", "Ignas",
            "Mindaugas", "Arnas", "Tautvydas", "Edgaras", "Andrius", "Simonas", "Rokas", "Eduardas", "Viltė", "Artūras",
            "Aurimas", "Gediminas", "Arnoldas", "Dainius", "Ričardas", "Vytautas", "Kęstutis", "Evaldas", "Aidas", "Eimantas",
            "Kazimieras", "Antanas", "Vilius", "Ernestas", "Henrikas", "Žygimantas", "Vytas", "Šarūnas", "Kostas", "Algirdas"
        ];

        foreach ($usNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 1,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach ($canadaNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 2,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($ukNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 3,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($australiaNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 4,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($indiaNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 5,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($lithuaniaNames as $name) {
            DB::table('names')->insert([
                'name' => $name,
                'country_id' => 6,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
