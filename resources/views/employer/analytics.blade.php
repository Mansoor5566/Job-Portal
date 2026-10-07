@extends('layouts.employer')
@section('title', 'Analytics')

@section('content')
<style>
    .metrics { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
    .metric-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; }
    .metric-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .metric-label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
    .metric-value { font-size: 26px; font-weight: 700; color: #111827; }
    .metric-sub { font-size: 12px; color: #6b7280; margin-top: 4px; }
    .charts-row { display: grid; grid-template-columns: 1.5fr 1fr; gap: 14px; margin-bottom: 14px; }
    .bottom-row { display: grid; grid-template-columns: 1.5fr 1fr; gap: 14px; }
    .bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
    .bar-label { font-size: 12px; color: #6b7280; width: 90px; text-align: right; flex-shrink: 0; }
    .bar-track { flex: 1; background: #f3f4f6; border-radius: 50px; height: 8px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 50px; }
    .bar-val { font-size: 12px; color: #374151; font-weight: 600; width: 36px; text-align: right; }
</style>
<div style="background:#0C447C;border-radius:12px;padding:24px 28px;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:4px;">
            Welcome back, {{ auth()->user()->name }}! 👋
        </h1>
        <p style="font-size:13px;color:#93c5fd;">Track your Listing and Their Applications</p>
    </div>
    
</div>

<div class="metrics">
    <div class="metric-card">
        <div class="metric-icon" style="background:#eff6ff;">
            <i class="ti ti-file-text" style="color:#185FA5; font-size:20px;"></i>
        </div>
        <div class="metric-label">Total Jobs</div>
        <div class="metric-value">{{ $totalJobs }}</div>
        <div class="metric-sub"><span style="color:#059669;">{{ $activeJobs }}</span> currently active</div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#f0fdf4;">
            <i class="ti ti-send" style="color:#059669; font-size:20px;"></i>
        </div>
        <div class="metric-label">Total Applications</div>
        <div class="metric-value">{{ $totalApplications }}</div>
        <div class="metric-sub">All time</div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#fefce8;">
            <i class="ti ti-star" style="color:#d97706; font-size:20px;"></i>
        </div>
        <div class="metric-label">Shortlisted</div>
        <div class="metric-value">{{ $shortlisted }}</div>
        <div class="metric-sub">
            {{ $totalApplications > 0 ? round(($shortlisted/$totalApplications)*100) : 0 }}% of applications
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#f0fdf4;">
            <i class="ti ti-check" style="color:#059669; font-size:20px;"></i>
        </div>
        <div class="metric-label">Hired</div>
        <div class="metric-value">{{ $hired }}</div>
        <div class="metric-sub">All time</div>
    </div>
</div>

<div class="charts-row">
    <div class="card">
        <div class="card-title">Applications over time (last 7 weeks)</div>
        <div style="display:flex;gap:16px;margin-bottom:12px;">
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;">
                <div style="width:10px;height:10px;border-radius:2px;background:#185FA5;"></div> Applications
            </div>
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;">
                <div style="width:10px;height:10px;border-radius:2px;background:#059669;"></div> Shortlisted
            </div>
        </div>
        <div style="position:relative;height:220px;">
            <canvas id="weeklyChart" role="img" aria-label="Weekly applications chart">Weekly application trends.</canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-title">Status breakdown</div>
        <div style="position:relative;height:180px;margin-bottom:12px;">
            <canvas id="statusChart" role="img" aria-label="Application status donut chart">Status distribution.</canvas>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @php $statusColors = ['applied'=>'#185FA5','viewed'=>'#378ADD','shortlisted'=>'#059669','hired'=>'#d97706','rejected'=>'#dc2626']; @endphp
            @foreach($statusBreakdown as $status => $count)
            <div style="display:flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;">
                <div style="width:8px;height:8px;border-radius:2px;background:{{ $statusColors[$status] ?? '#888' }};"></div>
                {{ ucfirst($status) }}: <strong style="color:#111827;margin-left:2px;">{{ $count }}</strong>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bottom-row">
    <div class="card">
        <div class="card-title">Top performing jobs</div>
        <table>
            <thead><tr><th>Job title</th><th>Applications</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($topJobs as $job)
                <tr>
                    <td><a href="{{ route('employer.jobs.edit',$job) }}" style="color:#185FA5;text-decoration:none;font-weight:500;">{{ Str::limit($job->title,30) }}</a></td>
                    <td><strong>{{ $job->applications_count }}</strong></td>
                    <td><span class="badge badge-{{ $job->status }}">{{ ucfirst($job->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#9ca3af;padding:24px;">No jobs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-title">Applications by status</div>
        @foreach($statusBreakdown as $status => $count)
        @php $pct = $totalApplications > 0 ? round(($count/$totalApplications)*100) : 0; @endphp
        <div class="bar-row">
            <div class="bar-label">{{ ucfirst($status) }}</div>
            <div class="bar-track"><div class="bar-fill" style="width:{{ $pct }}%;background:{{ $statusColors[$status] ?? '#888' }};"></div></div>
            <div class="bar-val">{{ $pct }}%</div>
        </div>
        @endforeach
        @if(empty($statusBreakdown))
            <p style="color:#9ca3af;font-size:13px;text-align:center;padding:20px 0;">No applications yet.</p>
        @endif
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
const weeklyData = @json($weeklyData);
new Chart(document.getElementById('weeklyChart'),{type:'line',data:{labels:weeklyData.map(d=>d.week),datasets:[{label:'Applications',data:weeklyData.map(d=>d.applications),borderColor:'#185FA5',backgroundColor:'rgba(24,95,165,0.08)',fill:true,tension:0.4,pointRadius:4,pointBackgroundColor:'#185FA5',borderWidth:2},{label:'Shortlisted',data:weeklyData.map(d=>d.shortlisted),borderColor:'#059669',backgroundColor:'rgba(5,150,105,0.08)',fill:true,tension:0.4,pointRadius:4,pointBackgroundColor:'#059669',borderWidth:2}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false},ticks:{font:{size:11}}},y:{grid:{color:'rgba(0,0,0,0.04)'},ticks:{font:{size:11},stepSize:1},beginAtZero:true}}}});

const statusData = @json($statusBreakdown);
const statusColors = {applied:'#185FA5',viewed:'#378ADD',shortlisted:'#059669',hired:'#d97706',rejected:'#dc2626'};
new Chart(document.getElementById('statusChart'),{type:'doughnut',data:{labels:Object.keys(statusData).map(s=>s.charAt(0).toUpperCase()+s.slice(1)),datasets:[{data:Object.values(statusData),backgroundColor:Object.keys(statusData).map(s=>statusColors[s]||'#888'),borderWidth:0,hoverOffset:4}]},options:{responsive:true,maintainAspectRatio:false,cutout:'70%',plugins:{legend:{display:false}}}});
</script>
@endsection