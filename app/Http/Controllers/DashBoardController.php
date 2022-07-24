<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Charts\GenreChart;
use App\Charts\ListenerChart;
use DB;

class DashBoardController extends Controller
{
    //
    public function index() {
        $genre = DB::table('albums')->groupBy('genre')
            ->pluck(DB::raw('count(genre) as total'),'genre')
            ->toArray();
    // ->all();
        // dd(array_keys($genre));
        $listener = DB::table('albums')
            ->join('album_listener','albums.id', '=', 'album_listener.album_id')
            ->join('listeners','listeners.id', '=', 'album_listener.listener_id')
            ->groupBy('genre')
            ->pluck(DB::raw('count(listener_name) as total'),'genre')
            ->all();
// dd($albums);
        $genreChart = new GenreChart;

        $dataset = $genreChart->labels(array_keys($genre));
        // $dataset = $genreChart->labels(array_keys($albums));
        // $dataset = $genreChart->dataset('Album Genre', 'bar', array_values($albums));
$dataset = $genreChart->dataset('Album Genre', 'line', array_values($genre));
        $dataset = $dataset->backgroundColor(collect(['#7158e2','#3ae374', '#ff3838',"#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"])); //kung gaano karame yung dots
$genreChart->options([
            'responsive' => true,
            // 'legend' => ['display' => true],
            'tooltips' => ['enabled'=> true],
            // 'maintainAspectRatio' =>true,
            'title' => [
                'display'=> true,
                'text' => 'Chart.js Floating Bar Chart'
              ],
              // 'title' => 'genre',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [[
                            'display'=>true,
                            'ticks'=> ['beginAtZero'=> true],
                            'gridLines'=> ['display'=> true],
                          ]],
 'xAxes'=> [[
                            'categoryPercentage'=> 0.8,
                            //'barThickness' => 100,
                            'barPercentage' => 1,
                            'ticks' => ['beginAtZero' => false],
                            'gridLines' => ['display' => true],
                            'display' => true

                          ]],
            ],
     // 'plugins' => '{datalabels: { font: { weight: \'bold\',
                //                          size: 36 },
                //                          color: \'white\',
                //                 }}',
                //                 '{outlabels: {display: true}}',
        ]);
        // dd($genreChart->dataset);


        // dd($albums);
$listenerChart = new ListenerChart;

        $dataset = $listenerChart->labels(array_keys($listener)); //pag wala NULL ito
        // $dataset = $genreChart->labels(array_keys($albums));
        // $dataset = $genreChart->dataset('Album Genre', 'bar', array_values($albums));
 $dataset = $listenerChart->dataset('Album Genre', 'pie', array_values($listener));
        $dataset = $dataset->backgroundColor(collect(['#32a852','#1e6e33', '#0f7028','#98ebae']));
        $listenerChart->options([
            'responsive' => true,
            // 'legend' => ['display' => true],
            'tooltips' => ['enabled'=> true],
            // 'maintainAspectRatio' =>true,
            'title' => [
                'display'=> true,
                'text' => 'Chart.js Floating Bar Chart',
  // 'title' => 'genre',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [[
                            'display'=>true,
                            'ticks'=> ['beginAtZero'=> true],
                            'gridLines'=> ['display'=> true],
                          ]],
'xAxes'=> [[
                            'categoryPercentage'=> 0.8,
                            //'barThickness' => 100,
                            'barPercentage' => 1,
                            'ticks' => ['beginAtZero' => false],
                            'gridLines' => ['display' => true],
                            'display' => true

                          ]],
            ],
        ]
             ]);
        // dd($listenerChart);
        return view('dashboard.index', compact('genreChart', 'listenerChart') );
        }
}

// SELECT count(listener_name) as total, genre  FROM albums inner join `album_listener` on (albums.id = album_listener.album_id) inner join listeners on (listeners.id = album_listener.listener_id) GROUP BY genre;
