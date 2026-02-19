<?php

namespace Modules\HomePage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $seo = [
            'title' => 'VertexOh! Pro - Planejamento Escolar com IA',
            'description' => 'Reduza seu tempo de planejamento em 80%. O VertexOh! Pro oferece criador de planos de aula com IA, diários digitais e relatórios automáticos.',
            'image' => asset('assets/images/og-home.jpg'),
        ];
        return view('HomePage::index', compact('seo'));
    }

    public function create()
    {
        return view('HomePage::create');
    }

    public function store(Request $request) {}

    public function show($id)
    {
        return view('HomePage::show');
    }

    public function edit($id)
    {
        return view('HomePage::edit');
    }

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function terms()
    {
        return view('HomePage::legal.terms');
    }

    public function privacy()
    {
        return view('HomePage::legal.privacy');
    }

    public function contact()
    {
        return view('HomePage::contact');
    }

    public function about()
    {
        return view('HomePage::about');
    }

    public function faq()
    {
        return view('HomePage::faq');
    }

    public function plans()
    {
        $plans = Plan::active()->ordered()->get();
        return view('HomePage::plans', compact('plans'));
    }
}
