{{-- <link rel="stylesheet" href="{{asset('new_css/dashboard.css')}}"> --}}
<div class="report-container">
    <div class="head">
        <h3 style="text-align: center">Hotel Reports</h3><br><br>
        <label>Date : {{ \Carbon\Carbon::parse(now())->format('F d, Y h:i A') }}</label><br>
        <label>From : {{ \Carbon\Carbon::parse($from)->formatLocalized('%B %d, %Y') }}</label><br>
        <label>To :{{ \Carbon\Carbon::parse($end)->formatLocalized('%B %d, %Y') }}</label>
    </div>
    <div class="body">
        <table style="border-collapse: collapse;">
            <thead>
                <tr style="padding: 3em">
                    <th
                        style="border-bottom: 1px solid #dddddd;border-left: 1px solid #dddddd;border-top: 1px solid #dddddd;">
                        NO.</th>
                    <th style="border-bottom: 1px solid #dddddd;border-top: 1px solid #dddddd;">Room</th>
                    <th style="border-bottom: 1px solid #dddddd;border-top: 1px solid #dddddd;">Room Type</th>
                    <th style="border-bottom: 1px solid #dddddd;border-top: 1px solid #dddddd;">Unit Charge (per/day)
                    </th>
                    <th
                        style="border-bottom: 1px solid #dddddd;border-top: 1px solid #dddddd;border-right: 1px solid #dddddd;">
                        Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $roomname = '';
                    $overall_total = 0;
                    $i = 1;
                @endphp
                @foreach ($rooms as $room)
                    @if ($room)
                    @endif
                    <tr>
                        <th style="border-bottom: 1px solid #dddddd">{{ $i++ }}</th>
                        <th style="border-bottom: 1px solid #dddddd">{{ $room->room_name }}</th>
                        <th style="border-bottom: 1px solid #dddddd">{{ $room->room_category }}</th>
                        <th style="border-bottom: 1px solid #dddddd"> {{ number_format($room->price) }}</th>
                        <th style="border-bottom: 1px solid #dddddd"> {{ number_format($room->total_amount) }}</th>
                    </tr>
                    @php
                        $overall_total += $room->total_amount;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <label style="margin-top: 3em;text-align:right">Total Days : {{ $numberOfDays }} </label><br>
        <label style="margin-top: 3em;text-align:right">Total Revenue : {{ number_format($overall_total, 2) }}
            Pesos</label>
    </div>
</div>
