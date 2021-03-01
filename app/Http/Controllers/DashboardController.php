<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BooksOrder;
use Illuminate\Http\Request;
use App\Models\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function adminHome(){
        $data = User::all()->count();
        $approved = BooksOrder::where('status','APPROVED')->count();
        $pending = BooksOrder::where('status','PENDING')->count();
        $finished = BooksOrder::where('status','FINISHED')->count();
        $book = Books::where('ready', true)->count();
        $number_blocks = [
            [
                'title' => 'Users Logged In Today',
                'number' => User::whereDate('last_login_at', today())->count()
            ],
            [
                'title' => 'Users Logged In Last 7 Days',
                'number' => User::whereDate('last_login_at', '>', today()->subDays(7))->count()
            ],
            [
                'title' => 'Users Logged In Last 30 Days',
                'number' => User::whereDate('last_login_at', '>', today()->subDays(30))->count()
            ],
        ];
        $list_blocks = [
            [
                'title' => 'Terakhir Login Siswa & Guru',
                'entries' => User::orderBy('last_login_at', 'desc')
                    ->take(5)
                    ->get(),
            ],
            [
                'title' => 'Siswa & Guru tidak Login selama 30 hari',
                'entries' => User::where('last_login_at', '<', today()->subDays(30))
                    ->orwhere('last_login_at', null)
                    ->orderBy('last_login_at', 'desc')
                    ->take(5)
                    ->get()
            ],
        ];
        $chart_settings = [
            'chart_title'        => 'Pemesanan Bulan Ini',
            'chart_type'         => 'line',
            'report_type'        => 'group_by_date',
            'model'              => 'App\\Models\\BooksOrder',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'month',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
        ];
        $chart = new LaravelChart($chart_settings);

        return view('admin.index', compact('data','approved','pending','book','finished','number_blocks','list_blocks','chart'));
    }
    public function Userindex()
    {
        return view('users.index');
    }
}
