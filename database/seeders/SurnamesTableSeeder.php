<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurnamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uslastnames = [
            "Smith", "Johnson", "Williams", "Brown", "Jones", "Garcia", "Miller", "Davis", "Rodriguez", "Martinez",
            "Hernandez", "Lopez", "Gonzalez", "Wilson", "Anderson", "Thomas", "Taylor", "Moore", "Jackson", "Martin",
            "Lee", "Perez", "Thompson", "White", "Harris", "Sanchez", "Clark", "Ramirez", "Lewis", "Robinson",
            "Walker", "Young", "Allen", "King", "Wright", "Scott", "Torres", "Nguyen", "Hill", "Flores", "Green",
            "Adams", "Nelson", "Baker", "Hall", "Rivera", "Campbell", "Mitchell", "Carter", "Roberts"
        ];
        $canadianlastnames = [
            "Smith", "Brown", "Tremblay", "Martin", "Roy", "Wilson", "MacDonald", "Gagnon", "Johnson", "Taylor",
            "Anderson", "Thomas", "White", "Clark", "Young", "Allen", "Walker", "Scott", "Mitchell", "Lalonde",
            "King", "Wright", "Lee", "Thompson", "Evans", "Cote", "Richard", "Hall", "Gauthier", "Morin",
            "Lavoie", "Fortin", "Moore", "Pelletier", "Ross", "Hill", "Simard", "Boucher", "Baker", "Rousseau",
            "Stewart", "Legault", "Girard", "Fournier", "Mercier", "Dupuis", "Gagné", "Watson", "Bergeron"
        ];
        $uklastnames = [
            "Smith", "Jones", "Williams", "Brown", "Taylor", "Wilson", "Evans", "Thomas", "Roberts", "Johnson",
            "Lewis", "Walker", "Robinson", "Wood", "Thompson", "White", "Watson", "Jackson", "Wright", "Green",
            "Harris", "Cooper", "King", "Lee", "Martin", "Clarke", "James", "Morgan", "Hughes", "Edwards",
            "Hill", "Moore", "Clark", "Harrison", "Scott", "Young", "Morris", "Hall", "Ward", "Turner",
            "Carter", "Phillips", "Mitchell", "Patel", "Adams", "Campbell", "Anderson", "Allen", "Cook"
        ];
        $australianlastnames = [
            "Smith", "Jones", "Williams", "Brown", "Wilson", "Taylor", "Johnson", "White", "Martin", "Anderson",
            "Thompson", "Walker", "Harris", "Lee", "Ryan", "Robinson", "Kelly", "King", "Davis", "Wright",
            "Evans", "Thomas", "Hughes", "Roberts", "Green", "Jackson", "Wood", "Lewis", "Hill", "Clark",
            "Cooper", "Miller", "Turner", "Parker", "Edwards", "Scott", "Morris", "Baker", "Murray", "Bennett",
            "Carter", "Mitchell", "Gray", "James", "Watson", "Gardner", "Murphy", "Russell", "Cook"
        ];
        $indianlastnames = [
            "Patel", "Singh", "Kumar", "Sharma", "Shah", "Patil", "Verma", "Reddy", "Gupta", "Khan",
            "Soni", "Mehta", "Choudhary", "Malik", "Yadav", "Naidu", "Jha", "Rao", "Agarwal", "Prasad",
            "Sinha", "Yadav", "Saxena", "Chauhan", "Das", "Pandey", "Dube", "Goswami", "Biswas", "Barman",
            "Koirala", "Dhakal", "Thapa", "Tamang", "Acharya", "Rai", "Lama", "Basnet", "Bhattarai", "Shrestha",
            "Joshi", "Poudel", "Shakya", "Dahal", "Gurung", "Magar", "Maharjan", "Subedi", "Karki", "Sharma"
        ];
        $lithuanianlastnames = [
            "Kazlauskas", "Petrauskas", "Kavaliauskas", "Jankauskas", "Jakubauskas", "Paulauskas", "Mickevičius", "Adomaitis", "Vaitkus", "Jankus",
            "Kudrevičius", "Čepėnas", "Kazakevičius", "Lukauskas", "Gudaitis", "Šimkus", "Sakalauskas", "Jonaitis", "Navickas", "Stankus",
            "Jonauskas", "Šimkevičius", "Kučinskas", "Kavaliauskas", "Rimkus", "Rutkauskas", "Jonikas", "Juška", "Vaitkevičius", "Šimanskis",
            "Stankevičius", "Gudavičius", "Dambrauskas", "Dovydaitis", "Norkus", "Zukauskas", "Žukauskas", "Gražulis", "Morkūnas", "Žilinskas",
            "Pocius", "Lukšys", "Adamkus", "Petkevičius", "Paulauskas", "Valiulis", "Urbonas", "Kubilius", "Kairys", "Jurgaitis"
        ];

        foreach ($uslastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 1,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        foreach ($canadianlastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 2,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($uklastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 3,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($australianlastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 4,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($indianlastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 5,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        foreach ($lithuanianlastnames as $surname) {
            DB::table('surnames')->insert([
                'surname' => $surname,
                'country_id' => 6,
                'popularity' => rand(7, 10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
