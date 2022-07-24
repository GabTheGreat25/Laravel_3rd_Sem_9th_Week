<?php

namespace App\DataTables;

use App\Models\Listener;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ListenersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    // {
    //     return datatables()
    //         ->eloquent($query)
    //         ->addColumn('action', 'listeners.action');
    // }

    {
        // $listeners = Listener::with('albums:album_name')->select('listeners.*');
        $listeners = Listener::with('albums');
        return datatables()
            ->eloquent($listeners)
->addColumn('action', function($row) {
                    return "<a href=". route('listener.edit', $row->id). " class=\"btn btn-warning\">Edit</a> 
                    <form action=". route('listener.destroy', $row->id). " method= \"POST\" >". csrf_field() .
 '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                      </form>';
            })
            ->addColumn('albums', function (Listener $listeners) {
                    return $listeners->albums->map(function($album) {
 // return str_limit($listener->listener_name, 30, '...');
                        return "<li>".$album->album_name. "</li>";
                    })->implode('<br>');
                })
 ->rawColumns(['albums','action']);
            // ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Listener $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Listener $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    // {
    //     return $this->builder()
    //                 ->setTableId('listeners-table')
    //                 ->columns($this->getColumns())
    //                 ->minifiedAjax()
    //                 ->dom('Bfrtip')
    //                 ->orderBy(1)
    //                 ->buttons(
    //                     Button::make('create'),
    //                     Button::make('export'),
    //                     Button::make('print'),
    //                     Button::make('reset'),
    //                     Button::make('reload')
    //                 );
    // }

    {
        return $this->builder()
                    ->setTableId('listeners-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(3)
                    ->buttons(
                       
                        Button::make('export'),
                        // Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
                    // ->parameters([
                    //     'buttons' => ['excel','pdf','csv'],
                    // ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    // {
    //     return [
    //         Column::computed('action')
    //               ->exportable(false)
    //               ->printable(false)
    //               ->width(60)
    //               ->addClass('text-center'),
    //         Column::make('id'),
    //         Column::make('add your columns'),
    //         Column::make('created_at'),
    //         Column::make('updated_at'),
    //     ];
    // }

      {
        return [
            
            Column::make('id'),
            Column::make('listener_name')->title('listener'),
Column::make('albums')->name('albums.album_name')->title('albums'),
            // Column::make('albums')->title('albums'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Listeners_' . date('YmdHis');
    }
}
