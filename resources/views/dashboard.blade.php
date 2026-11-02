@extends('layout.app')
@section('title', 'Dashboard — RunnerLog')
@section('content')
@include('layout.dashboard-shell-start')
  <main class="main">
    <header class="topbar"><div><p>OVERVIEW</p><h1>Good morning, {{ explode(' ', Auth::user()->name)[0] }}</h1></div></header>
    <div class="stats-grid">
      <article class="card"><small>Weekly distance</small><strong>32.4 <em>km</em></strong><span class="trend">↑ 12%</span></article>
      <article class="card"><small>Total runs</small><strong>24 <em>runs</em></strong><span class="trend">This month</span></article>
      <article class="card"><small>Average pace</small><strong>5:08 <em>/km</em></strong><span class="trend">↑ 9 sec</span></article>
      <article class="card"><small>Average heart rate</small><strong>147 <em>bpm</em></strong><span class="trend">Healthy</span></article>
    </div>
    <div class="dashboard-grid"><section class="card chart-card"><div class="card-head"><h2>Weekly distance</h2><a><a href="{{ route('progress') }}">View progress →</a></a></div><div class="chart">@foreach([42,62,28,78,46,90,64] as $i => $height)<div><i class="{{ $i === 5 ? 'active' : '' }}" style="height:{{ $height }}%"></i><span>{{ ['M','T','W','T','F','S','S'][$i] }}</span></div>@endforeach</div></section>
      <section class="card goal-card"><div class="card-head"><h2>Goal progress</h2><strong>68%</strong></div><div class="goal-track"><span></span></div><p><b>34 km</b> of your 50 km weekly goal</p><a class="primary-button" href="{{ route('runs.create') }}" style="display:block;text-align:center;text-decoration:none">+ Add a run</a></section></div>
    <div class="dashboard-grid lower"><section class="card"><div class="card-head"><h2>Recent activities</h2><a>View all →</a></div>@foreach([['Morning tempo','Oct 30 · Tempo','8.52 km','↗'],['Easy park loop','Oct 28 · Easy','6.24 km','↗'],['Sunday long run','Oct 25 · Long Run','16.80 km','↗']] as $run)<div class="activity"><span>{{ $run[3] }}</span><div><strong>{{ $run[0] }}</strong><small>{{ $run[1] }}</small></div><b>{{ $run[2] }}</b></div>@endforeach</section>
      <section class="card"><div class="card-head"><h2>Personal records</h2></div><div class="record"><small>Fastest 5K</small><strong>24:18</strong></div><div class="record"><small>Longest run</small><strong>16.80 km</strong></div><div class="record"><small>Fastest 10K</small><strong>52:04</strong></div></section></div>
  </main>
</div>
@endsection
