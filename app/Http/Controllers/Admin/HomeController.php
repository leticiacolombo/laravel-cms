<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Visitor;
use App\Page;
use App\User;

class HomeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if ($request->missing('datelimit')) {
            $daysLimit = 30;
        } else {
            $daysLimit = intval($request->input('datelimit'));
        }

        $dateLimit = date('Y-m-d H:i:s', strtotime("-{$daysLimit} days"));

        //Visitantes
        $visitsCount = Visitor::where('date_access', '>=', $dateLimit)->count();

        //Usários Online
        $dateLimitOnline = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $dateLimitOnline)->groupBy('ip')->get();
        $onlineCount = count($onlineList);

        //Páginas
        $pageCount = Page::count();

        //Usuários
        $userCount = User::count();

        //Contage para o PagePie (gráfico)
        $visitsAll = Visitor::selectRaw('page, count(page) as c')
                            ->where('date_access', '>=', $dateLimit)
                            ->groupBy('page')
                            ->get();
        foreach ($visitsAll as $visit) {
            $pagePie[$visit['page']] = intval($visit['c']) ;
        }

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));

        return view('admin.home', [
            'visitsCount' => $visitsCount,
            'onlineCount' => $onlineCount,
            'pageCount' => $pageCount,
            'userCount' => $userCount,
            'pageLabels' => $pageLabels,
            'pageValues' => $pageValues,
            'daysLimit' => $daysLimit
        ]);
    }
}
