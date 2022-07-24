<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Charts\CustomerChart;
use App\Charts\TownChart;
use App\Charts\SalesChart;
use App\Charts\ItemChart;
use DB;
use App\Models\Customer;
class DashboardController extends Controller
{
    public function __construct(){
        $this->bgcolor = collect(['#7158e2','#3ae374', '#ff3838',"#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]);
    }
    public function index(){
        // dd($this->bgcolor);
     $customer = DB::table('customers')->groupBy('title')->orderBy('total')->pluck(DB::raw('count(title) as total'),'title')->all();
     // $customer = asort($customer,SORT_REGULAR );
     // dd($customer);
     $customerChart = new CustomerChart;
     // dd(array_keys($customer));
      $dataset = $customerChart->labels(array_keys($customer));
        // dd($dataset);
        $dataset= $customerChart->dataset('Customer Demographics', 'doughnut', array_values($customer));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        // dd($customerChart);
        $customerChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            // 'maintainAspectRatio' =>true,
            // 'title' => 'test',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [[
                            'display'=>false,
                            'ticks'=> ['beginAtZero'=> true],
                            'gridLines'=> ['display'=> false],
                          ]],
                'xAxes'=> [[
                            'categoryPercentage'=> 0.8,
                            //'barThickness' => 100,
                            'barPercentage' => 1,
                            'ticks' => ['beginAtZero' => false],
                            'gridLines' => ['display' => false],
                            'display' => true
                          ]],
            ],
        ]);
        // dd($customerChart);
        $town = DB::table('customers')->whereNotNull('town')->groupBy('town')->orderBy('town','ASC')->pluck(DB::raw('count(town) as total'),'town')->all();
        // $town = DB::table('customer')->whereNotNull('town')->get('town');
     // dd($town);
     $townChart = new TownChart;
     // dd(array_values($customer));
      $dataset = $townChart->labels(array_keys($town));
        // dd($dataset);
        $dataset= $townChart->dataset('town Demographics', 'horizontalBar', array_values($town));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        // dd($customerChart);
        $townChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            // 'maintainAspectRatio' =>true,
            // 'title' => 'test',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [
                    'display'=>true,
                    'ticks'=> ['beginAtZero'=> true,
                        'max'=>100],
                        'min'=>0,
                        'stepSize'=> 5,
                    'gridLines'=> ['display'=> false],
                  ],
                'xAxes'=> [
                    'categoryPercentage'=> 0.8,
                    //'barThickness' => 100,
                    'barPercentage' => 1,
                    'ticks' => [ 'beginAtZero' => true,
                         'min'=>0,
                ],
                'gridLines' => ['display' => false],
                'display' => true
                  ],
            ],
        ]);
        // dd($townChart);
        $sales = DB::table('orderinfo AS o')
         ->join('orderline AS ol','o.orderinfo_id','=','ol.orderinfo_id')
         ->join('item AS i','ol.item_id','=','i.item_id')
         ->groupBy('o.date_placed')
         ->pluck(DB::raw('sum(ol.quantity * i.sell_price) AS total'),DB::raw('monthname(o.date_placed) AS month'))
         ->all();
        // dd($sales);
        $salesChart = new SalesChart;
     // dd(array_values($customer));
     $dataset = $salesChart->labels(array_keys($sales));
        // dd($dataset);
        $dataset= $salesChart->dataset('Monthly sales', 'bar', array_values($sales));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);
        // dd($customerChart);
        $salesChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            'aspectRatio' => 1,
            'scaleBeginAtZero' =>true,
            'scales' => [
                'yAxes'=> [[
                    'display'=>true,
                    'type'=>'linear',
                    'ticks'=> [
                        'beginAtZero'=> true,
                         'autoSkip' => true,
                         'maxTicksLimit' =>20000,
                         'min'=>0,
                        // 'max'=>20000,
                        'stepSize' => 500
                    ]],
                   'gridLines'=> ['display'=> false],
                ],
                'xAxes'=> [
                    'categoryPercentage'=> 0.8,
                    'barPercentage' => 1,
                    'gridLines' => ['display' => false],
                    'display' => true,
                    'ticks' => [
                     'beginAtZero' => true,
                     'min'=> 0,
                     'stepSize'=> 10,
                    ]
                ]
            ]
        ]);
        // dd($salesChart);
        $items = DB::table('orderline AS ol')
            ->join('item AS i','ol.item_id','=','i.item_id')
            ->groupBy('i.description')
            ->pluck(DB::raw('sum(ol.quantity) AS total'),'description')
            ->all();
// dd($items);
            $itemChart = new ItemChart;
        // dd(array_values($customer));
        $dataset = $itemChart->labels(array_keys($items));
        // dd($dataset);
        $dataset= $itemChart->dataset('Item sold', 'line', array_values($items));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        // dd($customerChart);
        $dataset = $dataset->fill(false);
        $itemChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [
                    'display'=>true,
                    'ticks'=> ['beginAtZero'=> true],
                    'gridLines'=> ['display'=> false],
                  ],
                'xAxes'=> [
                    'categoryPercentage'=> 0.8,
                    //'barThickness' => 100,
                    'barPercentage' => 1,
                    'gridLines' => ['display' => false],
                    'display' => true,
                    'ticks' => [
                        'beginAtZero' => true,
                        'min'=> 0,
                        'stepSize'=> 10,
                    ]
                ]
            ],
        ]);
        // ->groupBy('town')->orderBy('total')->pluck(DB::raw('count(town) as total'),'town')->all();
        //fetch customers who ordered on 2021
//         $users = User::with(['posts' => function ($query) {
//     $query->where('title', 'like', '%code%');
// }])->get();
    // $customers = Customer::with(['orders' => function($query){
            // $query->whereMonth('date_placed','=',12);
            // (DB::raw('YEAR(date_placed)','=','2021')
        // }])->get();
    // dump($customers);
     return view('dashboard.index',compact('customerChart','townChart','salesChart','itemChart'));
    }
}