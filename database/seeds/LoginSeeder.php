<?php

use App\Helpers\Helper;
use Illuminate\Database\Seeder;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Demo',
            'email' => 'info@greefitech.com',
            'password' => bcrypt('greefitech@123'),
        ]);

//        DB::table('clients')->insert([
//            'name' => 'Demo',
//            'email' => 'admin@demo.com',
//            'password' => bcrypt('123456'),
//            'transportName' => 'Mohan',
//            'expires_on' => Helper::get_expire_date(date('Y')),
//            'mobile' => '1234567890',
//            'address' => 'Salem',
//        ]);

        DB::table('expense_types')->insert([
            'expenseType' => 'Salary',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        DB::table('expense_types')->insert([
            'expenseType' => 'டீசல்',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        $documentTypes = [
            ['documentType' => 'Q Tax','created_at'=>now(),'updated_at'=>now()],
            ['documentType' => 'NP Tax','created_at'=>now(),'updated_at'=>now()],
            ['documentType' => 'Permit Renewal','created_at'=>now(),'updated_at'=>now()],
            ['documentType' => 'Finance Due','created_at'=>now(),'updated_at'=>now()],
            ['documentType' => 'Pollution Control','created_at'=>now(),'updated_at'=>now()],
            ['documentType' => 'Others','created_at'=>now(),'updated_at'=>now()]
        ];
        DB::table('document_types')->insert($documentTypes);

        $vehicleTypes = [
            ['vehicleType' => 'Open Body - 10 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Open Body - 12 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Open Body - 14 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Pickup Truck','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Reefer Truck','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Trailer - 6 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Trailer - 10 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Trailer - 12 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Trailer - 14 W','created_at'=>now(),'updated_at'=>now()],
            ['vehicleType' => 'Trailer - 22 W','created_at'=>now(),'updated_at'=>now()],
        ];
        DB::table('vehicle_types')->insert($vehicleTypes);

        $loadTypes = [
            ['loadType' => 'Books or Paper Rolls','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Building Materials','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Cement','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Chemicals','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Coal and Ash','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Crop or Agri Products','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Electronics or Consumer Durables','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Engineering Goods','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Fertilizers','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Fruits and Vegetables','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Granites or Marbel','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Household Goods','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Industrial Equipments','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Iron Pipes or Steel Materials','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Liquids or Oil Drums','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Machineries','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Packed Foods','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Plastic Industrial Goods','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Plastic Pipes','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Printed Books or Paper Rolls','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Refrigerated Goods','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Rice or Agri Products','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Scraps','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Stones or Tiles','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Textiles','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Tyres and Rubber Products','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Vehicles and Rubber Products','created_at'=>now(),'updated_at'=>now()],
            ['loadType' => 'Others or General','created_at'=>now(),'updated_at'=>now()],
        ];
        DB::table('load_types')->insert($loadTypes);

        $expenseTypes = [
            ['expenseType' => 'பட்டறை செலவு','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'RTO செலவு','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'நாக்கா','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'பாலம் / டோல் கேட்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'இதர செலவுகள்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'சாமி செலவு','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'போன் செலவு','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'வாட்டர் சர்விஸ்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'செக் போஸ்ட்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'PC செலவு','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'பில் படி','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'Grease','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'டயர்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'ஆயில்','created_at'=>now(),'updated_at'=>now()],
            ['expenseType' => 'Other Expenses(1)','created_at'=>now(),'updated_at'=>now()],
        ];
        DB::table('expense_types')->insert($expenseTypes);
    }
}
